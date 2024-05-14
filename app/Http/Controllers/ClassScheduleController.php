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
use Illuminate\Http\JsonResponse;
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
        $classSchedules = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->where('units', 3)->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty', 'days');
        $subjects = $subjects->sortBy('year_level');
        $rooms = Classroom::all();
        $classSchedulesWithRooms = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->whereNotNull('classroom_id')->where('units', 3)->get();
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
    public function openClasses(Request $request, AcademicYearTerm $academicYearTerm)
    {
        $validated = $request->validate([
            'subjectId' => '',
            'blocks' => 'required',
        ]);
        if (is_array($validated['subjectId'])) {
            // Handle array of subject IDs
            $subject_ids = array_map('intval', explode(',', $validated['subjectId'][0])); //Retrieve the string of subject IDs and Split the string into an array of individual IDs: convert to int
            foreach ($subject_ids as $subject_id) {
                $this->classScheduleService->createAdjustBlocks($subject_id, $validated['blocks'], $academicYearTerm);
            }
        } else {
            // Handle single subject ID
            $subject_id = intval($validated['subjectId']);
            $this->classScheduleService->createAdjustBlocks($subject_id, $validated['blocks'], $academicYearTerm);
        }
        if (\request()->ajax()) {
            return response()->json(['message' => 'Block count updated successfully!']);
        }
        return back()->with('success', 'Subjects successfully opened!');
    }

    public function updateBlockCount(Request $request, AcademicYearTerm $academicYearTerm)
    {
        $validated = $request->validate([
            'subjectId' => 'required',
            'blocks' => 'required',
        ]);
        $this->classScheduleService->createAdjustBlocks($validated['subjectId'], $validated['blocks'], $academicYearTerm);
        return response()->json(['message' => 'Block count updated successfully!']);
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
        $totalLoad = $faculty->totalLoad($academicYearTerm);
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

        $faculty->assignClassSchedules($classSchedules);
        $classSchedules = $faculty->class_schedules()->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty');
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
        $conflicts = $classSchedule->checkForFacultyBlockTimeConflicts($validated['time_start'], $time_end, $validated['day_id'], $validated['room_id']);
        if ($conflicts) {
            return response()->json(['error' => 'Time conflict with existing class schedules.'], 409);
        }
        $scheduleForLabAndLec = ClassSchedule::selectBothLabAndLecClasses($classSchedule->subject_id, $classSchedule->block_id);
        foreach ($scheduleForLabAndLec as $schedule){
            $schedule->time_start = $validated['time_start'];
            $schedule->classroom_id = $validated['room_id'];
            $schedule->time_end = $time_end;
            $schedule->save();
    
            // Attach the day to the class schedule
            $schedule->days()->attach($validated['day_id']);
            if($validated['day_id']!==4){
                $schedule->days()->attach($validated['day_id'] + 3);
            }
        }
        return response()->json(['message' => 'Time and Room have been assigned to class schedule.', 'classSchedule' => $classSchedule]);
    }

    public function deleteAssignedTimeRoomDay(Request $request, ClassSchedule $classSchedule)
    {
        $scheduleForLabAndLec = ClassSchedule::selectBothLabAndLecClasses($classSchedule->subject_id, $classSchedule->block_id);
        foreach ($scheduleForLabAndLec as $schedule) {
            $schedule->days()->detach();
    
            // Reset class schedule attributes
            $schedule->time_start = null;
            $schedule->time_end = null;
            $schedule->classroom_id = null;
            $schedule->save();
        }
        return response()->json(['message' => 'Time and Room have been removed from class schedule.', 'classSchedule' => $classSchedule]);
    }

    public function updateLoadType(Request $request, ClassSchedule $classSchedule)
    {
        $validated = $request->validate([
            'load_type' => 'required',
        ]);
        $response = $classSchedule->assignLoadType($validated['load_type']);
        if ($response instanceof JsonResponse) {
            return $response;
        }
        $faculty = $classSchedule->faculty;
        $regularLoad = $faculty->regularLoad($classSchedule->academic_year_term);
        $overLoad = $faculty->overLoad($classSchedule->academic_year_term);
        $emergencyLoad = $faculty->emergencyLoad($classSchedule->academic_year_term);
        $praiseLoad = $faculty->praiseLoad($classSchedule->academic_year_term);
        return response()->json(['message' => 'Load Type has been updated.', 'classSchedule' => $classSchedule, 'regularLoad'=>$regularLoad, 'overLoad'=>$overLoad, 'emergencyLoad'=>$emergencyLoad, 'praiseLoad'=>$praiseLoad]);
    }

    public function updateNumberOfStudents(Request $request, ClassSchedule $classSchedule)
    {
        $validated = $request->validate([
            'student_count' => 'required',
        ]);
        $labSchedule = null;
        if ($classSchedule->subject->laboratory == 'Yes') {
            $labSchedule = ClassSchedule::where('subject_id', $classSchedule->subject_id)
                ->where('block_id', $classSchedule->block_id)
                ->where('class_type', 'laboratory')
                ->first();
            $labSchedule->student_count = $validated['student_count'];
            $labSchedule->save();
        }
        $classSchedule->student_count = $validated['student_count'];
        $classSchedule->save();
        return response()->json(['message' => 'Number of students updated successfully', 'labSchedule' => $labSchedule]);
    }
}
