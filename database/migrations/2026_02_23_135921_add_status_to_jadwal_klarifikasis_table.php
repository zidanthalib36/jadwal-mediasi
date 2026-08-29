<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToJadwalKlarifikasisTable extends Migration
{
    public function up()
    {
        Schema::table('jadwal_klarifikasi', function (Blueprint $table) {

            $table->string('status')
                  ->default('Menunggu Jadwal')
                  ->before('hasil_kegiatan');

        });
    }

    public function down()
    {
        Schema::table('jadwal_klarifikasi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
