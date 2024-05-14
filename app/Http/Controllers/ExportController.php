<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\AcademicYearTerm;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlottedClassSchedules;
use App\Models\Signatory;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportPlottedSchedule(AcademicYearTerm $academicYearTerm)
    {
        return Excel::download(new PlottedClassSchedules($academicYearTerm), 'rooms-mapping.xlsx');
    }

    public function viewPDF(Faculty $faculty, AcademicYearTerm $academicYearTerm)
    {
        $classes = $faculty->class_schedules()->where('academic_year_term_id', $academicYearTerm->id)
            ->with('subject', 'block', 'classroom', 'load_type', 'days')
            ->get();
        $designations = $faculty->designations()->where('unique', 1)->wherePivot('academic_year_term_id', $academicYearTerm->id)->get();
        $mandatoryDeLoading = $faculty->designations()->where('unique', 0)->wherePivot('academic_year_term_id', $academicYearTerm->id)->first();
        $specialAssignment = $faculty->designations()->where('unique', 0)->wherePivot('academic_year_term_id', $academicYearTerm->id)->skip(1)->take(1)->first();
        $academicYearTerm->load('term', 'academic_year');
        $designationLoad = $faculty->designationLoad($academicYearTerm);
        $regularLoad = $faculty->regularLoad($academicYearTerm);
        $overLoad = $faculty->overLoad($academicYearTerm);
        $emergencyLoad = $faculty->emergencyLoad($academicYearTerm);
        $praiseLoad = $faculty->praiseLoad($academicYearTerm);
        $campusDirector = Signatory::where('position', 'Campus Director')->first();
        $VPForAcadAffairs = Signatory::where('position', 'Vice President for Academic Affairs')->first();
        $pdf = PDF::loadView('exports.faculty-load-view-pdf', ['faculty' => $faculty, 'academicYearTerm' => $academicYearTerm, 'designations' => $designations, 'classes' => $classes, 'regularLoad' => $regularLoad, 'overLoad' => $overLoad, 'emergencyLoad' => $emergencyLoad, 'praiseLoad' => $praiseLoad, 'designationLoad' => $designationLoad, 'campusDirector'=>$campusDirector, 'VPForAcadAffairs'=>$VPForAcadAffairs, 'mandatoryDeLoading'=>$mandatoryDeLoading, 'specialAssignment'=>$specialAssignment]);
        return $pdf->stream();
    }
}
