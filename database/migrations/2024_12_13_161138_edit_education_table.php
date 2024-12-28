<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn([
                'undergraduate_training_type',
                'undergraduate_training_institution',
                'undergraduate_major',
                'undergraduate_training_country',
                'undergraduate_year_graduation',
                'undergraduation_second_degree',
                'undergraduate_second_degree_year_graduation',
                'postgraduate_master_specialization',
                'postgraduate_master_year_awarded',
                'postgraduate_master_training_institution',
                'postgraduate_master_dissertation_title',
                'postgraduate_doctoral_specialization',
                'postgraduate_doctoral_year_awarded',
                'postgraduate_doctoral_training_institution',
                'postgraduate_doctoral_dissertation_title'
            ]);
            $table->string('institution', 255); // Nơi đào tạo
            $table->string('field_of_study', 255); // Ngành học
            $table->year('graduation_year'); // Năm tốt nghiệp
            $table->enum('type', ['undergraduate', 'postgraduate']); // Loại: đại học hoặc sau đại học
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
