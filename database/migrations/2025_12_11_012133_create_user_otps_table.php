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
        if (! Schema::hasTable('user_otps')) {
            Schema::create('user_otps', function (Blueprint $table) {
                $table->id();

                // user yang terkait OTP
                $table->foreignId('user_id')
                      ->constrained()
                      ->onDelete('cascade');

                // kode OTP, misal 6 digit
                $table->string('otp_code', 10);

                // jenis OTP: register / reset_password dll
                $table->string('type', 30)->default('register');

                // waktu expired
                $table->dateTime('expires_at')->nullable();

                // sudah dipakai atau belum
                $table->boolean('used')->default(false);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_otps');
    }
};
