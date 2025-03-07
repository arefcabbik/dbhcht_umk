<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanIndikator extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_indikator';
    
    protected $fillable = [
        'kode',
        'kode_urusan',
        'kode_bidang_urusan',
        'kode_program',
        'kode_kegiatan',
        'id_periode',
        'indikator',
        'aktif'
    ];

    public function urusan()
    {
        return $this->belongsTo(Urusan::class, 'kode_urusan', 'kode');
    }

    public function bidangUrusan()
    {
        return $this->belongsTo(BidangUrusan::class, 'kode_bidang_urusan', 'kode');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'kode_program', 'kode');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kode_kegiatan', 'kode');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }
} 