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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categori_id')->constrained('kategoris')->onDelete('cascade');
            // $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nm_produk');
            $table->string('kd_produk')->unique();
            $table->bigInteger('harga');
            $table->integer('stok');
            $table->string('image');
            $table->string('barcode');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
