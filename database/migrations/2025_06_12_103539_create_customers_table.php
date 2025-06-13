<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('kd_customer')->primary();
            $table->string('nm_customer', 50);
            $table->string('email')->unique();
            $table->string('no_hp', 15);
            $table->text('alamat');
            $table->string('username', 30)->unique();
            $table->string('password');
            $table->string('status', 20)->default('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};