 <!-- Sidebar Menu -->
 <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Menu Utama
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('barang.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Barang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('kategori.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kategori</p>
                </a>
              </li>
              </li>
              <li class="nav-item">
                <a href="{{route ('gudang.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Gudang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('pelanggan.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pelanggan</p>
                </a>
              </li>

                              <li class="nav-item">
                                <a href="{{ route('penjualan.cancellation.index') }}" class="nav-link {{ request()->routeIs('penjualan.cancellation.*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembatalan Transaksi</p>
                </a>
              </li>
                <li class="nav-item">
                  <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan</p>
                </a>
              </li>
            </ul>
          </li>

{{-- MENU TRANSAKSI --}}
<li class="nav-item has-treeview
    {{ request()->routeIs('barang_keluar.*', 'barang_masuk.*', 'transfer.*') ? 'menu-open' : '' }}">

    <a href="#"
       class="nav-link
       {{ request()->routeIs('barang_keluar.*', 'barang_masuk.*', 'transfer.*') ? 'active' : '' }}">

        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            Transaksi
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        {{-- Penjualan --}}
        <li class="nav-item">
            <a href="{{ route('penjualan.index') }}"
               class="nav-link {{ request()->routeIs('barang_keluar.*') ? 'active' : '' }}">

                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Penjualan</p>
            </a>
        </li>

        {{-- Barang Masuk --}}
        <li class="nav-item">
            <a href="{{ route('barang_masuk.index') }}"
               class="nav-link {{ request()->routeIs('barang_masuk.*') ? 'active' : '' }}">

                <i class="fas fa-truck-loading nav-icon"></i>
                <p>Barang Masuk</p>
            </a>
        </li>

        {{-- Transfer Gudang --}}
        <li class="nav-item">
            <a href="{{ route('transfer.index') }}"
               class="nav-link {{ request()->routeIs('transfer.*') ? 'active' : '' }}">

                <i class="fas fa-warehouse nav-icon"></i>
                <p>Transfer Antar Gudang</p>
            </a>
        </li>

    </ul>
</li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('actionLogout')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logout</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
