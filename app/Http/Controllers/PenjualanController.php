<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $penjualan = Penjualan::with(['barang', 'pelanggan'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->input('q');

                $query->whereHas('barang', function ($barangQuery) use ($search) {
                    $barangQuery->where('sku', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                })->orWhereHas('pelanggan', function ($pelangganQuery) use ($search) {
                    $pelangganQuery->where('nama_pelanggan', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('tanggal_dari'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->input('tanggal_dari'));
            })
            ->when($request->filled('tanggal_sampai'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->input('tanggal_sampai'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('home.penjualan.index', compact('penjualan'));
    }

    public function cancellationIndex()
    {
        $transaksiAktif = Penjualan::with(['barang', 'pelanggan'])
            ->where('status', 'aktif')
            ->latest()
            ->paginate(10, ['*'], 'aktif_page')
            ->withQueryString();

        $riwayatPembatalan = Penjualan::with(['barang', 'pelanggan'])
            ->where('status', 'dibatalkan')
            ->latest('dibatalkan_pada')
            ->paginate(10, ['*'], 'riwayat_page')
            ->withQueryString();

        return view('home.pembatalan_transaksi.index', compact('transaksiAktif', 'riwayatPembatalan'));
    }

    public function cancel(Request $request, Penjualan $penjualan)
    {
        $validated = $request->validate([
            'alasan_pembatalan' => 'required|string|max:1000',
        ]);

        $sudahDibatalkan = false;

        DB::transaction(function () use ($penjualan, $validated, &$sudahDibatalkan) {
            $transaksi = Penjualan::query()
                ->lockForUpdate()
                ->findOrFail($penjualan->id);

            if ($transaksi->status === 'dibatalkan') {
                $sudahDibatalkan = true;
                return;
            }

            $transaksi->update([
                'status' => 'dibatalkan',
                'dibatalkan_pada' => now(),
                'alasan_pembatalan' => $validated['alasan_pembatalan'],
            ]);
        });

        return redirect()->route('penjualan.cancellation.index')->with(
            $sudahDibatalkan ? 'warning' : 'success',
            $sudahDibatalkan ? 'Transaksi ini sudah pernah dibatalkan.' : 'Transaksi berhasil dibatalkan dan riwayatnya tetap tersimpan.'
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'id_pelanggan' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required',
        ]);

        Penjualan::create($request->all());

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan created successfully.');
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
            'id_pelanggan' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required',
        ]);

        $penjualan = Penjualan::find($id);
        $penjualan->update($request->all());

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
