<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama (disable foreign key checks)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('ukurans')->truncate();
        DB::table('topings')->truncate();
        DB::table('products')->truncate();
        DB::table('kategoris')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Buat kategori
        $kategoriId = DB::table('kategoris')->insertGetId([
            'categori' => 'Makanan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 1. TAKOYAKI
        $takoyakiId = DB::table('products')->insertGetId([
            'categori_id' => $kategoriId,
            'nm_produk' => 'Takoyaki',
            'kd_produk' => 'TAK001',
            'harga' => 12000,
            'stok' => 100,
            'image' => 'takoyaki.jpg',
            'barcode' => 'TAK001',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Topping Takoyaki
        $takoyakiSosisKejuId = DB::table('topings')->insertGetId([
            'id_product' => $takoyakiId,
            'name_toping' => 'Sosis Keju',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $takoyakiOctopusId = DB::table('topings')->insertGetId([
            'id_product' => $takoyakiId,
            'name_toping' => 'Octopus',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ukuran Takoyaki - Sosis Keju
        DB::table('ukurans')->insert([
            ['id_product' => $takoyakiId, 'id_toping' => $takoyakiSosisKejuId, 'nama' => 'S', 'harga' => 12000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $takoyakiId, 'id_toping' => $takoyakiSosisKejuId, 'nama' => 'M', 'harga' => 24000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $takoyakiId, 'id_toping' => $takoyakiSosisKejuId, 'nama' => 'L', 'harga' => 28000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ukuran Takoyaki - Octopus
        DB::table('ukurans')->insert([
            ['id_product' => $takoyakiId, 'id_toping' => $takoyakiOctopusId, 'nama' => 'S', 'harga' => 15000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $takoyakiId, 'id_toping' => $takoyakiOctopusId, 'nama' => 'M', 'harga' => 27000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $takoyakiId, 'id_toping' => $takoyakiOctopusId, 'nama' => 'L', 'harga' => 30000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. KUROYAKI
        $kuroyakiId = DB::table('products')->insertGetId([
            'categori_id' => $kategoriId,
            'nm_produk' => 'Kuroyaki',
            'kd_produk' => 'KUR001',
            'harga' => 15000,
            'stok' => 100,
            'image' => 'kuroyaki.jpg',
            'barcode' => 'KUR001',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Topping Kuroyaki
        $kuroyakiSosisKejuId = DB::table('topings')->insertGetId([
            'id_product' => $kuroyakiId,
            'name_toping' => 'Sosis Keju',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $kuroyakiOctopusId = DB::table('topings')->insertGetId([
            'id_product' => $kuroyakiId,
            'name_toping' => 'Octopus',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ukuran Kuroyaki - Sosis Keju
        DB::table('ukurans')->insert([
            ['id_product' => $kuroyakiId, 'id_toping' => $kuroyakiSosisKejuId, 'nama' => 'S', 'harga' => 15000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $kuroyakiId, 'id_toping' => $kuroyakiSosisKejuId, 'nama' => 'M', 'harga' => 27000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $kuroyakiId, 'id_toping' => $kuroyakiSosisKejuId, 'nama' => 'L', 'harga' => 30000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ukuran Kuroyaki - Octopus
        DB::table('ukurans')->insert([
            ['id_product' => $kuroyakiId, 'id_toping' => $kuroyakiOctopusId, 'nama' => 'S', 'harga' => 18000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $kuroyakiId, 'id_toping' => $kuroyakiOctopusId, 'nama' => 'M', 'harga' => 30000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $kuroyakiId, 'id_toping' => $kuroyakiOctopusId, 'nama' => 'L', 'harga' => 32000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. GRILLED GYOZA
        $grilledGyozaId = DB::table('products')->insertGetId([
            'categori_id' => $kategoriId,
            'nm_produk' => 'Grilled Gyoza',
            'kd_produk' => 'GYZ001',
            'harga' => 25000,
            'stok' => 100,
            'image' => 'grilled_gyoza.jpg',
            'barcode' => 'GYZ001',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Topping Grilled Gyoza
        $grilledGyozaDefaultId = DB::table('topings')->insertGetId([
            'id_product' => $grilledGyozaId,
            'name_toping' => 'Default',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $grilledGyozaMentaiId = DB::table('topings')->insertGetId([
            'id_product' => $grilledGyozaId,
            'name_toping' => 'Mentai',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ukuran Grilled Gyoza (tidak ada ukuran, tapi masuk ke tabel ukurans)
        DB::table('ukurans')->insert([
            ['id_product' => $grilledGyozaId, 'id_toping' => $grilledGyozaDefaultId, 'nama' => 'Standard', 'harga' => 25000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $grilledGyozaId, 'id_toping' => $grilledGyozaMentaiId, 'nama' => 'Standard', 'harga' => 30000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. OKONOMIYAKI
        $okonomiyakiId = DB::table('products')->insertGetId([
            'categori_id' => $kategoriId,
            'nm_produk' => 'Okonomiyaki',
            'kd_produk' => 'OKO001',
            'harga' => 25000,
            'stok' => 100,
            'image' => 'okonomiyaki.jpg',
            'barcode' => 'OKO001',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Topping Okonomiyaki
        $okonomiyakiDefaultId = DB::table('topings')->insertGetId([
            'id_product' => $okonomiyakiId,
            'name_toping' => 'Default',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $okonomiyakiMentaiId = DB::table('topings')->insertGetId([
            'id_product' => $okonomiyakiId,
            'name_toping' => 'Mentai',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ukuran Okonomiyaki
        DB::table('ukurans')->insert([
            ['id_product' => $okonomiyakiId, 'id_toping' => $okonomiyakiDefaultId, 'nama' => 'Standard', 'harga' => 25000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $okonomiyakiId, 'id_toping' => $okonomiyakiMentaiId, 'nama' => 'Standard', 'harga' => 30000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. DIMSUM
        $dimsumId = DB::table('products')->insertGetId([
            'categori_id' => $kategoriId,
            'nm_produk' => 'Dimsum',
            'kd_produk' => 'DIM001',
            'harga' => 25000,
            'stok' => 100,
            'image' => 'dimsum.jpg',
            'barcode' => 'DIM001',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Topping Dimsum
        $dimsumDefaultId = DB::table('topings')->insertGetId([
            'id_product' => $dimsumId,
            'name_toping' => 'Default',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $dimsumMentaiId = DB::table('topings')->insertGetId([
            'id_product' => $dimsumId,
            'name_toping' => 'Mentai',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ukuran Dimsum
        DB::table('ukurans')->insert([
            ['id_product' => $dimsumId, 'id_toping' => $dimsumDefaultId, 'nama' => 'Standard', 'harga' => 25000, 'created_at' => now(), 'updated_at' => now()],
            ['id_product' => $dimsumId, 'id_toping' => $dimsumMentaiId, 'nama' => 'Standard', 'harga' => 30000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. PISCOK
        $piscokId = DB::table('products')->insertGetId([
            'categori_id' => $kategoriId,
            'nm_produk' => 'Piscok',
            'kd_produk' => 'PIS001',
            'harga' => 15000,
            'stok' => 100,
            'image' => 'piscok.jpg',
            'barcode' => 'PIS001',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Topping Piscok (Default saja untuk menu tanpa topping)
        $piscokDefaultId = DB::table('topings')->insertGetId([
            'id_product' => $piscokId,
            'name_toping' => 'Default',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Ukuran Piscok
        DB::table('ukurans')->insert([
            ['id_product' => $piscokId, 'id_toping' => $piscokDefaultId, 'nama' => 'Standard', 'harga' => 15000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Buat 500 orders dengan random menu, ukuran, topping
        $ukurans = DB::table('ukurans')->get();
        $products = DB::table('products')->get();

        for($i = 0; $i < 500; $i++) {
            $menu = $ukurans->random();
            $product = $products->where('id', $menu->id_product)->first();
            $qty = rand(1, 5);

            $total = $menu->harga * $qty;
            $bayar = ceil($total / 5000) * 5000;

            $orderId = DB::table('orders')->insertGetId([
                'user_id' => 16,
                'total' => $total,
                'total_bayar' => $bayar,
                'kembalian' => $bayar - $total,
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(rand(0, 120)),
                'updated_at' => Carbon::now()
            ]);

            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_id' => $menu->id_product,
                'toping_id' => $menu->id_toping,
                'ukuran_id' => $menu->id,
                'qty' => $qty,
                'price' => $menu->harga,
                'total' => $total,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
