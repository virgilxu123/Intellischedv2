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
    ];

    public function faculties() {
        return $this->belongsToMany(Faculty::class, 'designation_faculties');
    }
}
