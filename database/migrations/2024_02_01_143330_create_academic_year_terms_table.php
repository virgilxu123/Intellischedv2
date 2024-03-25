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
        Schema::create('academic_year_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('term_id');
            $table->timestamps();
            $table->unique(['academic_year_id', 'term_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_year_terms');
    }
};
