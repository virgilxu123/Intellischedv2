<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('load_types')->insert([
            [
                'load_type' => 'Regular Load'
            ],
            [
                'load_type' => 'Overload'
            ],
            [
                'load_type' => 'Emergency Load'
            ],
            [
                'load_type' => 'Praise Load'
            ],
        ]);
    }
}
