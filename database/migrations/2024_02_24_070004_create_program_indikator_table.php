<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_indikator', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kode_urusan');
            $table->string('kode_bidang_urusan');
            $table->string('kode_program');
            $table->foreignId('id_periode')->constrained('periode')->onDelete('cascade');
            $table->string('indikator');
            $table->enum('aktif', ['0', '1'])->default('1');
            $table->timestamps();

            $table->foreign('kode_urusan')->references('kode')->on('urusan')->onDelete('cascade');
            $table->foreign('kode_bidang_urusan')->references('kode')->on('bidang_urusan')->onDelete('cascade');
            $table->foreign('kode_program')->references('kode')->on('program')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_indikator');
    }
}; 