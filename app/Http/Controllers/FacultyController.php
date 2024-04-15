<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\LoadType;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AcademicYearTerm;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::all()
            ->sortBy('first_name');
        if (request()->ajax()) {
            return response()->jason(['faculties' => $faculties]);
        }

        return view('manage-faculty', compact('faculties'));
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
        $validatedData = $request->validate([
            'first_name' => [
                'required',
                Rule::unique('faculties')->where(function ($query) use ($request) {
                    return $query->where('last_name', $request->input('last_name'));
                }),
            ],
            'last_name' => 'required|string|max:255',
            'middle_initial' => '',
            'rank' => '',
            'status' => 'required|string|max:255',
        ]);

        // Create a new faculty using mass assignment
        $faculty = Faculty::create($validatedData);

        if ($faculty) {

            return redirect()->route('manage-faculty')->with('success', 'Faculty created successfully!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty, AcademicYearTerm $academicYearTerm = null)
    {
        $loadTypes = LoadType::all();
        $rooms = Classroom::all();
        if ($academicYearTerm == null)  {
            $academicYearTerm = AcademicYearTerm::latest()->first();
        }
        $classes = $faculty->class_schedules()->where('academic_year_term_id', $academicYearTerm->id)
            ->with('subject', 'block', 'classroom', 'load_type', 'days')
            ->get();
        
        $regularLoad = $faculty->regularLoad($academicYearTerm);
        $overLoad = $faculty->overLoad($academicYearTerm);
        $emergencyLoad = $faculty->emergencyLoad($academicYearTerm);
        $praiseLoad = $faculty->praiseLoad($academicYearTerm);
        $totalLoad = $regularLoad+$overLoad+$emergencyLoad+$praiseLoad;
        $designations = $faculty->designations()->wherePivot('academic_year_term_id', $academicYearTerm->id)->get();

        if (request()->ajax()) {
            return response()->json(['faculty' => $faculty, 'classes' => $classes, 'loadTypes' => $loadTypes, 'rooms' => $rooms, 'regularLoad' => $regularLoad, 'overLoad' => $overLoad, 'academicYearTerm' => $academicYearTerm, 'emergencyLoad' => $emergencyLoad, 'praiseLoad' => $praiseLoad]);
        }
        return view('profile.faculty', compact('faculty', 'classes', 'loadTypes', 'totalLoad', 'designations', 'rooms', 'regularLoad', 'overLoad', 'academicYearTerm', 'emergencyLoad', 'praiseLoad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        //
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        // Define custom validation rule
        $uniqueName = Rule::unique('faculties')->where(function ($query) use ($request, $faculty) {
            return $query->where('first_name', $request->first_name)
                ->where('last_name', '!=', $request->last_name) // Ensure last name is different
                ->orWhere('first_name', '!=', $request->first_name) // Ensure first name is different
                ->where('last_name', $request->last_name);
        });
        $validatedData = $request->validate([
            'first_name' => ['required', $uniqueName],
            'last_name' => ['required', $uniqueName],
            'middle_initial'  => '',
            'rank' => '',
            'status' => 'required',
            'availability'  => '',
        ]);
        $faculty->update($validatedData);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Changes has been saved!', 'updatedData' => $faculty]);
        }
        return back()->with(['success' => 'Information has been updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Faculty deleted successfully!', 'deletedData' => ['id' => $faculty->id]]);
        }
        return redirect()->route('manage-faculty')->with('delete', 'A faculty member has been deleted!');
    }
}
