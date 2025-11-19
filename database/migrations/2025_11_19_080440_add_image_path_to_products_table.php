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
        Schema::table('products', function (Blueprint $table) {
            // DI SINI TIDAK USAH TAMBAH user_id LAGI

            // Kalau kamu mau jaga-jaga supaya kolom image_url ada:
            if (! Schema::hasColumn('products', 'image_url')) {
                $table->string('image_url')->nullable()->after('stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback opsional untuk image_url
            if (Schema::hasColumn('products', 'image_url')) {
                // kalau takut terhapus, bagian ini boleh kamu kosongkan
                // $table->dropColumn('image_url');
            }
        });
    }
};
