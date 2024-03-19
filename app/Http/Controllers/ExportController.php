<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlottedClassSchedules;
use App\Models\AcademicYearTerm;

class ExportController extends Controller
{
    public function exportPlottedSchedule(AcademicYearTerm $academicYearTerm) {
        return Excel::download(new PlottedClassSchedules($academicYearTerm), 'rooms-mapping.xlsx');
    }
}
