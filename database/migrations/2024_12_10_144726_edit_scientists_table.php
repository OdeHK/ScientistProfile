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
        Schema::table('scientists', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('gender'); // 0: Male, 1: Female
            $table->date('date_of_birth')->nullable();
            $table->string('hometown')->nullable();
            $table->string('ethnicity', 50)->nullable();
            $table->string('highest_degree', 100)->nullable();
            $table->year('year_awarded_degree')->nullable();
            $table->string('country_awarded_degree', 100)->nullable();
            $table->string('scientific_title', 100)->nullable();
            $table->year('year_title_appointment')->nullable();
            $table->string('position')->nullable();
            $table->string('workplace')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_office', 20)->nullable();
            $table->string('phone_home', 20)->nullable();
            $table->string('phone_mobile', 20)->nullable();
            $table->string('fax', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scientists', function (Blueprint $table) {
            //
        });
    }
};
