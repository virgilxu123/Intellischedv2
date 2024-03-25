<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('days')->insert([
            [
                'day' => 'Sunday'
            ],
            [
                'day' => 'Monday'
            ],
            [
                'day' => 'Tuesday'
            ],
            [
                'day' => 'Wednesday'
            ],
            [
                'day' => 'Thursday'
            ],
            [
                'day' => 'Friday'
            ],
            [
                'day' => 'Saturday'
            ],
        ]);
    }
}
