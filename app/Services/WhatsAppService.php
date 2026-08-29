<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public static function kirim($nomor, $pesan)
    {
        if (!$nomor) return;

        // Format 08 menjadi 628
        if (substr($nomor, 0, 1) == "0") {
            $nomor = "62" . substr($nomor, 1);
        }

        Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN')
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => $pesan,
        ]);
    }
}
