<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\AcademicYearTerm;
use App\Models\Day;
use Illuminate\Support\Facades\Http;
use App\Services\GenerateScheduleService;

class GenerateScheduleController extends Controller
{
    protected $GenerateScheduleService;

    public function __construct(GenerateScheduleService $GenerateScheduleService)
    {
        $this->GenerateScheduleService = $GenerateScheduleService;
    }
    public function generateSchedule(AcademicYearTerm $academicYearTerm, Day $day) {
        if($day->id == 2){
            $yearLevel = ['First Year', 'Fourth Year'];
        }
        if($day->id == 3) {
            $yearLevel = ['Second Year', 'Third Year'];
        }
        $classes = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)
            ->whereIn('subjects.year_level', $yearLevel) // Filter by year levels
            ->whereNotNull('class_schedules.faculty_id')
            ->where('class_schedules.units', 3)
            ->select('class_schedules.faculty_id', 'subjects.year_level', 'class_schedules.block_id', 'subjects.lab_type', 'class_schedules.id')
            ->join('subjects', 'class_schedules.subject_id', '=', 'subjects.id') // Join with subjects table
            ->orderBy('class_schedules.faculty_id', 'asc')
            ->orderBy('subjects.lab_type', 'asc')
            ->get();
        $data = $classes->toJson();
        // return \response()->json($classes);
        // Send data to Flask app
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('http://localhost:5000/process_data', [
                'data' => $data,
            ]);

         // Check if request was successful
         if ($response->successful()) {
            // Get response data
            $responseData = $response->json();
            $room0  = [
                '601',
                'Internet Lab 2',
            ];
            $room1 = [
                '501',
                '502',
                'Internet Lab 1',
                'Internet Lab 3',
            ];
            $room2 = [
                '602',
                '603',
            ];
            $time = [
                '1'=> '07:30 AM',
                '2'=> '09:00 AM',
                '3'=> '10:30 AM',
                '4'=> '01:00 PM',
                '5'=> '02:30 PM',
                '6'=> '04:00 PM',
                '7'=> '05:30 PM',
            ];
            for($i=0;$i<count($responseData);$i++){
                $dominantLabType = $this->GenerateScheduleService->getDominantLabType($responseData[$i]);
                if($dominantLabType==2) {
                    if($room2) {
                        $room = array_shift($room2);
                    }else if($room1) {
                        $room = array_shift($room1);
                    }else {
                        $room = array_shift($room0);
                    }
                    for($j=0;$j<count($responseData[$i]);$j++){
                        $responseData[$i][$j]['room'] = $room;
                        $responseData[$i][$j]['timeslot'] = $time[$responseData[$i][$j]['timeslot']];
                    }
                }
            }
            for($i=0;$i<count($responseData);$i++) {
                $dominantLabType = $this->GenerateScheduleService->getDominantLabType($responseData[$i]);
                if($dominantLabType==0) {
                    if($room0) {
                        $room = array_shift($room0);
                    }else if($room1) {
                        $room = array_shift($room1);
                    }else {
                        $room = array_shift($room2);
                    }
                    for($j=0;$j<count($responseData[$i]);$j++) {
                        $responseData[$i][$j]['room'] = $room;
                        $responseData[$i][$j]['timeslot'] = $time[$responseData[$i][$j]['timeslot']];
                    }
                }
            }
            for($i=0;$i<count($responseData);$i++) {
                $dominantLabType = $this->GenerateScheduleService->getDominantLabType($responseData[$i]);
                if($dominantLabType==1) {
                    if($room1) {
                        $room = array_shift($room1);
                    }else if($room2) {
                        $room = array_shift($room2);
                    }else {
                        $room = array_shift($room0);
                    }
                    for($j=0;$j<count($responseData[$i]);$j++) {
                        $responseData[$i][$j]['room'] = $room;
                        $responseData[$i][$j]['timeslot'] = $time[$responseData[$i][$j]['timeslot']];
                    }
                }
            }
            
            $flattenedData = array_merge(...$responseData);
            $this->GenerateScheduleService->assignTimeRoomDay($flattenedData);
            // return $flattenedData;
            return response()->json(['message' => 'Schedule assigned successfully']);
        } else {
            // Handle the case where the request was not successful
            return response()->json(['error' => 'Failed to send data to Flask app'], $response->status());
        }
    }
}
