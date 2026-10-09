@extends('layouts.master')

@section('content')
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<h3 class="mb-3">Pembatalan Transaksi</h3>

			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			@if (session('warning'))
				<div class="alert alert-warning">{{ session('warning') }}</div>
			@endif

			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Transaksi Aktif</h4>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tanggal</th>
								<th>Barang</th>
								<th>Pelanggan</th>
								<th>Jumlah</th>
								<th>Total</th>
								<th>Pembatalan</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($transaksiAktif as $item)
								<tr>
									<td>{{ $transaksiAktif->firstItem() + $loop->index }}</td>
									<td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->barang->nama_barang ?? '-' }}</td>
									<td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
									<td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
									<td>Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
									<td>
										<form action="{{ route('penjualan.cancel', $item) }}" method="POST"
											  onsubmit="return confirm('Batalkan transaksi ini? Riwayatnya akan tetap disimpan.')">
											@csrf
											<input type="text" name="alasan_pembatalan" maxlength="1000" required
												   class="form-control form-control-sm mb-2 @error('alasan_pembatalan') is-invalid @enderror"
												   placeholder="Masukkan alasan">
											@error('alasan_pembatalan')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
											<button type="submit" class="btn btn-sm btn-danger">
												<i class="fas fa-ban"></i> Batalkan
											</button>
										</form>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center">Tidak ada transaksi aktif untuk dibatalkan.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
					{{ $transaksiAktif->links() }}
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Riwayat Pembatalan</h4>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tanggal Transaksi</th>
								<th>Barang</th>
								<th>Pelanggan</th>
								<th>Jumlah</th>
								<th>Total</th>
								<th>Dibatalkan Pada</th>
								<th>Alasan</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($riwayatPembatalan as $item)
								<tr>
									<td>{{ $riwayatPembatalan->firstItem() + $loop->index }}</td>
									<td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->barang->nama_barang ?? '-' }}</td>
									<td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
									<td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
									<td>Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
									<td>{{ $item->dibatalkan_pada?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->alasan_pembatalan }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="8" class="text-center">Belum ada riwayat pembatalan.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
					{{ $riwayatPembatalan->links() }}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
