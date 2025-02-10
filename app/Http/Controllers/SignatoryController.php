<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\Request;

class SignatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $signatories = Signatory::all();
        return view('manage-signatories', compact('signatories'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_initial' => 'required',
            'educ_qualification'  => '',
            'position' => 'required',
        ]);
        Signatory::create($validatedData);
        return redirect()->route('manage-signatories');
    }

    /**
     * Display the specified resource.
     */
    public function show(Signatory $signatory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signatory $signatory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signatory $signatory)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_initial' => 'required',
            'educ_qualification' => '',
            'position' => 'required',
        ]);
        $signatory->update($validatedData);

        return redirect()->route('manage-signatories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Signatory $signatory)
    {
        //
    }
}
