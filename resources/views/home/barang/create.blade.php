@extends('layouts.master')

@section('content')
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h3>Tambah Barang</h3>
				<a href="{{ route('barang.index') }}" class="btn btn-secondary">
					<i class="fas fa-arrow-left"></i> Kembali
				</a>
			</div>

			@if ($kategoris->isEmpty())
				<div class="alert alert-warning">Belum ada kategori. Tambahkan kategori terlebih dahulu sebelum menyimpan barang.</div>
			@endif

			<div class="card">
				<form action="{{ route('barang.store') }}" method="POST">
					@csrf
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="sku">SKU</label>
								<input type="text" id="sku" name="sku" value="{{ old('sku') }}"
									   class="form-control @error('sku') is-invalid @enderror" required maxlength="255">
								@error('sku')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="nama_barang">Nama Barang</label>
								<input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
									   class="form-control @error('nama_barang') is-invalid @enderror" required maxlength="255">
								@error('nama_barang')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="id_kategori">Kategori</label>
								<select id="id_kategori" name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror" required>
									<option value="">Pilih kategori</option>
									@foreach ($kategoris as $kategori)
										<option value="{{ $kategori->id }}" @selected(old('id_kategori') == $kategori->id)>
											{{ $kategori->nama_kategori }}
										</option>
									@endforeach
								</select>
								@error('id_kategori')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="satuan">Satuan</label>
								<input type="text" id="satuan" name="satuan" value="{{ old('satuan') }}"
									   class="form-control @error('satuan') is-invalid @enderror" required maxlength="255"
									   placeholder="Contoh: pcs, dus, 10 Kg">
								@error('satuan')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="harga_pokok">Harga Pokok (Rp)</label>
								<input type="number" id="harga_pokok" name="harga_pokok" value="{{ old('harga_pokok') }}"
									   class="form-control @error('harga_pokok') is-invalid @enderror" required min="0" step="1">
								@error('harga_pokok')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group col-md-4">
								<label for="harga_jual">Harga Jual (Rp)</label>
								<input type="number" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}"
									   class="form-control @error('harga_jual') is-invalid @enderror" required min="0" step="1">
								@error('harga_jual')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group col-md-4">
								<label for="status_aktif">Status</label>
								<select id="status_aktif" name="status_aktif" class="form-control @error('status_aktif') is-invalid @enderror" required>
									<option value="Tersedia" @selected(old('status_aktif', 'Tersedia') === 'Tersedia')>Tersedia</option>
									<option value="Tidak Tersedia" @selected(old('status_aktif') === 'Tidak Tersedia')>Tidak Tersedia</option>
								</select>
								@error('status_aktif')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="card-footer">
						<button type="submit" class="btn btn-primary" @disabled($kategoris->isEmpty())>
							<i class="fas fa-save"></i> Simpan Barang
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection
