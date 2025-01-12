<?php

namespace App\Services;

use App\Models\Subject;
use App\Models\ClassSchedule;

class ClassScheduleService
{
    public function createAdjustBlocks($subject_id, $desiredBlockCount, $academicYearTerm)
    {
        $currentBlockCount = ClassSchedule::where('subject_id', $subject_id)
                                            ->where('class_type','lecture')
                                            ->where('academic_year_term_id', $academicYearTerm->id)
                                            ->count();
        $difference = $desiredBlockCount - $currentBlockCount;
        if ($difference > 0) {
            // Add additional blocks
            for ($i = $currentBlockCount + 1; $i <= $currentBlockCount + $difference; $i++) {
                $classSchedule = new ClassSchedule();
                $classSchedule->subject_id = $subject_id;
                $classSchedule->academic_year_term_id = $academicYearTerm->id;
                $classSchedule->block_id = $i;
                $classSchedule->units = 3;
                $classSchedule->class_type = 'lecture';
                $classSchedule->student_count = 25;
                $classSchedule->save();
            }
            $subject = Subject::find($subject_id); //if the subject has a laboratory create a class for laboratory
            if ($subject->laboratory === 'Yes') {
                for ($i = $currentBlockCount + 1; $i <= $currentBlockCount + $difference; $i++) {
                    $classSchedule = new ClassSchedule();
                    $classSchedule->subject_id = $subject_id;
                    $classSchedule->academic_year_term_id = $academicYearTerm->id;
                    $classSchedule->block_id = $i;
                    $classSchedule->units = 1.25;
                    $classSchedule->class_type = 'laboratory';
                    $classSchedule->student_count = 25;
                    $classSchedule->save();
                }
            }
        } elseif ($difference < 0) {
            // Deduct blocks
            $blocksToRemove = ClassSchedule::where('subject_id', $subject_id)
                                            ->where('class_type','lecture')
                                            ->where('academic_year_term_id', $academicYearTerm->id)
                                            ->orderBy('block_id', 'desc')
                                            ->take(abs($difference))
                                            ->get();

            foreach ($blocksToRemove as $block) {
                $block->days()->detach();
                $block->delete();
            }
            $subject = Subject::find($subject_id);
            if($subject) {
                $blocksToRemove = ClassSchedule::where('subject_id', $subject_id)->where('class_type','laboratory')
                                                ->where('academic_year_term_id', $academicYearTerm->id)
                                                ->orderBy('block_id', 'desc')
                                                ->take(abs($difference))
                                                ->get();

                foreach ($blocksToRemove as $block) {
                    $block->days()->detach();
                    $block->delete();
            }
            }
        }
    }
    public function numberOfBlocks($subject_id, $academicYearTerm)
    {
        $blocks = ClassSchedule::where('academic_year_term_id', $academicYearTerm)
                            ->where('units', 3)
                            ->whereIn('subject_id', $subject_id)
                            ->selectRaw('subject_id, COUNT(*) as block_count')
                            ->groupBy('subject_id')
                            ->pluck('block_count', 'subject_id');
        return $blocks->max();
    }
}
