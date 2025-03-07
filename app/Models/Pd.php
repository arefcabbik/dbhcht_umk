<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pd extends Model
{
    protected $table = 'pd';
    
    protected $fillable = [
        'nama_dinas',
        'singkatan',
        'alamat',
        'telepon'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_pd');
    }
} 