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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('block_id')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->unsignedBigInteger('academic_year_term_id')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->integer('student_count')->default(0);
            $table->decimal('units', 5, 2)->nullable();
            $table->enum('class_type', ['laboratory', 'lecture'])->nullable();
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->unsignedBigInteger('load_type_id')->nullable();
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
