<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\AcademicYearTerm;

class ClassScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AcademicYearTerm $academicYearTerm)
    {
        $subjects = Subject::where('term_id', $academicYearTerm->term_id)->get();
        $classSchedules = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty', 'days');
        $subjects = $subjects->sortBy('year_level');
        $rooms = Classroom::all();
        $classSchedules = $classSchedules->sortBy(function ($schedule) {
            $yearLevel = optional($schedule->subject)->year_level;
            $subjectCode = optional($schedule->subject)->subject_code;
            return [$yearLevel, $subjectCode];
        });
        $classSchedulesWithRooms = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->whereNotNull('classroom_id')->get();
        $classSchedulesWithRooms->load('subject', 'block', 'classroom', 'faculty', 'days');
        if (request()->ajax()) {
            return response()->json([
                'classSchedulesWithRooms' => $classSchedulesWithRooms,
                'classSchedules' => $classSchedules,
                'subjects' => $subjects,
                'academicYearTerm' => $academicYearTerm,
                'rooms' => $rooms,
            ]);
        }
        return view('create-schedule', compact('classSchedules', 'subjects', 'academicYearTerm', 'rooms'));
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
            for ($i = 1; $i <= $validated['blocks']; $i++) {
                $classSchedule = new ClassSchedule();
                $classSchedule->subject_id = $subject_id;
                $classSchedule->academic_year_term_id = $academicYearTerm->id;
                $classSchedule->block_id = $i;
                $classSchedule->save();
            }
        }
        return back()->with('success', 'Class Schedule has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty, AcademicYearTerm $academicYearTerm)
    {
        $classSchedules = ClassSchedule::whereIn('faculty_id', $faculty)
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty', 'days');
        return response()->json(['classSchedules' => $classSchedules]);
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
            $classSchedule->save();
        });
        $classSchedules = ClassSchedule::where('faculty_id', $faculty->id)->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty',);
        return response()->json(['message' => 'Class Schedules have been assigned to faculty.', 'classSchedules' => $classSchedules]);
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
        $conflicts = $classSchedule->checkForFacultyTimeConflicts($validated['time_start'], $time_end, $validated['day_id'], $classSchedule);
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
}
