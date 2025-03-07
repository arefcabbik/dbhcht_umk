<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('realisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rkp_id')->constrained('rkp')->onDelete('cascade');
            $table->integer('bulan');
            $table->string('nama_kegiatan');
            $table->string('tempat');
            $table->integer('peserta');
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('realisasi');
    }
}; 