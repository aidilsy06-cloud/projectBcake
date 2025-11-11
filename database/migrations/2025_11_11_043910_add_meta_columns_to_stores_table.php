<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom penting untuk tabel stores
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // 🔹 Pastikan kolom user_id (pemilik toko)
            if (!Schema::hasColumn('stores', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')
                      ->constrained('users')->onDelete('cascade');
            }

            // 🔹 Tambahkan kolom tambahan untuk profil toko
            if (!Schema::hasColumn('stores', 'tagline')) {
                $table->string('tagline')->nullable()->after('slug');
            }

            if (!Schema::hasColumn('stores', 'description')) {
                $table->text('description')->nullable()->after('tagline');
            }

            if (!Schema::hasColumn('stores', 'logo')) {
                $table->string('logo')->nullable()->after('description');
            }

            if (!Schema::hasColumn('stores', 'banner')) {
                $table->string('banner')->nullable()->after('logo');
            }
        });
    }

    /**
     * Hapus kolom yang ditambahkan saat rollback
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'banner')) $table->dropColumn('banner');
            if (Schema::hasColumn('stores', 'logo')) $table->dropColumn('logo');
            if (Schema::hasColumn('stores', 'description')) $table->dropColumn('description');
            if (Schema::hasColumn('stores', 'tagline')) $table->dropColumn('tagline');
            if (Schema::hasColumn('stores', 'user_id')) $table->dropConstrainedForeignId('user_id');
        });
    }
};
