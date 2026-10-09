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
                <h3>Tabel Pelanggan
                    <a class="btn btn-primary" href="{{ route('pelanggan.create') }}">
                      <i class= "fas fa-plus"></i>Tambah Data Pelanggan</a>
                </h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>No hp</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $p)
                            <tr>
                                <td>{{ $p->nama_pelanggan }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td>{{ $p->alamat }}</td>
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
