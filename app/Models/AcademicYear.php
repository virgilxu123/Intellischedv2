<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_start',
    ];

    public function academic_year_terms() {
        return $this->hasMany(AcademicYearTerm::class);
    }
}
