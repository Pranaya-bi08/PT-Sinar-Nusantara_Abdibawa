<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiBarangMasuk;

class TransaksiBarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = TransaksiBarangMasuk::with(['barang', 'gudang'])
            ->latest()
            ->paginate(10);

        return view('transaksi.transaksi_barang_masuk.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi_barang_masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'jumlah' => 'required',
            'tanggal_masuk' => 'required',
        ]);

        TransaksiBarangMasuk::create($request->all());

        return redirect()->route('barang_masuk.index')
            ->with('success', 'Transaksi Barang Masuk created successfully.');
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
            'jumlah' => 'required',
            'tanggal_masuk' => 'required',
        ]);

        $transaksi = TransaksiBarangMasuk::findOrFail($id);
        $transaksi->update($request->all());

        return redirect()->route('barang_masuk.index')
            ->with('success', 'Transaksi Barang Masuk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
