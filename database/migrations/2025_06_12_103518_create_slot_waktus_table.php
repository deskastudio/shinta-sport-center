<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot_waktus', function (Blueprint $table) {
            $table->string('kd_slot')->primary();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('display_waktu', 50);
            $table->string('status', 20)->default('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot_waktus');
    }
};