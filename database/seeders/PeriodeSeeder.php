<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        Periode::create([
            'nama' => 'Periode 2024',
            'tahun' => 2024,
            'aktif' => '1'
        ]);
    }
} 