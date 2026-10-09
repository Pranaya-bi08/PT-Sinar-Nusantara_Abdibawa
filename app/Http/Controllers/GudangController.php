<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gudang = Gudang::all();
        return view('home.gudang.index', compact('gudang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $returnToTransfer = $request->query('return') === 'transfer';

        return view('home.gudang.create', compact('returnToTransfer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gudang' => 'required|string|max:50|unique:gudangs,kode_gudang',
            'nama_gudang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'return_to' => 'nullable|in:transfer',
        ]);

        $returnToTransfer = ($validated['return_to'] ?? null) === 'transfer';
        unset($validated['return_to']);
        Gudang::create($validated);

        if ($returnToTransfer) {
            return redirect()->route('transfer.create')
                ->with('success', 'Gudang berhasil ditambahkan. Sekarang pilih gudang tersebut sebagai tujuan transfer.');
        }

        return redirect()->route('gudang.index')
            ->with('success', 'Gudang berhasil ditambahkan.');
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
            'kode_gudang' => 'required',
            'nama_gudang' => 'required',
            'lokasi' => 'required',
        ]);

        $gudang = Gudang::findOrFail($id);
        $gudang->update($request->all());

        return redirect()->route('home.gudang.index')
            ->with('success', 'Gudang updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
