@extends('layouts.master')

@section('content')
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<h3 class="mb-3">Laporan Persediaan dan Transaksi</h3>

			<form method="GET" action="{{ route('laporan.index') }}" class="card card-body mb-3">
				<div class="form-row align-items-end">
					<div class="form-group col-md-2 mb-2">
						<label for="tanggal_dari">Tanggal Dari</label>
						<input type="date" id="tanggal_dari" name="tanggal_dari" class="form-control" value="{{ $tanggalDari }}">
					</div>
					<div class="form-group col-md-2 mb-2">
						<label for="tanggal_sampai">Tanggal Sampai</label>
						<input type="date" id="tanggal_sampai" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
					</div>
					<div class="form-group col-md-3 mb-2">
						<label for="gudang_id">Gudang</label>
						<select id="gudang_id" name="gudang_id" class="form-control">
							<option value="">Semua gudang</option>
							@foreach ($gudang as $itemGudang)
								<option value="{{ $itemGudang->id }}" @selected(request('gudang_id') == $itemGudang->id)>
									{{ $itemGudang->nama_gudang }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-3 mb-2">
						<label for="barang_id">Barang</label>
						<select id="barang_id" name="barang_id" class="form-control">
							<option value="">Semua barang</option>
							@foreach ($pilihanBarang as $itemBarang)
								<option value="{{ $itemBarang->id }}" @selected(request('barang_id') == $itemBarang->id)>
									{{ $itemBarang->sku }} - {{ $itemBarang->nama_barang }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-2 mb-2 d-flex">
						<button type="submit" class="btn btn-primary mr-2">
							<i class="fas fa-filter"></i> Filter
						</button>
						<a href="{{ route('laporan.index') }}" class="btn btn-secondary">Reset</a>
					</div>
				</div>
			</form>

			<div class="alert alert-info">
				Stok awal dihitung sebelum tanggal mulai dan stok akhir sampai tanggal selesai (atau hari ini). Laporan penjualan hanya mencakup transaksi aktif; filter gudang tidak berlaku pada penjualan karena transaksinya belum menyimpan gudang.
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="small-box bg-info">
						<div class="inner">
							<h3>{{ number_format($laporanStok->count(), 0, ',', '.') }}</h3>
							<p>Jenis Barang</p>
						</div>
						<div class="icon"><i class="fas fa-boxes"></i></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="small-box bg-success">
						<div class="inner">
							<h3>{{ number_format($totalStokAkhir, 0, ',', '.') }}</h3>
							<p>Stok Akhir</p>
						</div>
						<div class="icon"><i class="fas fa-cubes"></i></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3 class="text-nowrap">Rp {{ number_format($totalBarangMasuk, 0, ',', '.') }}</h3>
							<p>Total Barang Masuk</p>
						</div>
						<div class="icon"><i class="fas fa-truck-loading"></i></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="small-box bg-primary">
						<div class="inner">
							<h3 class="text-nowrap">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
							<p>Total Penjualan</p>
						</div>
						<div class="icon"><i class="fas fa-cash-register"></i></div>
					</div>
				</div>
			</div>

			<div class="card" id="laporan-stok">
				<div class="card-header"><h4 class="card-title">Laporan Stok Barang</h4></div>
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>SKU</th>
								<th>Nama Barang</th>
								<th>Kategori</th>
								<th>Satuan</th>
								@foreach ($gudangLaporan as $itemGudang)
									<th>{{ $itemGudang->nama_gudang }}: Awal</th>
									<th>{{ $itemGudang->nama_gudang }}: Akhir</th>
								@endforeach
								<th>Total Awal</th>
								<th>Total Akhir</th>
								<th>Nilai Stok Akhir</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($laporanStok as $baris)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $baris['barang']->sku }}</td>
									<td>{{ $baris['barang']->nama_barang }}</td>
									<td>{{ $baris['barang']->kategori->nama_kategori ?? '-' }}</td>
									<td>{{ $baris['barang']->satuan }}</td>
									@foreach ($gudangLaporan as $itemGudang)
										<td>{{ $tanggalDari ? number_format($baris['stok_awal_per_gudang'][$itemGudang->id] ?? 0, 0, ',', '.') : '-' }}</td>
										<td>{{ number_format($baris['stok_akhir_per_gudang'][$itemGudang->id] ?? 0, 0, ',', '.') }}</td>
									@endforeach
									<td>{{ $tanggalDari ? number_format($baris['total_stok_awal'], 0, ',', '.') : '-' }}</td>
									<td><strong>{{ number_format($baris['total_stok_akhir'], 0, ',', '.') }}</strong></td>
									<td>Rp {{ number_format($baris['nilai_stok'], 0, ',', '.') }}</td>
								</tr>
							@empty
								<tr><td colspan="{{ 8 + (2 * $gudangLaporan->count()) }}" class="text-center">Tidak ada barang yang sesuai filter.</td></tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>

			<div class="card" id="barang-masuk">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title">Laporan Barang Masuk</h4>
					<strong>Total: Rp {{ number_format($totalBarangMasuk, 0, ',', '.') }}</strong>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th><th>Tanggal</th><th>SKU</th><th>Nama Barang</th>
								<th>Gudang</th><th>Jumlah</th><th>Total Harga</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($laporanBarangMasuk as $item)
								<tr>
									<td>{{ $laporanBarangMasuk->firstItem() + $loop->index }}</td>
									<td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->barang->sku ?? '-' }}</td>
									<td>{{ $item->barang->nama_barang ?? '-' }}</td>
									<td>{{ $item->gudang->nama_gudang ?? '-' }}</td>
									<td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
									<td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
								</tr>
							@empty
								<tr><td colspan="7" class="text-center">Tidak ada transaksi barang masuk pada periode ini.</td></tr>
							@endforelse
						</tbody>
					</table>
					{{ $laporanBarangMasuk->links() }}
				</div>
			</div>

			<div class="card" id="laporan-penjualan">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title">Laporan Penjualan</h4>
					<strong>Total: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th><th>Tanggal</th><th>SKU</th><th>Nama Barang</th>
								<th>Pelanggan</th><th>Jumlah</th><th>Total Harga</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($laporanPenjualan as $item)
								<tr>
									<td>{{ $laporanPenjualan->firstItem() + $loop->index }}</td>
									<td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
									<td>{{ $item->barang->sku ?? '-' }}</td>
									<td>{{ $item->barang->nama_barang ?? '-' }}</td>
									<td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
									<td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
									<td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
								</tr>
							@empty
								<tr><td colspan="7" class="text-center">Tidak ada transaksi penjualan aktif pada periode ini.</td></tr>
							@endforelse
						</tbody>
					</table>
					{{ $laporanPenjualan->links() }}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
