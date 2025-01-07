<?php

namespace App\Models;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'alamat',
        'tanggal_lahir',
        'email',
        'telepon',
        'departemen_id',
        'tanggal_masuk',

    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function pmk()
    {
        return $this->hasMany(PMK::class);
    }
}
