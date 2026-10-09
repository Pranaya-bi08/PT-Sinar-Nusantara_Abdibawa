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
                <h3>Tabel Gudang
                    <a class="btn btn-primary" href="{{ route('gudang.create') }}">
                      <i class= "fas fa-plus"></i>Tambah Data Gudang</a>
                </h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Gudang</th>
                            <th>Nama Gudang</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gudang as $g)
                            <tr>
                                <td>{{ $g->kode_gudang }}</td>
                                <td>{{ $g->nama_gudang }}</td>
                                <td>{{ $g->lokasi }}</td>
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
