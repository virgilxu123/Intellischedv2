<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\ClassSchedule;

class GenerateScheduleService
{
    public function getDominantLabType($classes)
    {
        $labTypeCounts = [0 => 0, 1 => 0, 2 => 0];
        
        foreach ($classes as $class) {
            $labType = $class['lab_type'];
            $labTypeCounts[$labType]++;
        }
        
        $dominantLabType = array_keys($labTypeCounts, max($labTypeCounts));
        
        return $dominantLabType[0];
    }

    public function assignTimeRoomDay($classes) {
        foreach ($classes as $class) {
            $classSchedule = ClassSchedule::where('id', $class['id'])->first();
            $time_end = date('h:i A', strtotime($class['timeslot'] . ' +90 minutes'));
            if($class['year_level'] == 1 || $class['year_level'] == 4) {
                $dayId = 2;
            }else {
                $dayId = 3;
            }
            $room = Classroom::where('room_number', $class['room'])->first();
            $roomId = $room->id;
            $classSchedule->time_start = $class['timeslot'];
            $classSchedule->classroom_id = $roomId;
            $classSchedule->time_end = $time_end;
            $classSchedule->save();
            $classSchedule->days()->attach($dayId);
            $classSchedule->days()->attach($dayId  + 3);
        }
    }
}
