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
        Schema::create('postgraduate_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_id')->constrained('educations', 'id')->onDelete('cascade'); // Liên kết với bảng educations
            $table->enum('level', ['master', 'phd']); // Cấp bậc: thạc sĩ hoặc tiến sĩ
            $table->string('thesis_title', 255)->nullable(); // Tên luận văn
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postgraduate_educations');
    }
};
