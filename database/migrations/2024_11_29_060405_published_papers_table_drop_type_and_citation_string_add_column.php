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
        Schema::table('published_papers', function (Blueprint $table) {
            $table->dropColumn(['citation_type', 'citation_string']);
            
            $table->string('authors')->nullable();
            $table->string('title')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('issn')->nullable();
            $table->string('publisher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('published_papers', function (Blueprint $table) {
             // Khôi phục các cột bị xóa (nếu cần rollback)
             $table->string('citation_type')->nullable();
             $table->text('citation_string')->nullable();
 
             // Xóa các cột mới
             $table->dropColumn(['authors', 'title', 'publication_date', 'doi', 'url', 'issn', 'publisher']);
        });
    }
};
