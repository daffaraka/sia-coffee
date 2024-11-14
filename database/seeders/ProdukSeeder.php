<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Produk::create([
                'nama_produk' => "Produk $i",
                'deskripsi' => "Deskripsi produk $i",
                'harga_produk' => rand(10000, 100000),
                'gambar_produk' => "produk-$i.jpg",
            ]);
        }
    }
}
