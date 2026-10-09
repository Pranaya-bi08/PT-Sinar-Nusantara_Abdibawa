<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LaporanBarangTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_shows_stock_balances_for_each_warehouse(): void
    {
        $user = User::factory()->create();
        $now = now();
        $yesterday = $now->copy()->subDay();
        $kategoriId = DB::table('kategoris')->insertGetId([
            'nama_kategori' => 'Kategori Uji',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $barangId = DB::table('barangs')->insertGetId([
            'sku' => 'SKU-LAPORAN-01',
            'nama_barang' => 'Barang Laporan Uji',
            'id_kategori' => $kategoriId,
            'satuan' => 'pcs',
            'harga_pokok' => 1000,
            'harga_jual' => 1500,
            'status_aktif' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $gudangAsalId = DB::table('gudangs')->insertGetId([
            'kode_gudang' => 'G-LAP-01',
            'nama_gudang' => 'Gudang Asal Uji',
            'lokasi' => 'Lokasi Asal',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $gudangTujuanId = DB::table('gudangs')->insertGetId([
            'kode_gudang' => 'G-LAP-02',
            'nama_gudang' => 'Gudang Tujuan Uji',
            'lokasi' => 'Lokasi Tujuan',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('transaksi_barang_masuks')->insert([
            'id_barang' => $barangId,
            'id_gudang' => $gudangAsalId,
            'jumlah' => 8,
            'total_harga' => 8000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('transaksi_barang_masuks')->insert([
            'id_barang' => $barangId,
            'id_gudang' => $gudangAsalId,
            'jumlah' => 4,
            'total_harga' => 4000,
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
        ]);
        DB::table('transfer_barangs')->insert([
            'id_barang' => $barangId,
            'id_gudang_asal' => $gudangAsalId,
            'id_gudang_tujuan' => $gudangTujuanId,
            'jumlah' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pelangganId = DB::table('pelanggans')->insertGetId([
            'nama_pelanggan' => 'Pelanggan Hari Ini',
            'no_hp' => '081111111111',
            'alamat' => 'Alamat Hari Ini',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $pelangganLamaId = DB::table('pelanggans')->insertGetId([
            'nama_pelanggan' => 'Pelanggan Kemarin',
            'no_hp' => '082222222222',
            'alamat' => 'Alamat Kemarin',
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
        ]);
        DB::table('penjualans')->insert([
            'id_barang' => $barangId,
            'id_pelanggan' => $pelangganId,
            'jumlah' => 2,
            'total_harga' => 3000,
            'status' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('penjualans')->insert([
            'id_barang' => $barangId,
            'id_pelanggan' => $pelangganLamaId,
            'jumlah' => 4,
            'total_harga' => 6000,
            'status' => 'aktif',
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
        ]);

        $this->actingAs($user)
            ->get(route('laporan.index'))
            ->assertOk()
            ->assertSee('Barang Laporan Uji')
            ->assertSee('Kategori Uji')
            ->assertSee('Gudang Asal Uji')
            ->assertSee('Gudang Tujuan Uji')
            ->assertSee('9')
            ->assertSee('3')
            ->assertSee('<strong>12</strong>', false)
            ->assertSee('Pelanggan Hari Ini')
            ->assertSee('Pelanggan Kemarin')
            ->assertSee('Rp 12.000');

        $this->actingAs($user)
            ->get(route('laporan.index', [
                'tanggal_dari' => $now->toDateString(),
                'tanggal_sampai' => $now->toDateString(),
                'gudang_id' => $gudangAsalId,
                'barang_id' => $barangId,
            ]))
            ->assertOk()
            ->assertSee('Gudang Asal Uji: Awal')
            ->assertSee('Pelanggan Hari Ini')
            ->assertDontSee('Pelanggan Kemarin')
            ->assertSee('Rp 3.000');
    }
}