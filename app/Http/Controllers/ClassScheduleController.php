<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Designation;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\AcademicYearTerm;
use App\Services\ClassScheduleService;

class ClassScheduleController extends Controller
{
    protected $classScheduleService;

    public function __construct(ClassScheduleService $classScheduleService)
    {
        $this->classScheduleService = $classScheduleService;
    }

    public function index(AcademicYearTerm $academicYearTerm)
    {
        $designations = Designation::all();
        $subjects = Subject::where('term_id', $academicYearTerm->term_id)->get();
        $classSchedules = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty', 'days');
        $subjects = $subjects->sortBy('year_level');
        $rooms = Classroom::all();
        $classSchedulesWithRooms = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->whereNotNull('classroom_id')->get();
        $classSchedulesWithRooms->load('subject', 'block', 'classroom', 'faculty', 'days');
        if (request()->ajax()) {
            return response()->json([
                'designations' => $designations,
                'classSchedulesWithRooms' => $classSchedulesWithRooms,
                'classSchedules' => $classSchedules,
                'subjects' => $subjects,
                'academicYearTerm' => $academicYearTerm,
                'rooms' => $rooms,
            ]);
        }
        return view('create-schedule', compact('classSchedules', 'subjects', 'academicYearTerm', 'rooms', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AcademicYearTerm $academicYearTerm)
    {
        $validated = $request->validate([
            'subjectId' => 'required',
            'blocks' => 'required',
        ]);
        $subject_ids = array_map('intval', explode(',', $validated['subjectId'][0])); //Retrieve the string of subject IDs and Split the string into an array of individual IDs: convert to int
        foreach ($subject_ids as $subject_id) {
            $this->classScheduleService->createAdjustBlocks($subject_id,$validated['blocks'],$academicYearTerm);
        }
        return back()->with('success', 'Subjects successfully opened!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty, AcademicYearTerm $academicYearTerm)
    {
        $classSchedules = $faculty->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty', 'days');
        $totalLoad = $faculty->loadCalculation($academicYearTerm);
        return response()->json(['classSchedules' => $classSchedules, 'totalLoad' => $totalLoad]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassSchedule $classSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassSchedule $classSchedule)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassSchedule $classSchedule)
    {
        //
    }

    public function assignClassSchedulesToFaculty(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'class_ids' => 'required',
        ]);
        // Extract class IDs from the request
        $classIds = explode(',', $validated['class_ids'][0]);

        // Find class schedules based on the provided class IDs
        $classSchedules = ClassSchedule::whereIn('id', $classIds)->get();

        // Assign the faculty to each class schedule
        $classSchedules->each(function ($classSchedule) use ($faculty) {
            $classSchedule->faculty_id = $faculty->id;
            if ($classSchedule->subject->laboratory == 'Yes') { //assign also the laboratory class to faculty
                $labSchedule = ClassSchedule::where('subject_id', $classSchedule->subject_id)
                    ->where('block_id', $classSchedule->block_id)
                    ->where('class_type', 'laboratory')
                    ->first();
                $labSchedule->faculty_id = $faculty->id;
                $labSchedule->save();
            }
            $classSchedule->save();
        });
        $classSchedules = ClassSchedule::where('faculty_id', $faculty->id)->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty',);
        return response()->json(['message' => 'Class Schedules have been assigned to faculty.', 'classSchedules' => $classSchedules]);
    }

    public function unAssignClassScheduleFromFaculty(ClassSchedule $classSchedule)
    {
        $subject_id = $classSchedule->subject_id;
        $block_id = $classSchedule->block_id;
        $classSchedules = ClassSchedule::selectBothLabAndLecClasses($subject_id, $block_id);
        $classSchedules->each(function ($classSchedule) {
            $classSchedule->days()->detach();
            $classSchedule->faculty_id = null;
            $classSchedule->time_start = null;
            $classSchedule->time_end = null;
            $classSchedule->classroom_id = null;
            $classSchedule->load_type_id = null;
            $classSchedule->student_count = 0;
            $classSchedule->save();
        });
        return response()->json(['message' => 'Class has been unassigned from faculty.', 'classSchedule' => $classSchedule]);
    }

    public function assignTimeRoomDay(Request $request, ClassSchedule $classSchedule)
    {
        $validated = $request->validate([
            'time_start' => 'required',
            'room_id' => 'required',
            'day_id' => 'required',
        ]);
        // Check for time conflicts
        $time_end = date('h:i A', strtotime($validated['time_start'] . ' +90 minutes'));
        $conflicts = $classSchedule->checkForFacultyBlockTimeConflicts($validated['time_start'], $time_end, $validated['day_id']);
        if ($conflicts) {
            return response()->json(['error' => 'Time conflict with existing class schedules.'], 409);
        }
        $classSchedule->time_start = $validated['time_start'];
        $classSchedule->classroom_id = $validated['room_id'];
        $classSchedule->time_end = $time_end;
        $classSchedule->save();

        // Attach the day to the class schedule
        $classSchedule->days()->attach($validated['day_id']);
        $classSchedule->days()->attach($validated['day_id'] + 3);
        return response()->json(['message' => 'Time and Room have been assigned to class schedule.', 'classSchedule' => $classSchedule]);
    }

    public function deleteAssignedTimeRoomDay(Request $request, ClassSchedule $classSchedule)
    {
        $classSchedule->days()->detach();

        // Reset class schedule attributes
        $classSchedule->time_start = null;
        $classSchedule->time_end = null;
        $classSchedule->classroom_id = null;
        $classSchedule->save();
        return response()->json(['message' => 'Time and Room have been removed from class schedule.', 'classSchedule' => $classSchedule]);
    }

    public function updateLoadType(Request $request, ClassSchedule $classSchedule)
    {
        $validated = $request->validate([
            'load_type' => 'required',
        ]);
        $classSchedule->load_type_id = $validated['load_type'];
        $classSchedule->save();
        $faculty = $classSchedule->faculty;
        $regularLoad = $faculty->loadCalculationByType($classSchedule->academic_year_term, 'Regular Load');
        $overLoad = $faculty->loadCalculationByType($classSchedule->academic_year_term, 'Overload');
        return response()->json(['message' => 'Load Type has been updated.', 'classSchedule' => $classSchedule, 'regularLoad' => $regularLoad, 'overLoad' => $overLoad]);
    }

    public function updateNumberOfStudents(Request $request, ClassSchedule $classSchedule)
    {
        $validated = $request->validate([
            'student_count' => 'required',
        ]);

        $classSchedule->student_count = $validated['student_count'];
        $classSchedule->save();
        return response()->json(['message' => 'Number of students updated successfully']);
    }
}
