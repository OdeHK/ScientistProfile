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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scientist_id')->constrained()->onDelete('cascade');
            // Dai hoc
            $table->string('undergraduate_training_type')->nullable();
            $table->string('undergraduate_training_institution')->nullable();
            $table->string('undergraduate_major')->nullable();
            $table->string('undergraduate_training_country')->nullable();
            $table->year('undergraduate_year_graduation')->nullable();
            $table->string('undergraduation_second_degree')->nullable();
            $table->year('undergraduate_second_degree_year_graduation')->nullable();

            // Sau dai hoc
            $table->string('postgraduate_master_specialization')->nullable();
            $table->year('postgraduate_master_year_awarded')->nullable();
            $table->string('postgraduate_master_training_institution')->nullable();
            $table->string('postgraduate_master_dissertation_title')->nullable();
            $table->string('postgraduate_doctoral_specialization')->nullable();
            $table->year('postgraduate_doctoral_year_awarded')->nullable();
            $table->string('postgraduate_doctoral_training_institution')->nullable();
            $table->string('postgraduate_doctoral_dissertation_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
