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
        $designationsUnits = $this->designations()
            ->wherePivot('academic_year_term_id', $academicYearTerm->id)
            ->sum('units');

        $classSchedulesUnits = $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->sum('units');

        return $designationsUnits + $classSchedulesUnits;
    }

    public function loadCalculationByType($academicYearTerm, $loadType)
    {
        $query = $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->whereHas('load_type', function ($query) use ($loadType) {
                $query->where('load_type', $loadType);
            });

        if ($loadType === 'Regular Load') {
            $designationsUnits = $this->designations()
                ->wherePivot('academic_year_term_id', $academicYearTerm->id)
                ->sum('units');
            return $query->sum('units') + $designationsUnits;
        }

        return $query->sum('units');
    }

}
