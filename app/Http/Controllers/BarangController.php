<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        return view('home.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $kategoris = Kategori::all();

        return view('home.barang.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'satuan' => 'required',
            'harga_pokok' => 'required',
            'harga_jual' => 'required',
            'status_aktif' => 'required',
        ]);

        Barang::create($request->all());

        return redirect()->route('home.barang.index')
            ->with('success', 'Barang created successfully.');
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
            'sku' => 'required',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'satuan' => 'required',
            'harga_pokok' => 'required',
            'harga_jual' => 'required',
            'status_aktif' => 'required',
        ]);

        $barang = Barang::find($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Barang updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang deleted successfully.');
    }

}
