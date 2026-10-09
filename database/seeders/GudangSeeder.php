<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gudangs')->insert([
            [
                'kode_gudang' => 'GUD001',
                'nama_gudang' => 'Gudang Utama',
                'lokasi' => 'Jakarta',
            ],
        ]);
    }
}
