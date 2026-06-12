<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories first
        $this->call(KategoriArtikelSeeder::class);

        // Create admin user with strong password (if not exists)
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Super',
                'nama_depan' => 'Admin',
                'nama_belakang' => 'Super',
                'user_name' => 'admin',
                'password' => Hash::make('Admin@Secure123'),
                'role' => 'admin',
                'foto' => 'default.png',
            ]
        );

        // Create penulis user with strong password (if not exists)
        User::firstOrCreate(
            ['email' => 'penulis@example.com'],
            [
                'name' => 'Penulis Blog',
                'nama_depan' => 'Penulis',
                'nama_belakang' => 'Blog',
                'user_name' => 'penulis1',
                'password' => Hash::make('Penulis@Secure123'),
                'role' => 'penulis',
                'foto' => 'default.png',
            ]
        );
    }
}
