<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ssh extends Model
{
    use HasFactory;

    protected $table = 'ssh';
    
    protected $fillable = [
        'kode_kelompok_barang',
        'uraian_kelompok_barang',
        'id_standar_harga',
        'kode_barang',
        'uraian_barang',
        'spesifikasi',
        'satuan',
        'harga_satuan',
        'kode_rekening'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:0'
    ];
} 