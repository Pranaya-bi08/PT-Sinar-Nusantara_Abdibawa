<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Gudang;
use App\Models\TransaksiBarangMasuk;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dashboard = Dashboard::all();
        // return view('dashboard', compact('dashboard'));


        $total_barang = Barang::count();
        $total_gudang = Gudang::count();
        $total_pelanggan = Pelanggan::count();
        $total_penjualan = Penjualan::count();
        $barang_terendah = Barang::orderBy('status_aktif', 'asc')
            ->limit(5)
            ->get();

        $barangMasuk = TransaksiBarangMasuk::with(['barang', 'gudang'])
        ->latest()
        ->limit(5)
        ->get();



        return view('dashboard', compact(
            'total_barang',
            'total_gudang',
            'total_pelanggan',
            'total_penjualan',
            'barang_terendah',
            'barangMasuk'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
