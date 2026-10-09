<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CancelPenjualanTest extends TestCase
{
    use RefreshDatabase;

    public function test_cancelling_a_sale_keeps_the_record_and_stores_the_reason(): void
    {
        $user = User::factory()->create();
        $now = now();

        $barangId = DB::table('barangs')->insertGetId([
            'sku' => 'SKU-TEST-01',
            'nama_barang' => 'Barang Uji',
            'id_kategori' => 1,
            'satuan' => 'pcs',
            'harga_pokok' => 1000,
            'harga_jual' => 1500,
            'status_aktif' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pelangganId = DB::table('pelanggans')->insertGetId([
            'nama_pelanggan' => 'Pelanggan Uji',
            'no_hp' => '081234567890',
            'alamat' => 'Alamat Uji',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $penjualanId = DB::table('penjualans')->insertGetId([
            'id_barang' => $barangId,
            'id_pelanggan' => $pelangganId,
            'jumlah' => 2,
            'total_harga' => 3000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->actingAs($user)
            ->post(route('penjualan.cancel', $penjualanId), [
                'alasan_pembatalan' => 'Pesanan dibuat dua kali',
            ])
            ->assertRedirect(route('penjualan.cancellation.index'));

        $this->assertDatabaseCount('penjualans', 1);
        $this->assertDatabaseHas('penjualans', [
            'id' => $penjualanId,
            'status' => 'dibatalkan',
            'alasan_pembatalan' => 'Pesanan dibuat dua kali',
        ]);
        $this->assertNotNull(DB::table('penjualans')->where('id', $penjualanId)->value('dibatalkan_pada'));
    }
}