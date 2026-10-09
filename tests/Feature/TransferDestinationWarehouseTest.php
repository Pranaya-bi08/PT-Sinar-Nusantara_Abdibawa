<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferDestinationWarehouseTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_warehouse_can_be_added_and_selected_for_transfer(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('gudang.store'), [
                'kode_gudang' => 'GUD002',
                'nama_gudang' => 'Gudang Cabang',
                'lokasi' => 'Bandung',
                'return_to' => 'transfer',
            ])
            ->assertRedirect(route('transfer.create'));

        $this->assertDatabaseHas('gudangs', [
            'kode_gudang' => 'GUD002',
            'nama_gudang' => 'Gudang Cabang',
            'lokasi' => 'Bandung',
        ]);

        $this->get(route('transfer.create'))
            ->assertOk()
            ->assertSee('Gudang Cabang');
    }
}