<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penjualans')->insert([
            [
                'id_pelanggan' => 1,
                'id_barang' => 1,
                'jumlah' => 5,
                'total_harga' => 50000,
            ],
        ]);
    }
}
