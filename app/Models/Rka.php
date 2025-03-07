<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rka extends Model
{
    use HasFactory;

    protected $table = 'rka';
    
    protected $fillable = [
        'urusan',
        'bidang_urusan',
        'program',
        'kegiatan',
        'sub_kegiatan',
        'indikator',
        'target',
        'satuan',
        'pagu_anggaran',
        'status',
    ];

    protected $attributes = [
        'status' => 'draft'
    ];

    public function pd()
    {
        return $this->belongsTo(Pd::class, 'pd_id');
    }

    public function urusan()
    {
        return $this->belongsTo(Urusan::class);
    }

    public function bidangUrusan()
    {
        return $this->belongsTo(BidangUrusan::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }

    public function rincian()
    {
        return $this->hasMany(RkaRincian::class);
    }
} 