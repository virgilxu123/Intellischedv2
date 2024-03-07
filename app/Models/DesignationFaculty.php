<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationFaculty extends Model
{
    use HasFactory;

    public function academic_year_terms() {
        return $this->belongsTo(AcademicYearTerm::class);
    }
}
