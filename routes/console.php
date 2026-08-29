<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\JadwalKlarifikasi;
use App\Jobs\KirimPengingatJadwal;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduler Pengingat Jadwal
|--------------------------------------------------------------------------
*/
Schedule::everyMinute(function () {

    $now = Carbon::now();

    $jadwals = JadwalKlarifikasi::all();

    foreach ($jadwals as $jadwal) {

        $tanggalWaktu = Carbon::parse(
            $jadwal->tanggal_mulai . ' ' . $jadwal->waktu_mulai
        );

        // 🔔 H-1 (1 hari sebelum)
        if ($now->diffInMinutes($tanggalWaktu, false) === 1440) {
            dispatch(new KirimPengingatJadwal($jadwal, 'H-1'));
        }

        // 🔔 Pengingat menit custom
        if (!empty($jadwal->pengingat)) {
            if ($now->diffInMinutes($tanggalWaktu, false) === (int) $jadwal->pengingat) {
                dispatch(new KirimPengingatJadwal($jadwal, $jadwal->pengingat . ' menit'));
            }
        }

    }

});
