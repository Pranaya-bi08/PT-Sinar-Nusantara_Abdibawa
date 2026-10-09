@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Transaksi Penjualan</h3>
            </div>

            <form method="GET" action="{{ route('penjualan.index') }}" class="card card-body mb-3">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="q" class="form-control"
                               value="{{ request('q') }}"
                               placeholder="Cari SKU, nama barang, pelanggan...">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="tanggal_dari" class="form-control"
                               value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="tanggal_sampai" class="form-control"
                               value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button class="btn btn-info w-100">Filter</button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>SKU</th>
                                <th>Nama Barang</th>
                                <th>Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualan as $item)
                                <tr>
                                    <td>{{ $penjualan->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ $item->barang->sku ?? '-' }}</td>
                                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Belum ada transaksi penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $penjualan->links() }}
                </div>
            </div>
        </div>
    </section>
    </div>
</div>
@endsection