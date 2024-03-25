<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms')->insert([
            [
                'term' => 'First Semester',
            ], 
            [
                'term' => 'Second Semester',
            ], 
            [
                'term' => 'Summer',
            ]
        ]);
    }
}
