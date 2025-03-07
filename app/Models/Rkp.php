<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rkp extends Model
{
    use HasFactory;
    
    protected $table = 'rkp';
    protected $fillable = [
        'urusan',
        'bidang_urusan',
        'program',
        'kegiatan',
        'indikator',
        'target',
        'satuan',
        'pagu_anggaran',
        'status',
        'catatan_revisi'
    ];

    public function pd()
    {
        return $this->belongsTo(Pd::class, 'pd_id');
    }

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
}
