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
            $scheduleForLabAndLec = ClassSchedule::selectBothLabAndLecClasses($classSchedule->subject_id, $classSchedule->block_id);
            foreach ($scheduleForLabAndLec as $schedule) {
                $schedule->time_start = $class['timeslot'];
                $schedule->classroom_id = $roomId;
                $schedule->time_end = $time_end;
                $schedule->save();
                $schedule->days()->attach($dayId);
                $schedule->days()->attach($dayId  + 3);
            }
        }
    }
}
