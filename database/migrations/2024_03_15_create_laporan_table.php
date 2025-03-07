<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->constrained('pd');
            $table->foreignId('kegiatan_id')->constrained('rkp');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->decimal('target', 15, 2);
            $table->decimal('realisasi', 15, 2);
            $table->decimal('anggaran', 15, 2);
            $table->decimal('realisasi_anggaran', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
}; 