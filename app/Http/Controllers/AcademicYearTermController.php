<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Subject;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\AcademicYearTerm;

class AcademicYearTermController extends Controller
{
    public function index() {
        $terms = Term::all();
        $academicYear = AcademicYear::orderBy('year_start', 'desc')->first();//get the the latest year in db-> this will be used to check if there is a need to create new year
        $academicYearTerms = AcademicYearTerm::all()->sortByDesc('created_at');
        $academicYearTerms->load('academic_year', 'term');
        $academicYears = [$academicYear->year_start, $academicYear->year_start - 1];
        if($academicYear->year_start != Date('Y')){//if latest year not equal to current year
            $academicYears = [$academicYear->year_start + 1, $academicYear->year_start];//increment latest year->to be used in the select input when creating new schedule
        }
        return view('schedule', compact('academicYearTerms', 'terms', 'academicYears'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'year' => 'required',
            'term' => 'required',
        ]);

        $academicYear = AcademicYear::where('year_start', $validatedData['year'])->first();
        if (!$academicYear) {
            // Create a new academic year if it doesn't exist
            $academicYear = new AcademicYear();
            $academicYear->year_start = $validatedData['year'];
            // Add any additional fields if needed
            $academicYear->save();
        }

        // Create the academic year term record
        $academicYearTerm = new AcademicYearTerm();
        $academicYearTerm->academic_year_id = $academicYear->id;
        $academicYearTerm->term_id = $request->input('term');
        $academicYearTerm->save();

        return redirect()->route('schedule')->with('success', 'Academic year term created successfully.');
    }

    public function show(AcademicYearTerm $academicYearTerm)
    {
        //
    }
}
