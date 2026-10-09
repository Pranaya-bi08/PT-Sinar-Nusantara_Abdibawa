<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transfer_barangs')->insert([
            [
                'id_barang' => 1,
                'id_gudang_asal' => 1,
                'id_gudang_tujuan' => 2,
                'jumlah' => 10,
            ],
        ]);
    }
}
