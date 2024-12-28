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
        Schema::dropIfExists('language_skills');

        Schema::create('language_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_id')->constrained('educations', 'id')->onDelete('cascade');
            $table->string('language_name');
            $table->string('proficiency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_skills');
    }
};
