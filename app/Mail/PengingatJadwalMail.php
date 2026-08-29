<?php

namespace App\Mail;

use App\Models\JadwalKlarifikasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengingatJadwalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;
    public $tipe;

    /**
     * Create a new message instance.
     */
    public function __construct(JadwalKlarifikasi $jadwal, string $tipe)
    {
        $this->jadwal = $jadwal;
        $this->tipe = $tipe; // contoh: "1 hari" atau "30 menit"
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pengingat Jadwal Klarifikasi / Mediasi')
            ->view('emails.pengingat_jadwal');
    }
}
