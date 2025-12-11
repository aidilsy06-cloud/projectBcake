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
        Schema::table('user_otps', function (Blueprint $table) {
            // Tambah kolom expired_at kalau belum ada
            if (! Schema::hasColumn('user_otps', 'expired_at')) {
                $table->dateTime('expired_at')
                      ->nullable()
                      ->after('otp_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_otps', function (Blueprint $table) {
            if (Schema::hasColumn('user_otps', 'expired_at')) {
                $table->dropColumn('expired_at');
            }
        });
    }
};
