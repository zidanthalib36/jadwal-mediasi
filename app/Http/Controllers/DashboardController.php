<?php

namespace App\Http\Controllers;

use App\Models\JadwalKlarifikasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKlarifikasi::all();

        $totalJadwal = $jadwal->count();

        $menungguJadwal = 0;
        $berlangsung = 0;
        $menungguHasil = 0;
        $hadir = 0;
        $tidakHadir = 0;
        $bersurat = 0;

        foreach ($jadwal as $item) {

    if ($item->status == 'Menunggu Jadwal') {
        $menungguJadwal++;
    }

    if ($item->status == 'Berlangsung') {
        $berlangsung++;
    }

    if ($item->status == 'Menunggu Hasil') {
        $menungguHasil++;
    }

    if ($item->status == 'Hadir') {
        $hadir++;
    }

    if ($item->status == 'Tidak Hadir') {
        $tidakHadir++;
    }

    if ($item->status == 'Bersurat') {
        $bersurat++;
    }
}

        $jadwalHariIni = JadwalKlarifikasi::whereDate('tanggal_mulai', today())
    ->select('nama_kegiatan','waktu_mulai','pic')
    ->orderBy('waktu_mulai','asc')
    ->get();

        $grafik = JadwalKlarifikasi::select(
            DB::raw("MONTH(tanggal_mulai) as bulan"),
            DB::raw("COUNT(*) as total")
        )
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        $reminder = JadwalKlarifikasi::whereBetween('tanggal_mulai', [
        today(),
        today()->addDays(5)
    ])
    ->orderBy('tanggal_mulai')
    ->get();

    $kegiatanMenungguHasil = JadwalKlarifikasi::where('status', 'Menunggu Hasil')
    ->select('nama_kegiatan','pic','tanggal_mulai')
    ->orderBy('tanggal_mulai','asc')
    ->get();

return view('dashboard', compact(
    'totalJadwal',
    'menungguJadwal',
    'berlangsung',
    'menungguHasil',
    'hadir',
    'tidakHadir',
    'bersurat',
    'jadwalHariIni',
    'grafik',
    'reminder',
    'kegiatanMenungguHasil'
));
    }
}
