<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'units',
        'unique',
    ];

    public function faculties() {
        return $this->belongsToMany(Faculty::class, 'designation_faculties');
    }
    public static function designationOptions($academicYearTermId, $faculties) {
        $allFacultiesDesignations = array();
        foreach ($faculties as $faculty) {
            foreach ($faculty->designations()->wherePivot('academic_year_term_id', $academicYearTermId)->get() as $designation) {
                array_push($allFacultiesDesignations, $designation);
            }
        }
        $designationsWhereUniqueIsOne = collect($allFacultiesDesignations)->filter(function ($designation) {
            return $designation->unique == 1;
        });
        $designationIdsWithUniqueOne = $designationsWhereUniqueIsOne->pluck('id')->toArray();
        return Designation::whereNotIn('id', $designationIdsWithUniqueOne)->get();
    }
}
