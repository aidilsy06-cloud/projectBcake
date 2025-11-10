<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            // sesuaikan tipe kolom primary key stores (bigIncrements => foreignId)
            $table->foreignId('store_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('store_id');
        });
    }
};
