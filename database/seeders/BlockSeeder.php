<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blocks')->insert([
            [
                'block' => 'A'
            ],
            [
                'block' => 'B'
            ],
            [
                'block' => 'C'
            ],
            [
                'block' => 'D'
            ],
            [
                'block' => 'E'
            ],
            [
                'block' => 'F'
            ],
            [
                'block' => 'G'
            ],
            [
                'block' => 'H'
            ],
            [
                'block' => 'I'
            ],
            [
                'block' => 'J'
            ],
            [
                'block' => 'K'
            ],
            [
                'block' => 'L'
            ],
            [
                'block' => 'M'
            ],
            [
                'block' => 'N'
            ],
            [
                'block' => 'O'
            ],
            [
                'block' => 'P'
            ],
            [
                'block' => 'Q'
            ],
            [
                'block' => 'R'
            ],
            [
                'block' => 'S'
            ],
            [
                'block' => 'T'
            ],
            [
                'block' => 'U'
            ],
        ]);
    }
}
