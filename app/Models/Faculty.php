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
        'middle_initial',
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

    public function totalLoad($academicYearTerm)
    {
        $totalSubjectUnits = $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->sum('units');
        $designationsUnits = $this->designations()
            ->wherePivot('academic_year_term_id', $academicYearTerm->id)
            ->sum('units')  ;

        return $totalSubjectUnits + $designationsUnits;
    }

    // public function loadCalculationByType($academicYearTerm, $loadType)
    // {
    //     $query = $this->class_schedules()
    //         ->where('academic_year_term_id', $academicYearTerm->id)
    //         ->whereHas('load_type', function ($query) use ($loadType) {
    //             $query->where('load_type', $loadType);
    //         });

    //     if ($loadType === 'Regular Load') {
    //         $designationsUnits = $this->designations()
    //             ->wherePivot('academic_year_term_id', $academicYearTerm->id)
    //             ->sum('units');
    //         return $query->sum('units') + $designationsUnits;
    //     }
    //     if($loadType === 'Overload'){
    //         return $query->sum('units');
    //     }
    //     return $query->sum('units');
    // }

    public function regularLoad($academicYearTerm) 
    {
        $regularLoad = $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->whereHas('load_type', function ($query) {
                $query->where('load_type', 'Regular Load');
            })
            ->sum('units');
        return $regularLoad + $this->designationLoad($academicYearTerm) + $this->mandatoryDeLoading($academicYearTerm);
    }
    public function overLoad($academicYearTerm)
    {
        return $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->whereHas('load_type', function ($query) {
                $query->where('load_type', 'Overload');
            })
            ->sum('units');
    }
    public function emergencyLoad($academicYearTerm)
    {
        return $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->whereHas('load_type', function ($query) {
                $query->where('load_type', 'Emergency Load');
            })
            ->sum('units');
    }
    public function praiseLoad($academicYearTerm)
    {
        return $this->class_schedules()
            ->where('academic_year_term_id', $academicYearTerm->id)
            ->whereHas('load_type', function ($query) {
                $query->where('load_type', 'Praise Load');
            })
            ->sum('units');
    }
    public function designationLoad($academicYearTerm)
    {
        return $this->designations()
            ->where('unique', 1)
            ->wherePivot('academic_year_term_id', $academicYearTerm->id)
            ->sum('units');
    }
    public function mandatoryDeLoading($academicYearTerm)
    {
        return $this->designations()
            ->where('unique', 0)
            ->wherePivot('academic_year_term_id', $academicYearTerm->id)
            ->sum('units');
    }
}
