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

    public function checkForFacultyBlockTimeConflicts($newTimeStart, $newTimeEnd, $dayId, $roomId)
    {
        
        // Retrieve all class schedules for the given faculty and day
        $existingClassSchedules = self::where('academic_year_term_id', $this->academic_year_term_id)
            ->whereNotNull('classroom_id')
            ->where('faculty_id', $this->faculty_id)
            ->whereHas('days', function ($query) use ($dayId) {
                $query->where('day_id', $dayId);
            })
            ->get();
        // Check for conflicts with each class schedule
        foreach ($existingClassSchedules as $existingClassSchedule) {
            if($existingClassSchedule->id !== $this->id){
                
                // Convert time strings to Unix timestamp for comparison
                $classStartTime = strtotime($existingClassSchedule->time_start);
                $classEndTime = strtotime($existingClassSchedule->time_end);
                $newStartTime = strtotime($newTimeStart);
                $newEndTime = strtotime($newTimeEnd);
    
                // Check if the new time range overlaps with the existing class schedule
                if (($newStartTime >= $classStartTime && $newStartTime < $classEndTime) ||
                    ($newEndTime > $classStartTime && $newEndTime <= $classEndTime) ||
                    ($newStartTime <= $classStartTime && $newEndTime >= $classEndTime)
                ) {
                    return true; // Conflict found, return true
                }
            }
        }
        $yearLvl = $this->subject->year_level;
        $existtingClassSchedulesWithSameBlockAndYear = self::where('academic_year_term_id', $this->academic_year_term_id)
            ->whereNotNull('classroom_id')
            ->whereHas('days', function ($query) use ($dayId) {
                $query->where('day_id', $dayId);
            })
            ->whereHas('subject', function ($query) use ($yearLvl) {
                $query->where('year_level', $yearLvl);
            })
            ->where('block_id', $this->block_id)
            ->get();
        foreach ($existtingClassSchedulesWithSameBlockAndYear as $existingClassSchedule) {
            // Convert time strings to Unix timestamp for comparison
            if($existingClassSchedule->id !== $this->id){

                $classStartTime = strtotime($existingClassSchedule->time_start);
                $classEndTime = strtotime($existingClassSchedule->time_end);
                $newStartTime = strtotime($newTimeStart);
                $newEndTime = strtotime($newTimeEnd);
    
               // Check if the new time range overlaps with the existing class schedule
                if (($newStartTime >= $classStartTime && $newStartTime < $classEndTime) ||
                    ($newEndTime > $classStartTime && $newEndTime <= $classEndTime) ||
                    ($newStartTime <= $classStartTime && $newEndTime >= $classEndTime)
                ) {
                    return true; // Conflict found, return true
                }
            }
        }
        $existingClassScheduleInThisRoom = self::where('academic_year_term_id', $this->academic_year_term_id)
                                    ->whereNotNull('classroom_id')
                                    ->whereHas('days', function ($query) use ($dayId) {
                                        $query->where('day_id', $dayId);
                                    })
                                    ->where('classroom_id', $roomId)
                                    ->get();
        foreach ($existingClassScheduleInThisRoom as $existingClassSchedule) {
            if($existingClassSchedule->id !== $this->id){
                // Convert time strings to Unix timestamp for comparison
                $classStartTime = strtotime($existingClassSchedule->time_start);
                $classEndTime = strtotime($existingClassSchedule->time_end);
                $newStartTime = strtotime($newTimeStart);
                $newEndTime = strtotime($newTimeEnd);
                if (($newStartTime >= $classStartTime && $newStartTime < $classEndTime) ||
                    ($newEndTime > $classStartTime && $newEndTime <= $classEndTime) ||
                    ($newStartTime <= $classStartTime && $newEndTime >= $classEndTime)
                ) {
                    return true; // Conflict found, return true
                }
            }
        }
        // No conflicts found, return false
        return false;
    }

    public function assignLoadType($loadType)
    {
        
        if ($loadType==1 && $this->faculty->regularLoad($this->academic_year_term) + $this->units > 21) {
            return response()->json(['error' => 'Faculty has reached maximum regular load.']);
        }
        
        if ($loadType==2 && $this->faculty->overLoad($this->academic_year_term) + $this->units > 9.25) {
            return response()->json(['error' => 'Faculty has reached maximum over load.']);
        }
                // $this->assignEmergencyLoad($loadType);
                // $this->assignPraiseLoad($loadType);
                
        $this->load_type_id = $loadType;
        $this->save();
    }

    public static function selectBothLabAndLecClasses($subjectId, $blockId)
    {
        return self::where('subject_id', $subjectId)
            ->where('block_id', $blockId)
            ->get();
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
