<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urusan extends Model
{
    use HasFactory;

    protected $table = 'urusan';

    protected $fillable = [
        'kode',
        'nama_urusan',
        'aktif'
    ];

    public function bidangUrusan()
    {
        return $this->hasMany(BidangUrusan::class, 'urusan_id');
    }

    public function program()
    {
        return $this->hasMany(Program::class, 'kode_urusan', 'kode');
    }
} 