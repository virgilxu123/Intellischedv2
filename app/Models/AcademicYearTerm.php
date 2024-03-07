<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYearTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'term_id',
    ];

    public function class_schedules() {
        return $this->hasMany(ClassSchedule::class);
    }

    public function designation_faculty() {
        return $this->hasMany(DesignationFaculty::class);
    }

    public function term() {
        return $this->belongsTo(Term::class);
    }
    
    public function academic_year() {
        return $this->belongsTo(AcademicYear::class);
    }
}
