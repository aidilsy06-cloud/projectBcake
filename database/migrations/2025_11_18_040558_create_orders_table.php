<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Kode pesanan unik (misal: BC-20251121-001)
            $table->string('order_code', 50)->unique();

            // Relasi
            $table->foreignId('user_id')->constrained()->onDelete('cascade');   // buyer
            $table->foreignId('store_id')->constrained()->onDelete('cascade');  // toko

            // Data customer (boleh sama dengan user, tapi disimpan biar aman)
            $table->string('customer_name', 100);
            $table->string('customer_phone', 30);
            $table->text('customer_address');

            // Total
            $table->unsignedBigInteger('total_amount')->default(0);

            // Status tracking
            $table->enum('status', [
                'pending',    // baru checkout
                'diproses',   // toko sedang buat
                'dikirim',    // sedang dikirim
                'selesai',    // sudah diterima
                'dibatalkan', // batal
            ])->default('pending');

            // Opsi pembayaran / catatan
            $table->string('payment_method', 50)->nullable(); // COD, Transfer, dll
            $table->text('note')->nullable(); // catatan pembeli
            $table->text('admin_note')->nullable(); // catatan admin / seller

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
