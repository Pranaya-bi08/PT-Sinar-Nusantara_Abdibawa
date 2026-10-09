@extends('layouts.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="row">
          <div class="col-lg-12">
             <div class="card">
              <div class="card-header">
                @if (session('success'))
                  <div class="alert alert-success">
                      {{session('success')}}
                  </div>
                  @endif
                <h3>Tabel Barang
                    <a class="btn btn-primary" href="{{ route('barang.create') }}">
                      <i class= "fas fa-plus"></i>Tambah Data Barang</a>
                </h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga Pokok</th>
                            <th>Harga Jual</th>
                            <th>Status Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $b)
                            <tr>
                                <td>{{ $b->sku }}</td>
                                <td>{{ $b->nama_barang }}</td>
                                <td>{{ $b->kategori->nama_kategori }}</td>
                                <td>{{ $b->satuan }}</td>
                                <td>{{ $b->harga_jual }}</td>
                                <td>{{ $b->harga_pokok }}</td>
                                <td>{{ $b->status_aktif }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
             </div>
          </div>
        </section>
        </div>

@endsection
