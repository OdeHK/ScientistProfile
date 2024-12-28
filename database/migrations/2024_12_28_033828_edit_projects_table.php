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
        Schema::dropIfExists('projects');

        Schema::dropIfExists('scientific_researches');

        Schema::create('projects', function(Blueprint $table){
            $table->id();
            $table->foreignId('scientist_id')->constrained('scientists', 'id')->onDelete('cascade');
            $table->string('title');
            $table->string('level');
            $table->year('start_year');
            $table->year('end_year');
            $table->string('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
