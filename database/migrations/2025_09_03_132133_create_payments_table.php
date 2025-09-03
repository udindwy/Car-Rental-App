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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();

            // PASTIKAN KOLOM INI BENAR
            $table->enum('method', ['cash', 'transfer', 'gateway']);

            $table->decimal('amount', 12, 2);

            // PASTIKAN KOLOM INI JUGA BENAR
            $table->enum('status', ['unpaid', 'paid', 'failed', 'refunded']);

            $table->timestamp('paid_at')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
