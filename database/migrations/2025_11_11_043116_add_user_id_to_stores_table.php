<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasinya
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Tambah kolom user_id (nullable dulu biar aman)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained() // otomatis relasi ke tabel users.id
                  ->nullOnDelete() // kalau user dihapus, user_id jadi null
                  ->after('id');   // taruh setelah kolom id
        });
    }

    /**
     * Balikkan perubahan (rollback)
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Hapus foreign key dan kolom saat rollback
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
