<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ssh', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_item');
            $table->text('spesifikasi');
            $table->string('satuan');
            $table->decimal('harga', 15, 2);
            $table->boolean('is_custom')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ssh');
    }
}; 