<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bidang_urusan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kode_urusan');
            $table->string('nama_bidang_urusan');
            $table->enum('aktif', ['0', '1'])->default('1');
            $table->timestamps();

            $table->foreign('kode_urusan')->references('kode')->on('urusan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang_urusan');
    }
}; 