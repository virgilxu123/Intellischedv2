<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $numberOfFacultyMembers = Faculty::count();
        $numberOfAvailableFacultyMembers = Faculty::where('availability', true)->count();
        $numberOfUnAvailableFacultyMembers = Faculty::where('availability', false)->count();
        return view('dashboard', compact('numberOfFacultyMembers', 'numberOfAvailableFacultyMembers', 'numberOfUnAvailableFacultyMembers'));
    }
}
