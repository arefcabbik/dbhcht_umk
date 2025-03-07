<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangUrusan extends Model
{
    use HasFactory;

    protected $table = 'bidang_urusan';
    
    protected $fillable = [
        'kode',
        'kode_urusan',
        'nama_bidang_urusan',
        'aktif'
    ];

    public function urusan()
    {
        return $this->belongsTo(Urusan::class, 'kode_urusan', 'kode');
    }

    public function program()
    {
        return $this->hasMany(Program::class, 'kode_bidang_urusan', 'kode');
    }
} 