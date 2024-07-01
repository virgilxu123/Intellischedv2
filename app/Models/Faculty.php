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
        'educ_qualification',
        'years_in_service',
        'eligibility',
    ];

    public function designations()
    {
        return $this->belongsToMany(Designation::class, 'designation_faculties');
    }

    public function class_schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function designationsForAcademicYearTerm($AcademicYearTermId)
    {
        return $this->belongsToMany(Designation::class)
                    ->wherePivot('academic_year_term_id', $AcademicYearTermId);
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

    public function assignClassSchedules($classSchedules)
    {
        $classSchedules->each(function ($classSchedule){
            $classSchedule->faculty_id = $this->id;
            if ($classSchedule->subject->laboratory == 'Yes') { //assign also the laboratory class to faculty
                $labSchedule = ClassSchedule::where('subject_id', $classSchedule->subject_id)
                    ->where('block_id', $classSchedule->block_id)
                    ->where('class_type', 'laboratory')
                    ->first();
                $labSchedule->faculty_id = $this->id;
                $labSchedule->save();
            }
            $classSchedule->save();
        });
    }

}
