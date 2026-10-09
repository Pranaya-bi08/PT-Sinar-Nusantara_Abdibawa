<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggans')->insert([
            [
                'nama_pelanggan' => 'John Doe',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Los Angels No. 123',
            ],
        ]);
    }
}
