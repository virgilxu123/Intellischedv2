<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designations')->insert([
            [
                'Designation' => 'ICT Director',
                'Units' => '12',
            ],
            [
                'Designation' => 'System Administrator',
                'Units' => '6',
            ],
            [
                'Designation' => 'Program Coordinator',
                'Units' => '3',
            ],
            [
                'Designation' => 'Dean',
                'Units' => '12',
            ],
            [
                'Designation' => 'Extension Coordinator',
                'Units' => '3',
            ],
            [
                'Designation' => 'Department Chair',
                'Units' => '6',
            ],
            [
                'Designation' => 'ACSS Adviser',
                'Units' => '3',
            ],
            [
                'Designation' => 'Research Coordinator',
                'Units' => '3',
            ],
            [
                'Designation' => 'Research & Extension',
                'Units' => '3',
            ],
            [
                'Designation' => 'Research & Extension',
                'Units' => '6',
            ],
            [
                'Designation' => 'Research & Extension',
                'Units' => '9',
            ],
        ]);
    }
}
