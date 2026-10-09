@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Tambah Pelanggan</h3>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card">
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_pelanggan">Nama Pelanggan</label>
                            <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                                   value="{{ old('nama_pelanggan') }}"
                                   class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                   maxlength="255" required>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   maxlength="255" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      maxlength="255" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection