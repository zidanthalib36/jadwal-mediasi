<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalKlarifikasi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_klarifikasi';

    protected $fillable = [
        'user_id', // ⬅ tambahkan ini
        'nama_kegiatan',
        'jenis_kegiatan',
        'tanggal_mulai',
        'waktu_mulai',
        'tanggal_selesai',
        'waktu_selesai',
        'pengingat',
        'tempat',
        'link_zoom',
        'whatsapp_p3mi', // ⬅ ganti dari email_petugas
        'email_p3mi',
        'nomor_pengaduan',
        'nama_pmi',
        'nama_pengadu',
        'p3mi',
        'deskripsi_kasus',
        'status',
        'hasil_kegiatan',
        'foto',
        'pic'
    ];

    // 🔗 Relasi ke User
    
   public function user()
{

    return $this->belongsTo(\App\Models\User::class);
}

}

