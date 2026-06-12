<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriArtikel;

class KategoriArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Teknologi', 'keterangan' => 'Artikel tentang teknologi terbaru'],
            ['nama_kategori' => 'Pendidikan', 'keterangan' => 'Artikel tentang pendidikan dan pembelajaran'],
            ['nama_kategori' => 'Kesehatan', 'keterangan' => 'Artikel tentang kesehatan dan kebugaran'],
            ['nama_kategori' => 'Bisnis', 'keterangan' => 'Artikel tentang bisnis dan ekonomi'],
            ['nama_kategori' => 'Olahraga', 'keterangan' => 'Artikel tentang olahraga dan kebugaran'],
            ['nama_kategori' => 'Hiburan', 'keterangan' => 'Artikel tentang hiburan dan gaya hidup'],
            ['nama_kategori' => 'Wisata', 'keterangan' => 'Artikel tentang wisata dan travel'],
            ['nama_kategori' => 'Kuliner', 'keterangan' => 'Artikel tentang makanan dan minuman'],
            ['nama_kategori' => 'Sains', 'keterangan' => 'Artikel tentang sains dan penelitian'],
            ['nama_kategori' => 'Politik', 'keterangan' => 'Artikel tentang politik dan pemerintahan'],
        ];

        foreach ($categories as $category) {
            KategoriArtikel::firstOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                ['keterangan' => $category['keterangan']]
            );
        }
    }
}
