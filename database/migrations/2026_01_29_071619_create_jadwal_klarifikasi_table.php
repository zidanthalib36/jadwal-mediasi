<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_klarifikasi', function (Blueprint $table) {
    $table->id();

    $table->string('nama_kegiatan');

    // klarifikasi 1, klarifikasi 2, mediasi 1, mediasi 2
    $table->string('jenis_kegiatan');

    $table->date('tanggal_mulai');
    $table->time('waktu_mulai');

    $table->date('tanggal_selesai');
    $table->time('waktu_selesai');

    // pengingat dalam menit (opsional)
    $table->integer('pengingat')->nullable();

    // Ruang Klarifikasi Dan Mediasi / Zoom
    $table->string('tempat');
    $table->string('link_zoom')->nullable();

    $table->string('email_petugas');
    $table->string('email_p3mi');

    $table->string('nomor_pengaduan');
    $table->string('nama_pmi');
    $table->string('nama_pengadu');
    $table->string('p3mi');

    $table->text('deskripsi_kasus');

    $table->text('hasil_kegiatan')->nullable();
    $table->string('foto')->nullable();

    $table->string('event_id')->nullable();

    // PIC dari list
    $table->string('pic');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_klarifikasi');
    }
};
