<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_count',
        'class_type',
        'time_start',
        'time_end',
    ];

    public function checkForFacultyTimeConflicts($newTimeStart, $newTimeEnd, $dayId, $classSchedule)
    {
        // Retrieve all class schedules for the given faculty and day
        $existingClassSchedules = $this->where('academic_year_term_id', $classSchedule->academic_year_term_id)
                            ->whereNotNull('classroom_id')
                            ->where('faculty_id', $classSchedule->faculty_id)
                            ->whereHas('days', function ($query) use ($dayId) {
                                $query->where('day_id', $dayId);
                            })
                            ->get();

         // Check for conflicts with each class schedule
        foreach ($existingClassSchedules as $existingClassSchedule) {
            // Convert time strings to Unix timestamp for comparison
            $classStartTime = strtotime($existingClassSchedule->time_start);
            $classEndTime = strtotime($existingClassSchedule->time_end);
            $newStartTime = strtotime($newTimeStart);
            $newEndTime = strtotime($newTimeEnd);

            // Check if the new time range overlaps with the existing class schedule
            if (($newStartTime >= $classStartTime && $newStartTime < $classEndTime) ||
                ($newEndTime > $classStartTime && $newEndTime <= $classEndTime) ||
                ($newStartTime <= $classStartTime && $newEndTime >= $classEndTime)) {
                return true; // Conflict found, return true
            }
        }

        // No conflicts found, return false
        return false;
    }




    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function days()
    {
        return $this->belongsToMany(Day::class);
    }

    public function academic_year_term()
    {
        return $this->belongsTo(AcademicYearTerm::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function load_type()
    {
        return $this->belongsTo(LoadType::class);
    }
}
