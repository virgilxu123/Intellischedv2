<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\AcademicYearTerm;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlottedClassSchedules;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportPlottedSchedule(AcademicYearTerm $academicYearTerm) {
        return Excel::download(new PlottedClassSchedules($academicYearTerm), 'rooms-mapping.xlsx');
    }

    public function viewPDF(Faculty $faculty, AcademicYearTerm $academicYearTerm)
    {
        $classes = $faculty->class_schedules()->where('academic_year_term_id', $academicYearTerm->id)
            ->with('subject', 'block', 'classroom', 'load_type', 'days')
            ->get();
        $designations = $faculty->designations()->wherePivot('academic_year_term_id', $academicYearTerm->id)->get();
        $academicYearTerm->load('term', 'academic_year');
        $pdf = PDF::loadView('exports.faculty-load-view-pdf', ['faculty'=>$faculty, 'academicYearTerm'=>$academicYearTerm, 'designations'=>$designations, 'classes'=>$classes]);
        return $pdf->stream();
    }
    
}
