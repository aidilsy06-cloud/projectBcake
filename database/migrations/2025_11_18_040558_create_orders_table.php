<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // relasi ke user & store
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();

            // info customer
            $table->string('customer_name', 100);
            $table->string('customer_phone', 30);
            $table->string('customer_address', 255)->nullable();

            // ringkasan pesanan (misal dari keranjang)
            $table->text('order_summary'); // contoh: "2x Red Velvet, 1x Brownies..."

            $table->text('note')->nullable();

            // status sederhana, nanti bisa dikembangin
            $table->string('status', 30)->default('draft'); // draft | sent | done | cancelled

            $table->timestamp('wa_sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
