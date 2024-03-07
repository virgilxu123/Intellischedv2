<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('block_id')->nullable()->constrained();
            $table->foreignId('classroom_id')->nullable()->constrained();
            $table->foreignId('academic_year_term_id')->nullable()->constrained();
            $table->foreignId('faculty_id')->nullable()->constrained();
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->foreignId('load_type_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
