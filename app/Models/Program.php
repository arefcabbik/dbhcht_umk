<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';
    
    protected $fillable = [
        'kode',
        'kode_urusan',
        'kode_bidang_urusan',
        'id_periode',
        'nama_program',
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

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }

    public function programOpd()
    {
        return $this->hasMany(ProgramOpd::class, 'kode_program', 'kode');
    }

    public function programIndikator()
    {
        return $this->hasMany(ProgramIndikator::class, 'kode_program', 'kode');
    }
} 