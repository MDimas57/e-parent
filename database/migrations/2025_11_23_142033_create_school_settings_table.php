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
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            // Menambahkan kolom Tahun Ajaran
            $table->string('school_year')->default('2024/2025'); 
            
            $table->time('start_time')->default('07:00:00'); // Jam Masuk
            $table->time('end_time')->default('14:00:00');   // Jam Pulang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};