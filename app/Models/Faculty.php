<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'rank',
        'status',
        'color',
        'availability',
        'image',
    ];

    public function designations()
    {
        return $this->belongsToMany(Designation::class, 'designation_faculties');
    }

    public function class_schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function loadCalculation($academicYearTerm)
    {
        $load = 0;

        $classSchedules = $this->class_schedules()->where('academic_year_term_id', $academicYearTerm->id)->get();
        $classSchedules->load('subject');
        $designations = $this->designations()->wherePivot('academic_year_term_id', $academicYearTerm->id)->get();

        foreach($designations as $designation) {
            $load += $designation->units;
        }
        foreach ($classSchedules as $classSchedule) {
            $units = $classSchedule->units;
            $load += $units;
        }
        return $load;
    }
}
