<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::all();
        if(request()->ajax()){
            return response()->json($designations);
        }
        return view('manage-designations', compact('designations'));
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
            'designation' => 'required',
            'units' => 'required',
            'unique' => 'required',
        ]);
        // Create a new designation using mass assignment
        $designation = Designation::create($validatedData);
        if(request()->ajax()){
            return response()->json([$designation]);
        }
        return redirect()->route('manage-designations')->with('success', 'Designation created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        $validatedData = $request->validate([
            'designation' => 'required',
            'units' => 'required',
            'unique' => 'required',
        ]);
        $designation->update($validatedData);
        if(request()->ajax()){
            return response()->json([$designation]);
        }
        return redirect()->route('manage-designations')->with('success', 'Designation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        if(request()->ajax()){
            return response()->json(['deleted' => 'Designation deleted successfully!']);
        }
        return redirect()->route('manage-designations')->with('deleted', 'Designation has been deleted!');
    }
}
