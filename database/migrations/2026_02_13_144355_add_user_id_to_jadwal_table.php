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
    Schema::table('jadwal_klarifikasi', function (Blueprint $table) {

        if (!Schema::hasColumn('jadwal_klarifikasi', 'whatsapp_p3mi')) {
            $table->string('whatsapp_p3mi')->after('tempat');
        }

        if (!Schema::hasColumn('jadwal_klarifikasi', 'user_id')) {
            $table->foreignId('user_id')
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('cascade');
        }

        if (Schema::hasColumn('jadwal_klarifikasi', 'email_petugas')) {
            $table->dropColumn('email_petugas');
        }
    });
}


public function down(): void
{
    Schema::table('jadwal_klarifikasi', function (Blueprint $table) {

        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');

        $table->dropColumn('whatsapp_p3mi');

        $table->string('email_petugas')->nullable();
    });
}

};
