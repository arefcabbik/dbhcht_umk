<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rkp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pd_id')->constrained('pd');
            $table->string('kode_sub_kegiatan');
            $table->string('sub_kegiatan');
            $table->text('target_kinerja');
            $table->enum('status', ['draft', 'verifikasi', 'revisi', 'selesai'])->default('draft');
            $table->text('catatan_revisi')->nullable();
            $table->boolean('is_perubahan')->default(false);
            $table->boolean('need_asistensi')->default(false);
            $table->boolean('is_approved_perekonomian')->default(false);
            $table->boolean('is_approved_asistensi')->default(false);
            $table->boolean('is_signed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rkp');
    }
}; 