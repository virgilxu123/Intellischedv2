<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert([
            [
                'room_number' => '501',
                'type' => 'Lecture',
                'capacity' => '25',
            ],
            [
                'room_number' => '502',
                'type' => 'Laboratory',
                'capacity' => '25',
            ],
            [
                'room_number' => '601',
                'type' => 'Lecture',
                'capacity' => '25',
            ],
            [
                'room_number' => '602',
                'type' => 'Laboratory',
                'capacity' => '25',
            ],
            [
                'room_number' => '603',
                'type' => 'Laboratory',
                'capacity' => '25',
            ],
            [
                'room_number' => 'Internet Lab 1',
                'type' => 'Laboratory',
                'capacity' => '25',
            ],
            [
                'room_number' => 'Internet Lab 2',
                'type' => 'Lecture',
                'capacity' => '25',
            ],
            [
                'room_number' => 'Internet Lab 3',
                'type' => 'Lecture',
                'capacity' => '25',
            ],
        ]);
    }
}
