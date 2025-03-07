<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kode_urusan');
            $table->string('kode_bidang_urusan');
            $table->string('kode_program');
            $table->foreignId('id_periode')->constrained('periode');
            $table->string('nama_kegiatan');
            $table->enum('aktif', ['0', '1'])->default('1');
            $table->timestamps();

            $table->foreign('kode_urusan')->references('kode')->on('urusan');
            $table->foreign('kode_bidang_urusan')->references('kode')->on('bidang_urusan');
            $table->foreign('kode_program')->references('kode')->on('program');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan');
    }
}; 