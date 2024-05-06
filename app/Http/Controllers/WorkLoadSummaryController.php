<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Signatory;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AcademicYearTerm;

class WorkLoadSummaryController extends Controller
{
    public function index() {
        $academicYearTerms = AcademicYearTerm::all();
        $academicYearTerms->load('academic_year', 'term');
        return view('workload-summary', compact('academicYearTerms'));
    }

    public function viewWorkLoad(AcademicYearTerm $academicYearTerm) {
        $faculties = Faculty::all();
        $campusDirector = Signatory::where('position', 'Campus Director')->first();
        $VPForAcadAffairs = Signatory::where('position', 'Vice President for Academic Affairs')->first();
        $pdf = PDF::loadView('exports.summary-work-load', [
            'academicYearTerm' => $academicYearTerm, 
            'VPForAcadAffairs' => $VPForAcadAffairs, 
            'campusDirector' => $campusDirector, 
            'faculties' => $faculties
        ], [
            'paper' => 'letter' // Specify the paper size here
        ]);
        return $pdf->stream();
    }        
}
