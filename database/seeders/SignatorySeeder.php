<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SignatorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('signatories')->insert([
            [
                'first_name' => 'Abundio',
                'last_name' => 'Miralles',
                'middle_initial' => 'C',
                'educ_qualification' => 'EdD',
                'position' => 'Campus Director',
            ],
            [
                'first_name' => 'Maria Lady Sol',
                'last_name' => 'Suazo',
                'middle_initial' => 'A',
                'educ_qualification' => 'Phd',
                'position' => 'Vice President for Academic Affairs',
            ],
        ]);
    }
}
