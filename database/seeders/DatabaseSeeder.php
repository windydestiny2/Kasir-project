<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'name' => 'Kasir1',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir123'),
        ]);

        // DB::table('products')->insert([
        //     'nm_produk' => 'Kasir1',
        //     'kd_produk' => '045',
        //     'harga' => 20000,
        //     'stok' => 2,
        //     'image' => 'flutter.png',
        //     'barcode' => 'barcode.pp'
        // ]);
        // DB::table('products')->insert([
        //     'nm_produk' => 'Kasir2',
        //     'kd_produk' => '04',
        //     'harga' => 20000,
        //     'stok' => 2,
        //     'image' => 'flutter.png',
        //     'barcode' => 'barcode.pp'
        // ]);
        // DB::table('products')->insert([
        //     'nm_produk' => 'Kasir3',
        //     'kd_produk' => '05',
        //     'harga' => 20000,
        //     'stok' => 2,
        //     'image' => 'flutter.png',
        //     'barcode' => 'barcode.pp'
        // ]);
    }
}
