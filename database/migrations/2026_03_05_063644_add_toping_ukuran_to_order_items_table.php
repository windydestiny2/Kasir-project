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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('toping_id')->nullable()->constrained('topings')->onDelete('cascade');
            $table->foreignId('ukuran_id')->nullable()->constrained('ukurans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['toping_id']);
            $table->dropForeign(['ukuran_id']);
            $table->dropColumn(['toping_id', 'ukuran_id']);
        });
    }
};
