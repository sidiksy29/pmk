<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PMK extends Model
{
    protected $fillable = [
        'nik',
        'tanggal',
        'no_pmk',
        'mutasi',
        'uraian',
        'catatan',
        'status',
        'approved_by_leader',
        'approved_by_asst_manager',
        'approved_by_hrd',
    ];

    public function datakaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nik', 'nik');
    }
}
