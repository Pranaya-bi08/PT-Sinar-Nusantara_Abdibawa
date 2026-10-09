@extends('layouts.master')

@section('content')
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h3>Transaksi Barang Masuk</h3>
			</div>

			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif

			<div class="card">
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tanggal Masuk</th>
								<th>SKU</th>
								<th>Nama Barang</th>
								<th>Gudang</th>
								<th>Jumlah</th>
								<th>Total Harga</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($transaksi as $item)
								<tr>
									<td>{{ $transaksi->firstItem() + $loop->index }}</td>
									<td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->barang->sku ?? '-' }}</td>
									<td>{{ $item->barang->nama_barang ?? '-' }}</td>
									<td>{{ $item->gudang->nama_gudang ?? '-' }}</td>
									<td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
									<td>Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center">Belum ada transaksi barang masuk.</td>
								</tr>
							@endforelse
						</tbody>
					</table>

					{{ $transaksi->links() }}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
