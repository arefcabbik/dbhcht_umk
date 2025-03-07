<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rka', function (Blueprint $table) {
            $table->id();
            $table->string('kode_urusan');
            $table->string('kode_bidang_urusan');
            $table->string('kode_program');
            $table->string('kode_kegiatan');
            $table->string('kode_sub_kegiatan');
            $table->foreignId('id_periode')->constrained('periode');
            $table->decimal('anggaran', 15, 2);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved', 'revision'])->default('draft');
            $table->text('revision_note')->nullable();
            $table->timestamps();

            $table->foreign('kode_urusan')->references('kode')->on('urusan');
            $table->foreign('kode_bidang_urusan')->references('kode')->on('bidang_urusan');
            $table->foreign('kode_program')->references('kode')->on('program');
            $table->foreign('kode_kegiatan')->references('kode')->on('kegiatan');
            $table->foreign('kode_sub_kegiatan')->references('kode')->on('sub_kegiatan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rka');
    }
}; 