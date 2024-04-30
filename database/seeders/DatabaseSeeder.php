<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        $this->call(TermSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(AcademicYearSeeder::class);
        $this->call(DaySeeder::class);
        $this->call(BlockSeeder::class);
        $this->call(LoadTypeSeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(SignatorySeeder::class);
    }
}
