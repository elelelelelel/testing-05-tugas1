<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produks')->insert([
            [
                'nama' => 'Produk 1',
                'img_path' => '1637937635_testing.jpeg',
                'jenis' => 1,
                'harga' => 1000,
                'isavail' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 2',
                'img_path' => '1638284720_testing.jpeg',
                'jenis' => 2,
                'harga' => 2000,
                'isavail' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 3',
                'img_path' => '1638284720_testing.jpeg',
                'jenis' => 2,
                'harga' => 3000,
                'isavail' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 4',
                'img_path' => '1638284720_testing.jpeg',
                'jenis' => 1,
                'harga' => 4000,
                'isavail' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 5',
                'img_path' => '1638284720_testing.jpeg',
                'jenis' => 2,
                'harga' => 6000,
                'isavail' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 6',
                'img_path' => '1638284720_testing.jpeg',
                'jenis' => 1,
                'harga' => 6000,
                'isavail' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            // tambahkan data produk lainnya di sini
        ]);
    }
}
