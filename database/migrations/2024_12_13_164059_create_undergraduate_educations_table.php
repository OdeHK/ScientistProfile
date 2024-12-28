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
        Schema::create('undergraduate_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_id')->constrained('educations', 'id')->onDelete('cascade'); // Liên kết với bảng educations
            $table->string('training_system', 255); // Hệ đào tạo (chính quy, tại chức,...)
            $table->string('training_country', 255); // Nước đào tạo
            $table->string('second_degree', 255)->nullable(); // Bằng đại học 2
            $table->year('second_graduation_year')->nullable(); // Năm tốt nghiệp bằng đại học 2
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undergraduate_educations');
    }
};
