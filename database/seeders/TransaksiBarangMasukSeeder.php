<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiBarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksi_barang_masuks')->insert([
            [
                'id_barang' => 1,
                'id_gudang' => 1,
                'jumlah' => 10,
                'total_harga' => 100000,
            ],
        ]);
    }
}
