<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\AcademicYearTerm;
use App\Models\DesignationFaculty;

class DesignationFacultyController extends Controller
{
    public function assignDesignation(Request $request, Faculty $faculty, AcademicYearTerm $academicYearTerm)
    {
        $validatedData = $request->validate([
            'designation_id' => 'required|exists:designations,id',
        ]);
        $faculty->designations()->attach($validatedData['designation_id'], ['academic_year_term_id' => $academicYearTerm->id]);
        return response()->json(['success' => true, 'message' => 'Designation has been added to faculty!']);
    }

    public function showDesignation(Faculty $faculty, AcademicYearTerm $academicYearTerm)
    {
        $designations = $faculty->designations()->wherePivot('academic_year_term_id', $academicYearTerm->id)->get();
        $allFacultiesDesignations = array();
        $faculties = Faculty::all();
        foreach ($faculties as $faculty) {
            foreach ($faculty->designations()->wherePivot('academic_year_term_id', $academicYearTerm->id)->get() as $designation) {
                array_push($allFacultiesDesignations, $designation);
            }
        }
        $designationsWithUniqueOne = collect($allFacultiesDesignations)->filter(function ($designation) {
            return $designation->unique == 1;
        });
        $designationIdsWithUniqueOne = $designationsWithUniqueOne->pluck('id')->toArray();
        $designationsToDisplayInOptions = Designation::whereNotIn('id', $designationIdsWithUniqueOne)->get();
        return response()->json(['designations' => $designations, 'designationsToDisplayInOptions' => $designationsToDisplayInOptions]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignationFaculty $designationFaculty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignationFaculty $designationFaculty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesignationFaculty $designationFaculty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignationFaculty $designationFaculty)
    {
        //
    }
}
