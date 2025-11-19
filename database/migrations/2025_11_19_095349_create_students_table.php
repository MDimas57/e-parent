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
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        // Relasi ke User (Akun Orang Tua)
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        // Relasi ke Kelas
        $table->foreignId('school_class_id')->constrained('school_classes')->onDelete('cascade');
        $table->string('nisn')->unique();
        $table->string('name');
        $table->enum('gender', ['Laki-laki', 'Perempuan']);
        $table->date('birthday'); // Tanggal lahir
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
