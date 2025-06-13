<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->string('kd_lapangan')->primary();
            $table->string('nm_lapangan', 50);
            $table->string('jenis_lapangan', 30);
            $table->integer('harga_per_jam');
            $table->string('status', 20)->default('tersedia');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};