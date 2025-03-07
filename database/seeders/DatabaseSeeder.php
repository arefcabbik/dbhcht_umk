<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pd;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 1. Buat data PD
        $dinkes = Pd::create([
            'nama_dinas' => 'Dinas Kesehatan',
            'singkatan' => 'DINKES',
            'alamat' => 'Jl. Contoh No. 123',
            'telepon' => '08123456789'
        ]);

        $dinsos = Pd::create([
            'nama_dinas' => 'Dinas Sosial',
            'singkatan' => 'DINSOS',
            'alamat' => 'Jl. Contoh No. 456',
            'telepon' => '08123456790'
        ]);

        // 2. Buat user admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'level' => 'admin',
            'aktif' => true
        ]);

        // 3. Buat user OPD Dinkes
        User::create([
            'name' => 'Operator Dinkes',
            'username' => 'dinkes',
            'email' => 'dinkes@example.com',
            'password' => Hash::make('opd123'),
            'level' => 'opd',
            'id_pd' => $dinkes->id,
            'aktif' => true
        ]);

        // 4. Buat user OPD Dinsos
        User::create([
            'name' => 'Operator Dinsos',
            'username' => 'dinsos',
            'email' => 'dinsos@example.com',
            'password' => Hash::make('opd123'),
            'level' => 'opd',
            'id_pd' => $dinsos->id,
            'aktif' => true
        ]);

        $this->call([
            PeriodeSeeder::class,
        ]);
    }
}
