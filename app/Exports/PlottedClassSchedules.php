<?php

namespace App\Exports;

use App\Models\ClassSchedule;
use App\Models\AcademicYearTerm;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PlottedClassSchedules implements FromView, ShouldAutoSize
{
    use Exportable;
    protected $academicYearTerm;
    
    public function __construct(AcademicYearTerm $academicYearTerm)
    {
        $this->academicYearTerm = $academicYearTerm;
    }
    
    public function view(): View
    {
        $classSchedules = ClassSchedule::where('academic_year_term_id', $this->academicYearTerm->id)->get();
        $classSchedules->load('subject', 'block', 'classroom', 'faculty', 'days');
        return view('exports.export-plotted-schedules', [
            'academicYearTerm' => $this->academicYearTerm,
            'classSchedules' => $classSchedules,
        ]);
    }
}
