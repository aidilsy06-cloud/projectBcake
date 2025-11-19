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
        // Kolom user_id di tabel products sudah ada,
        // jadi migration ini kita kosongkan agar tidak error duplicate column.
        if (! Schema::hasColumn('products', 'user_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                // kalau mau foreign key, bisa tambahkan di sini:
                // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: hanya hapus kalau kolomnya memang ada
        if (Schema::hasColumn('products', 'user_id')) {
            Schema::table('products', function (Blueprint $table) {
                // Kalau tadi kamu bikin foreign key, hapus dulu:
                // $table->dropForeign(['user_id']);

                // Lalu hapus kolom (kalau kamu mau benar-benar rollback)
                // $table->dropColumn('user_id');
            });
        }
    }
};
