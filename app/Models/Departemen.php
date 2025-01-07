<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function dataKaryawan()
    {
        return $this->hasMany(DataKaryawan::class);
    }
}
