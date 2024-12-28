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
            $table->string('citizen_id')->nullable();
            $table->date('date_issue')->nullable();
            $table->string('place_issue')->nullable();
            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('scientists', function (Blueprint $table) {
            $table->timestamps();
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
