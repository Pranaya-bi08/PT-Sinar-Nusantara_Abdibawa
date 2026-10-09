<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePelangganTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelanggan_form_opens_and_stores_customer_with_phone_number(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('pelanggan.create'))
            ->assertOk()
            ->assertSee('Tambah Pelanggan');

        $this->post(route('pelanggan.store'), [
            'nama_pelanggan' => 'Pelanggan Uji',
            'no_hp' => '081234567891',
            'alamat' => 'Alamat Uji',
        ])->assertRedirect(route('pelanggan.index'));

        $this->assertDatabaseHas('pelanggans', [
            'nama_pelanggan' => 'Pelanggan Uji',
            'no_hp' => '081234567891',
            'alamat' => 'Alamat Uji',
        ]);
    }
}