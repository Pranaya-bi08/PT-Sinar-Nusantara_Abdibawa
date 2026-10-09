@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Transfer Barang Antar Gudang</h3>
                <div>
                    <a href="{{ route('gudang.create', ['return' => 'transfer']) }}" class="btn btn-outline-primary mr-2">
                        <i class="fas fa-plus"></i> Tambah Gudang
                    </a>
                    <a href="{{ route('transfer.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($gudang->count() < 2)
                <div class="alert alert-warning">Saat ini baru ada satu gudang. Tambahkan gudang lain agar bisa dipilih sebagai tujuan.</div>
            @endif

            <div class="card">
                <form action="{{ route('transfer.store') }}" method="POST" id="transfer-form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id_barang">Barang</label>
                            <select name="id_barang" id="id_barang" class="form-control @error('id_barang') is-invalid @enderror" required>
                                <option value="">Pilih barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}" @selected(old('id_barang') == $item->id)>
                                        {{ $item->sku }} - {{ $item->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="id_gudang_asal">Gudang Asal</label>
                                <select name="id_gudang_asal" id="id_gudang_asal" class="form-control @error('id_gudang_asal') is-invalid @enderror" required>
                                    <option value="">Pilih gudang asal</option>
                                    @foreach ($gudang as $lokasi)
                                        <option value="{{ $lokasi->id }}" @selected(old('id_gudang_asal') == $lokasi->id)>
                                            {{ $lokasi->nama_gudang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_gudang_asal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Stok tersedia: <strong id="stok-tersedia">-</strong></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="id_gudang_tujuan">Gudang Tujuan</label>
                                <select name="id_gudang_tujuan" id="id_gudang_tujuan" class="form-control @error('id_gudang_tujuan') is-invalid @enderror" required>
                                    <option value="">Pilih gudang tujuan</option>
                                    @foreach ($gudang as $lokasi)
                                        <option value="{{ $lokasi->id }}" @selected(old('id_gudang_tujuan') == $lokasi->id)>
                                            {{ $lokasi->nama_gudang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_gudang_tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah Transfer</label>
                            <input type="number" name="jumlah" id="jumlah" min="1" step="1" value="{{ old('jumlah') }}"
                                   class="form-control @error('jumlah') is-invalid @enderror" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="submit-transfer" disabled>
                            <i class="fas fa-exchange-alt"></i> Simpan Transfer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    const stockBalances = @json($stockBalances);
    const itemSelect = document.getElementById('id_barang');
    const sourceSelect = document.getElementById('id_gudang_asal');
    const destinationSelect = document.getElementById('id_gudang_tujuan');
    const quantityInput = document.getElementById('jumlah');
    const availableStock = document.getElementById('stok-tersedia');
    const submitButton = document.getElementById('submit-transfer');

    function updateTransferForm() {
        const stockKey = `${itemSelect.value}:${sourceSelect.value}`;
        const available = Number(stockBalances[stockKey] || 0);

        availableStock.textContent = itemSelect.value && sourceSelect.value
            ? available.toLocaleString('id-ID')
            : '-';
        quantityInput.max = available;

        Array.from(destinationSelect.options).forEach((option) => {
            option.disabled = option.value !== '' && option.value === sourceSelect.value;
        });

        if (destinationSelect.value === sourceSelect.value) {
            destinationSelect.value = '';
        }

        const hasSelection = itemSelect.value && sourceSelect.value && destinationSelect.value;
        submitButton.disabled = !hasSelection || available < 1 || Number(quantityInput.value) > available;
    }

    itemSelect.addEventListener('change', updateTransferForm);
    sourceSelect.addEventListener('change', updateTransferForm);
    destinationSelect.addEventListener('change', updateTransferForm);
    quantityInput.addEventListener('input', updateTransferForm);
    updateTransferForm();
</script>
@endsection