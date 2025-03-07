<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeRKP extends Model
{
    use HasFactory;

    protected $table = 'periode_rkp';

    protected $fillable = [
        'periode_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status' => 'boolean',
        'status_perubahan' => 'boolean',
        'tanggal_mulai_perubahan' => 'date',
        'tanggal_selesai_perubahan' => 'date'
    ];

    public function periode()
    {
        return $this->hasMany(Kegiatan::class, 'id_periode');
    }

    public function kegiatanIndikator()
    {
        return $this->hasMany(KegiatanIndikator::class, 'id_periode');
    }
} 