<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Penjualan;
use App\Models\TransaksiBarangMasuk;
use App\Services\InventoryBalanceService;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request, InventoryBalanceService $inventory)
    {
        $filters = $request->validate([
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
            'gudang_id' => 'nullable|integer|exists:gudangs,id',
            'barang_id' => 'nullable|integer|exists:barangs,id',
        ]);

        $barangQuery = Barang::with('kategori')
            ->when($filters['barang_id'] ?? null, fn ($query, $id) => $query->whereKey($id))
            ->orderBy('nama_barang');

        $barang = $barangQuery->get();
        $pilihanBarang = Barang::orderBy('nama_barang')->get(['id', 'sku', 'nama_barang']);
        $gudang = Gudang::orderBy('nama_gudang')->get(['id', 'nama_gudang']);
        $gudangLaporan = isset($filters['gudang_id'])
            ? $gudang->where('id', (int) $filters['gudang_id'])->values()
            : $gudang;
        $itemId = isset($filters['barang_id']) ? (int) $filters['barang_id'] : null;
        $warehouseId = isset($filters['gudang_id']) ? (int) $filters['gudang_id'] : null;
        $tanggalDari = $filters['tanggal_dari'] ?? null;
        $tanggalSampai = $filters['tanggal_sampai'] ?? now()->toDateString();
        $tanggalStokAwal = $tanggalDari
            ? Carbon::parse($tanggalDari)->subDay()->toDateString()
            : null;
        $saldoAwal = $tanggalStokAwal
            ? $inventory->balances($tanggalStokAwal, $itemId, $warehouseId)
            : [];
        $saldoAkhir = $inventory->balances($tanggalSampai, $itemId, $warehouseId);

        $laporanStok = $barang->map(function ($item) use ($gudangLaporan, $saldoAwal, $saldoAkhir) {
            $stokAwalPerGudang = $gudangLaporan->mapWithKeys(function ($warehouse) use ($item, $saldoAwal) {
                return [$warehouse->id => (int) ($saldoAwal["{$item->id}:{$warehouse->id}"] ?? 0)];
            });
            $stokAkhirPerGudang = $gudangLaporan->mapWithKeys(function ($warehouse) use ($item, $saldoAkhir) {
                return [$warehouse->id => (int) ($saldoAkhir["{$item->id}:{$warehouse->id}"] ?? 0)];
            });
            $totalStokAwal = $stokAwalPerGudang->sum();
            $totalStokAkhir = $stokAkhirPerGudang->sum();

            return [
                'barang' => $item,
                'stok_awal_per_gudang' => $stokAwalPerGudang,
                'stok_akhir_per_gudang' => $stokAkhirPerGudang,
                'total_stok_awal' => $totalStokAwal,
                'total_stok_akhir' => $totalStokAkhir,
                'nilai_stok' => $totalStokAkhir * (int) $item->harga_pokok,
            ];
        });

        $totalStokAwal = $laporanStok->sum('total_stok_awal');
        $totalStokAkhir = $laporanStok->sum('total_stok_akhir');
        $totalNilaiStok = $laporanStok->sum('nilai_stok');

        $barangMasukQuery = TransaksiBarangMasuk::with(['barang', 'gudang'])
            ->when($tanggalDari, fn ($query) => $query->whereDate('created_at', '>=', $tanggalDari))
            ->when($filters['tanggal_sampai'] ?? null, fn ($query, $date) => $query->whereDate('created_at', '<=', $date))
            ->when($warehouseId, fn ($query) => $query->where('id_gudang', $warehouseId))
            ->when($itemId, fn ($query) => $query->where('id_barang', $itemId));
        $totalBarangMasuk = (clone $barangMasukQuery)->sum('total_harga');
        $laporanBarangMasuk = $barangMasukQuery
            ->latest()
            ->paginate(10, ['*'], 'masuk_page')
            ->withQueryString()
            ->fragment('barang-masuk');

        $penjualanQuery = Penjualan::with(['barang', 'pelanggan'])
            ->where('status', 'aktif')
            ->when($tanggalDari, fn ($query) => $query->whereDate('created_at', '>=', $tanggalDari))
            ->when($filters['tanggal_sampai'] ?? null, fn ($query, $date) => $query->whereDate('created_at', '<=', $date))
            ->when($itemId, fn ($query) => $query->where('id_barang', $itemId));
        $totalPenjualan = (clone $penjualanQuery)->sum('total_harga');
        $laporanPenjualan = $penjualanQuery
            ->latest()
            ->paginate(10, ['*'], 'penjualan_page')
            ->withQueryString()
            ->fragment('laporan-penjualan');

        return view('home.laporan.index', compact(
            'laporanStok',
            'gudang',
            'gudangLaporan',
            'pilihanBarang',
            'tanggalDari',
            'tanggalSampai',
            'totalStokAwal',
            'totalStokAkhir',
            'totalNilaiStok',
            'laporanBarangMasuk',
            'totalBarangMasuk',
            'laporanPenjualan',
            'totalPenjualan'
        ));
    }
}