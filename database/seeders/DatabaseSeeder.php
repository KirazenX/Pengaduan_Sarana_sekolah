<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat kategori
        DB::table('kategoris')->insert([
            ['id_kategori' => 1, 'ket_kategori' => 'Kebersihan', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 2, 'ket_kategori' => 'Fasilitas Kelas', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 3, 'ket_kategori' => 'Kantin', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 4, 'ket_kategori' => 'Toilet', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 5, 'ket_kategori' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Buat akun admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
