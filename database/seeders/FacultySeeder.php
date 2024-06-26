<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faculties')->insert([
            [
                'first_name' => 'Catherine',
                'middle_initial' => 'R',
                'last_name' => 'Alimboyong',
                'rank' => 'Professor 1',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'DIT',
                'color' => '#FF5733'
            ],
            [
                'first_name' => 'Coravil Joy',
                'middle_initial' => 'C',
                'last_name' => 'Avila',
                'rank' => 'Instructor 1',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MIT',
                'color' => '#FFC300'
            ],
            [
                'first_name' => 'Josephine',
                'middle_initial' => 'L',
                'last_name' => 'Bulilan',
                'rank' => 'Assistant Professor 1',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MIT',
                'color' => '#FFEB3B'
            ],
            [
                'first_name' => 'Mark Anthony',
                'middle_initial' => 'H',
                'last_name' => 'Erizo',
                'rank' => 'Instructor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#4CAF50'
            ],
            [
                'first_name' => 'Michael',
                'middle_initial' => 'L',
                'last_name' => 'Estal',
                'rank' => 'Instructor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#388E3C '
            ],
            [
                'first_name' => 'Melbrick',
                'middle_initial' => 'A',
                'last_name' => 'Evallar',
                'rank' => 'Assistan Professor 1',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#00ACC1'
            ],
            [
                'first_name' => 'Born Christian',
                'middle_initial' => 'A',
                'last_name' => 'Isip',
                'rank' => 'Professor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'DTE',
                'color' => '#039BE5'
            ],
            [
                'first_name' => 'Divine Grace',
                'middle_initial' => 'N',
                'last_name' => 'Loren',
                'rank' => 'Assistant Professor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MIT',
                'color' => '#673AB7'
            ],
            [
                'first_name' => 'Esmael',
                'middle_initial' => 'V',
                'last_name' => 'Maliberan',
                'rank' => 'Professor 3',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'DIT',
                'color' => '#E91E63 '
            ],
            [
                'first_name' => 'Sheilla Ann',
                'middle_initial' => 'B',
                'last_name' => 'Pacheco',
                'rank' => 'Instructor 3',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#795548'
            ],
            [
                'first_name' => 'Nap Nichole Greg',
                'middle_initial' => 'S',
                'last_name' => 'Salera',
                'rank' => 'Assistant Professor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'PhEdD-TM',
                'color' => '#9E9E9E'
            ],
            [
                'first_name' => 'Cherly',
                'middle_initial' => 'B',
                'last_name' => 'Sardovia',
                'rank' => 'Assistant Professor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#03A9F4'
            ],
            [
                'first_name' => 'Virgilio',
                'middle_initial' => 'F',
                'last_name' => 'Tuga',
                'rank' => '',
                'status' => 'Contractual',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#00BCD4'
            ],
            [
                'first_name' => 'Kevin',
                'middle_initial' => 'P',
                'last_name' => 'Salcedo',
                'rank' => 'Instructor 2',
                'status' => 'Regular',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#d6abba'
            ],
            [
                'first_name' => 'Grace Love',
                'middle_initial' => '',
                'last_name' => 'Tidalgo',
                'rank' => 'Instructor 1',
                'status' => 'Contractual',
                'image' => '',
                'availability' => true,
                'educ_qualification' => 'MSCS',
                'color' => '#5dcaf5'
            ]
        ]);
    }
}
