<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CreateBarangTest extends TestCase
{
    use RefreshDatabase;

    public function test_barang_can_be_created_with_a_category(): void
    {
        $user = User::factory()->create();
        $now = now();
        $kategoriId = DB::table('kategoris')->insertGetId([
            'nama_kategori' => 'Makanan',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->actingAs($user)
            ->get(route('barang.create'))
            ->assertOk()
            ->assertSee('Tambah Barang')
            ->assertSee('Makanan');

        $this->post(route('barang.store'), [
            'sku' => 'BRG-TEST-01',
            'nama_barang' => 'Beras Uji',
            'id_kategori' => $kategoriId,
            'satuan' => '10 Kg',
            'harga_pokok' => 10000,
            'harga_jual' => 15000,
            'status_aktif' => 'Tersedia',
        ])->assertRedirect(route('barang.index'));

        $this->assertDatabaseHas('barangs', [
            'sku' => 'BRG-TEST-01',
            'nama_barang' => 'Beras Uji',
            'id_kategori' => $kategoriId,
            'status_aktif' => 'Tersedia',
        ]);
    }
}