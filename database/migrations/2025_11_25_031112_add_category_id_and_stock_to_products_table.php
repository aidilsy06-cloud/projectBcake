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

            // Tambah kolom category_id kalau belum ada
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')
                      ->nullable()
                      ->after('store_id');

                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->nullOnDelete();
            }

            // Tambah kolom stock kalau belum ada
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')
                      ->default(0)
                      ->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // rollback kolom category_id
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            // rollback kolom stock
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }
};
