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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('about')->nullable();
            $table->string('addres')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profil')->nullable();

            $table->integer('dashboard')->nullable();
            $table->integer('admin')->nullable();
            $table->integer('product')->nullable();
            $table->integer('kategori')->nullable();
            $table->integer('orderpes')->nullable();
            $table->integer('riwayat')->nullable();
            $table->integer('pengeluaran')->nullable();
            $table->integer('toping')->nullable();
            $table->integer('ukuran')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
