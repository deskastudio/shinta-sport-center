<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kd_customer');
            $table->string('kd_lapangan');
            $table->string('kd_slot');
            $table->date('tgl_booking');
            $table->date('tgl_main');
            $table->integer('total_harga');
            $table->string('status_booking', 30)->default('pending');
            $table->string('metode_bayar', 30)->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan')->nullable();

            // Foreign key constraints
            $table->foreign('kd_customer')->references('kd_customer')->on('customers')->onDelete('cascade');
            $table->foreign('kd_lapangan')->references('kd_lapangan')->on('lapangans')->onDelete('cascade');
            $table->foreign('kd_slot')->references('kd_slot')->on('slot_waktus')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};