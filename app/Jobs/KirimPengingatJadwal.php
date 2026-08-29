<?php

namespace App\Jobs;

use App\Models\JadwalKlarifikasi;
use App\Mail\PengingatJadwalMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Services\WhatsAppService;


class KirimPengingatJadwal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jadwal;
    protected $tipe;

    /**
     * @param JadwalKlarifikasi $jadwal
     * @param string $tipe contoh: "1 hari sebelum", "30 menit sebelum"
     */
    public function __construct(JadwalKlarifikasi $jadwal, string $tipe)
    {
        $this->jadwal = $jadwal;
        $this->tipe = $tipe;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
{
    $jadwal = $this->jadwal->load('user');

    // ======================
    // FORMAT PESAN WHATSAPP
    // ======================
    $pesan = "🔔 PENGINGAT JADWAL\n\n"
        . "Kegiatan : {$jadwal->nama_kegiatan}\n"
        . "Jenis    : {$jadwal->jenis_kegiatan}\n"
        . "Tanggal  : {$jadwal->tanggal_mulai}\n"
        . "Waktu    : {$jadwal->waktu_mulai}\n"
        . "Tempat   : {$jadwal->tempat}\n"
        . "Tipe     : {$this->tipe}\n\n"
        . "Mohon hadir tepat waktu.";

    // ======================
    // EMAIL P3MI
    // ======================
    Mail::to($jadwal->email_p3mi)
        ->send(new PengingatJadwalMail($jadwal, $this->tipe));

    // ======================
    // EMAIL PETUGAS
    // ======================
    if ($jadwal->user && $jadwal->user->email) {
        Mail::to($jadwal->user->email)
            ->send(new PengingatJadwalMail($jadwal, $this->tipe));
    }

    // ======================
    // WHATSAPP P3MI
    // ======================
    WhatsAppService::kirim(
        $jadwal->whatsapp_p3mi,
        $pesan
    );

    // ======================
    // WHATSAPP PETUGAS
    // ======================
    if ($jadwal->user && $jadwal->user->whatsapp) {
        WhatsAppService::kirim(
            $jadwal->user->whatsapp,
            $pesan
        );
    }
}

}
