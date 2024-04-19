<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Classroom::all();

        return view('manage-rooms', compact('rooms'));
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
            'room_number' => 'required',
            'capacity' => 'required',
            'type' => 'required',
        ]);
        // Create a new faculty using mass assignment
        $room = Classroom::create($validatedData);

        return redirect()->route('manage-rooms')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $validatedData = $request->validate([
            'room_number' => 'required',
            'capacity' => 'required',
            'type' => 'required',
            'availability' => 'required',
        ]);
        $classroom->update($validatedData);
        return redirect()->route('manage-rooms')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->back()->with('deleted', 'Room has been deleted!');
    }
}
