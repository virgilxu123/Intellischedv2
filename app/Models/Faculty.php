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

    public function designations () {
        return $this->belongsToMany(Designation::class);
    }

    public function class_schedules() {
        return $this->hasMany(ClassSchedule::class);
    }
}
