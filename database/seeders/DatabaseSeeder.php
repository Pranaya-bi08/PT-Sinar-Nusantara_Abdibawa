<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([BarangSeeder::class]);
        $this->call([KategoriSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([PelangganSeeder::class]);
        $this->call([GudangSeeder::class]);
        $this->call([TransaksiBarangMasukSeeder::class]);
        $this->call([PenjualanSeeder::class]);

    }
}
