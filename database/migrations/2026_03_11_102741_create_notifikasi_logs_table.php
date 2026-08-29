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
        Schema::create('notifikasi_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('jadwal_id')->constrained('jadwal_klarifikasi')->onDelete('cascade');
    $table->string('channel'); // email / whatsapp
    $table->string('tipe_notifikasi');
    $table->string('tujuan');
    $table->string('kontak');
    $table->string('status'); // berhasil / gagal
    $table->text('response')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_logs');
    }
};
