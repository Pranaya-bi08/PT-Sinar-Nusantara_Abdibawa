@extends('layouts.master')

@section('content')
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h3>Transfer Barang Antar Gudang</h3>
				<a href="{{ route('transfer.create') }}" class="btn btn-primary">
					<i class="fas fa-plus"></i> Transfer Baru
				</a>
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
								<th>Tanggal</th>
								<th>SKU</th>
								<th>Nama Barang</th>
								<th>Gudang Asal</th>
								<th>Gudang Tujuan</th>
								<th>Jumlah</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($transferBarang as $item)
								<tr>
									<td>{{ $transferBarang->firstItem() + $loop->index }}</td>
									<td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->barang->sku ?? '-' }}</td>
									<td>{{ $item->barang->nama_barang ?? '-' }}</td>
									<td>{{ $item->gudangAsal->nama_gudang ?? '-' }}</td>
									<td>{{ $item->gudangTujuan->nama_gudang ?? '-' }}</td>
									<td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center">Belum ada transaksi transfer barang.</td>
								</tr>
							@endforelse
						</tbody>
					</table>

					{{ $transferBarang->links() }}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
