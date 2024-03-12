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

    public function loadCalculation($academicYearTermId)
    {
        // Initialize load counter
        $load = 0;

        // Get all class schedules assigned to the faculty for the specified academic year term
        $classSchedules = $this->class_schedules()->where('academic_year_term_id', $academicYearTermId)->get();

        // Loop through each class schedule to calculate load
        foreach ($classSchedules as $classSchedule) {
            // Assuming each class schedule has a subject relationship
            $subject = $classSchedule->subject;

            // Assuming each subject has a units attribute
            $units = $subject->units;

            // Add units to the total load
            $load += $units;
        }

        // Return the calculated load
        return $load;
    }

}
