<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'sku' => 'BRG001',
                'nama_barang' => 'Beras',
                'id_kategori' => 1,
                'satuan' => '10 Kg',
                'harga_pokok' => 10000,
                'harga_jual' => 15000,
                'status_aktif' => 'Tersedia',
            ],

        ]);
    }
}
