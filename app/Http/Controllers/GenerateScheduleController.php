<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\AcademicYearTerm;
use Illuminate\Support\Facades\Http;

class GenerateScheduleController extends Controller
{
    public function generateSchedule(AcademicYearTerm $academicYearTerm) {
        $classesForMTh = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)
            ->whereNull('time_start')
            ->whereNull('classroom_id')
            ->whereIn('subjects.year_level', ['First Year', 'Fourth Year']) // Filter by year levels
            ->whereNotNull('class_schedules.faculty_id')
            ->where('class_schedules.units', 3)
            ->select('class_schedules.faculty_id', 'subjects.year_level', 'class_schedules.block_id', 'subjects.lab_type', 'class_schedules.id')
            ->join('subjects', 'class_schedules.subject_id', '=', 'subjects.id') // Join with subjects table
            ->orderBy('class_schedules.faculty_id', 'asc')
            ->get();
        
        $data = $classesForMTh->toJson();

        // Send data to Flask app
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('http://localhost:5000/process_data', [
                'data' => $data,
            ]);

         // Check if request was successful
         if ($response->successful()) {
            // Get response data
            $responseData = $response->json();

            // Do something with the response data
            // For example, return it from this controller method
            return $responseData;
        } else {
            // Handle the case where the request was not successful
            return response()->json(['error' => 'Failed to send data to Flask app'], $response->status());
        }
    }
}
