<?php

namespace App\Services;

use App\Models\TransaksiBarangMasuk;
use App\Models\TransferBarang;
use Illuminate\Database\Eloquent\Builder;

class InventoryBalanceService
{
    public function balances(?string $asOfDate = null, ?int $itemId = null, ?int $warehouseId = null): array
    {
        $balances = [];

        $receivedQuery = TransaksiBarangMasuk::query()
            ->select('id_barang', 'id_gudang')
            ->selectRaw('SUM(jumlah) as total')
            ->groupBy('id_barang', 'id_gudang');
        $received = $this->applyFilters($receivedQuery, $asOfDate, $itemId, $warehouseId, 'id_gudang')->get();

        foreach ($received as $stock) {
            $balances["{$stock->id_barang}:{$stock->id_gudang}"] = (int) $stock->total;
        }

        $transferredInQuery = TransferBarang::query()
            ->select('id_barang', 'id_gudang_tujuan')
            ->selectRaw('SUM(jumlah) as total')
            ->groupBy('id_barang', 'id_gudang_tujuan');
        $transferredIn = $this->applyFilters(
            $transferredInQuery,
            $asOfDate,
            $itemId,
            $warehouseId,
            'id_gudang_tujuan'
        )->get();

        foreach ($transferredIn as $stock) {
            $key = "{$stock->id_barang}:{$stock->id_gudang_tujuan}";
            $balances[$key] = ($balances[$key] ?? 0) + (int) $stock->total;
        }

        $transferredOutQuery = TransferBarang::query()
            ->select('id_barang', 'id_gudang_asal')
            ->selectRaw('SUM(jumlah) as total')
            ->groupBy('id_barang', 'id_gudang_asal');
        $transferredOut = $this->applyFilters(
            $transferredOutQuery,
            $asOfDate,
            $itemId,
            $warehouseId,
            'id_gudang_asal'
        )->get();

        foreach ($transferredOut as $stock) {
            $key = "{$stock->id_barang}:{$stock->id_gudang_asal}";
            $balances[$key] = max(0, ($balances[$key] ?? 0) - (int) $stock->total);
        }

        return $balances;
    }

    public function forWarehouse(int $itemId, int $warehouseId): int
    {
        return $this->balances()["{$itemId}:{$warehouseId}"] ?? 0;
    }

    private function applyFilters(
        Builder $query,
        ?string $asOfDate,
        ?int $itemId,
        ?int $warehouseId,
        string $warehouseColumn
    ): Builder {
        return $query
            ->when($asOfDate, fn ($query) => $query->whereDate('created_at', '<=', $asOfDate))
            ->when($itemId, fn ($query) => $query->where('id_barang', $itemId))
            ->when($warehouseId, fn ($query) => $query->where($warehouseColumn, $warehouseId));
    }
}