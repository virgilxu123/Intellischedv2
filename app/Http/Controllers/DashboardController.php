<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearTerm;
use App\Models\ClassSchedule;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $numberOfFacultyMembers = Faculty::count();
        $numberOfAvailableFacultyMembers = Faculty::where('availability', true)->count();
        $numberOfUnAvailableFacultyMembers = Faculty::where('availability', false)->count();
        $academicYearTerm = AcademicYearTerm::all()->sortByDesc('created_at')->first();
        $numberOfClasses = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->count();
        $numberOfScheduledClasses = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->whereNotNull('classroom_id')->count();
        $numberOfUnScheduledClasses = ClassSchedule::where('academic_year_term_id', $academicYearTerm->id)->whereNull('classroom_id')->count();
        return view('dashboard', compact('numberOfFacultyMembers', 'numberOfAvailableFacultyMembers', 'numberOfUnAvailableFacultyMembers', 'numberOfClasses', 'numberOfScheduledClasses', 'numberOfUnScheduledClasses'));
    }
}
