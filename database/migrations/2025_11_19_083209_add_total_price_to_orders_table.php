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
        Schema::table('orders', function (Blueprint $table) {

            // Tambah kolom total_price
            // Letakkan setelah order_summary agar rapi
            $table->integer('total_price')
                  ->default(0)
                  ->after('order_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // Hapus kolom jika rollback
            $table->dropColumn('total_price');
        });
    }
};
