<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $table = 'opd';

    protected $fillable = [
        'nama_opd',
        'kode_opd',
        'alamat',
        'telepon',
        'email',
        'status'
    ];

    public function rka()
    {
        return $this->hasMany(Rka::class);
    }

    public function rkp()
    {
        return $this->hasMany(Rkp::class, 'opd_id');
    }
} 