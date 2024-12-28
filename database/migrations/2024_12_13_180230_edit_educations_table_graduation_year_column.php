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
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn('graduation_year');
        });

        Schema::table('undergraduate_educations', function(Blueprint $table) {
            $table->year('graduation_year')->after('training_country');
        });

        Schema::table('postgraduate_educations', function(Blueprint $table) {
            $table->year('graduation_year')->after('thesis_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educations', function (Blueprint $table) {
            //
        });
    }
};
