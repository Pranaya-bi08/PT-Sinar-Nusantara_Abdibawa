<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\TransferBarang;
use App\Services\InventoryBalanceService;

class TransferBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferBarang = TransferBarang::with(['barang', 'gudangAsal', 'gudangTujuan'])
            ->latest()
            ->paginate(10);

        return view('transaksi.transfer_barang.index', compact('transferBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(InventoryBalanceService $inventory)
    {
        $barang = Barang::orderBy('nama_barang')->get(['id', 'sku', 'nama_barang', 'satuan']);
        $gudang = Gudang::orderBy('nama_gudang')->get(['id', 'nama_gudang']);
        $stockBalances = $inventory->balances();

        return view('transaksi.transfer_barang.create', compact('barang', 'gudang', 'stockBalances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, InventoryBalanceService $inventory)
    {
        $validated = $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_gudang_asal' => 'required|exists:gudangs,id',
            'id_gudang_tujuan' => 'required|different:id_gudang_asal|exists:gudangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $inventory) {
            Barang::query()->whereKey($validated['id_barang'])->lockForUpdate()->firstOrFail();

            $available = $inventory->forWarehouse(
                (int) $validated['id_barang'],
                (int) $validated['id_gudang_asal']
            );

            if ($validated['jumlah'] > $available) {
                throw ValidationException::withMessages([
                    'jumlah' => "Stok di gudang asal hanya tersedia {$available}.",
                ]);
            }

            TransferBarang::create($validated);
        });

        return redirect()->route('transfer.index')
            ->with('success', 'Transfer barang berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_barang' => 'required',
            'id_gudang_asal' => 'required',
            'id_gudang_tujuan' => 'required',
            'jumlah' => 'required',
        ]);

        $transferBarang = TransferBarang::findOrFail($id);
        $transferBarang->update($request->all());

        return redirect()->route('transfer.index')
            ->with('success', 'Transfer Barang updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
