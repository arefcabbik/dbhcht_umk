<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_opd', function (Blueprint $table) {
            $table->id();
            $table->string('kode_program');
            $table->string('id_pd');
            $table->foreignId('id_periode')->constrained('periode')->onDelete('cascade');
            $table->enum('aktif', ['0', '1'])->default('1');
            $table->timestamps();

            $table->foreign('kode_program')->references('kode')->on('program')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_opd');
    }
}; 