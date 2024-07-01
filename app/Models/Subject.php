<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'description',
        'prerequisite',
        'units',
        'year_level',
        'term_id',
        'subject_type',
        'laboratory',
        'lab_type',
    ];

    public function class_schedules() {
        return $this->hasMany(ClassSchedule::class);
    }
    
    public function term() {
        return $this->belongsTo(Term::class);
    }
}
