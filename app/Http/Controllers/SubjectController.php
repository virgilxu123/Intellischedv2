<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('term')->get();
        $prerequisites = '';
        $customOrder = [
            'First Year' => 1,
            'Second Year' => 2,
            'Third Year' => 3,
            'Fourth Year' => 4,
        ];
        // Generate the CASE SQL
        $orderByClause = 'CASE year_level';
        foreach ($customOrder as $level => $order) {
            $orderByClause .= " WHEN '{$level}' THEN {$order}";
        }
        $orderByClause .= ' END';

        $prerequisites = Subject::where('subject_type', 'major')
            ->orderByRaw($orderByClause)
            ->get();
        return view('manage-subjects', compact('subjects', 'prerequisites'));
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
            'course_code' => 'required|unique:subjects,course_code',
            'description' => 'required',
            'units' => 'required',
            'year_level' => 'required',
            'term_id' => 'required',
            'subject_type' => 'required',
            'laboratory' => 'required',
        ]);
        // Create a new faculty using mass assignment
        $subject = Subject::create($validatedData);
        $subject->load('term'); // Load the term relationship

        if (request()->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Subject created successfully!', 
                'subject' => $subject
            ]);
        }

        return redirect()->route('manage-subjects')->with('success', 'Subject created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('term');
        $subject->term_name = $subject->term->term;

        return response()->json($subject);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validatedData = $request->validate([
            'course_code' => 'required|unique:subjects,course_code,'. $subject->id,
            'description' => 'required',
            'prerequisite' => 'nullable|string',
            'units' => 'required',
            'year_level' => 'required',
            'term_id' => 'required',
            'subject_type' => 'required',
            'laboratory' => 'required',
        ]);
        $subject->update($validatedData);
        // Include the term data in the response
        $subject->load('term'); // Load the term relationship
        $subject->term_name = $subject->term->term; // Add the term name to the subject object

        return response()->json(['success' => true, 'message' => 'Changes has been saved!', 'updatedData' => $subject]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json(['success' => true, 'message' => 'Subject has been deleted!','deletedData' => ['id' => $subject->id]]);
    }
}
