@extends('layouts.master')

@section('content')
<div class="content-wrapper">
	<section class="content pt-3">
		<div class="container-fluid">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h3>Tambah Gudang</h3>
				<a href="{{ $returnToTransfer ? route('transfer.create') : route('gudang.index') }}" class="btn btn-secondary">
					<i class="fas fa-arrow-left"></i> Kembali
				</a>
			</div>

			<div class="card">
				<form action="{{ route('gudang.store') }}" method="POST">
					@csrf
					@if ($returnToTransfer)
						<input type="hidden" name="return_to" value="transfer">
					@endif

					<div class="card-body">
						<div class="form-group">
							<label for="kode_gudang">Kode Gudang</label>
							<input type="text" id="kode_gudang" name="kode_gudang" value="{{ old('kode_gudang') }}"
								   class="form-control @error('kode_gudang') is-invalid @enderror" required maxlength="50">
							@error('kode_gudang')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="nama_gudang">Nama Gudang</label>
							<input type="text" id="nama_gudang" name="nama_gudang" value="{{ old('nama_gudang') }}"
								   class="form-control @error('nama_gudang') is-invalid @enderror" required maxlength="255">
							@error('nama_gudang')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="lokasi">Lokasi (opsional)</label>
							<input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
								   class="form-control @error('lokasi') is-invalid @enderror" maxlength="255">
							@error('lokasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="card-footer">
						<button type="submit" class="btn btn-primary">
							<i class="fas fa-save"></i> Simpan Gudang
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection
