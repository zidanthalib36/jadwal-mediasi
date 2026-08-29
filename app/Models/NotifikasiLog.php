<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalKlarifikasi;

class NotifikasiLog extends Model
{
    protected $table = 'notifikasi_logs';

    protected $fillable = [
        'jadwal_id',
        'channel',
        'tipe_notifikasi',
        'tujuan',
        'kontak',
        'status',
        'response'
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalKlarifikasi::class, 'jadwal_id');
    }
}
