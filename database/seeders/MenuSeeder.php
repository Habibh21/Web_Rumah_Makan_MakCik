<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // --- MAKANAN ---
            [
                'nama'     => 'Nasi Goreng Spesial Mak Cik',
                'kategori' => 'Makanan',
                'harga'    => 25000,
                'stok'     => 20,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Ayam Bakar Bumbu Madu',
                'kategori' => 'Makanan',
                'harga'    => 28000,
                'stok'     => 15,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Mie Goreng Seafood',
                'kategori' => 'Makanan',
                'harga'    => 24000,
                'stok'     => 12,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Soto Ayam Kampung',
                'kategori' => 'Makanan',
                'harga'    => 22000,
                'stok'     => 18,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Nasi Ayam Geprek Keju',
                'kategori' => 'Makanan',
                'harga'    => 23000,
                'stok'     => 0, // Stok Habis
                'gambar'   => 'default.jpg',
            ],

            // --- MINUMAN ---
            [
                'nama'     => 'Es Teh Manis Jumbo',
                'kategori' => 'Minuman',
                'harga'    => 6000,
                'stok'     => 100,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Es Jeruk Perah',
                'kategori' => 'Minuman',
                'harga'    => 8000,
                'stok'     => 45,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Es Kopi Susu Gula Aren',
                'kategori' => 'Minuman',
                'harga'    => 18000,
                'stok'     => 30,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Jus Alpukat Kocok',
                'kategori' => 'Minuman',
                'harga'    => 16000,
                'stok'     => 14,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Es Matcha Latte',
                'kategori' => 'Minuman',
                'harga'    => 20000,
                'stok'     => 0, // Stok Habis
                'gambar'   => 'default.jpg',
            ],

            // --- SNACK / CEMILAN ---
            [
                'nama'     => 'Kentang Goreng Crispy',
                'kategori' => 'Snack',
                'harga'    => 15000,
                'stok'     => 25,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Roti Bakar Cokelat Keju',
                'kategori' => 'Snack',
                'harga'    => 16000,
                'stok'     => 20,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Pisang Goreng Keju',
                'kategori' => 'Snack',
                'harga'    => 14000,
                'stok'     => 18,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Cireng Bumbu Rujak',
                'kategori' => 'Snack',
                'harga'    => 12000,
                'stok'     => 30,
                'gambar'   => 'default.jpg',
            ],
            [
                'nama'     => 'Dimsum Ayam Mix (4 pcs)',
                'kategori' => 'Snack',
                'harga'    => 18000,
                'stok'     => 0, // Stok Habis
                'gambar'   => 'default.jpg',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}