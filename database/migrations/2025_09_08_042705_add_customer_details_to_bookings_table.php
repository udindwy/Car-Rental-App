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
        Schema::table('bookings', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'status'
            $table->string('phone_number')->after('status')->nullable();
            $table->string('ktp_path')->after('phone_number')->nullable();
            $table->string('sim_path')->after('ktp_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Mendefinisikan cara menghapus kolom jika migrasi di-rollback
            $table->dropColumn(['phone_number', 'ktp_path', 'sim_path']);
        });
    }
};
