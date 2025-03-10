<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('dana_pembagian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_master_id')->constrained('dana_masters');
            $table->string('tahun', 4);
            $table->decimal('nominal', 15, 2);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
