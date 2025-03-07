<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('realisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program')->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->foreignId('sub_kegiatan_id')->constrained('sub_kegiatan')->onDelete('cascade');
            $table->integer('bulan');
            $table->year('tahun');
            $table->decimal('realisasi_anggaran', 15, 2);
            $table->decimal('realisasi_fisik', 5, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('realisasis');
    }
}; 