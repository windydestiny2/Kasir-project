<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('asset/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sugoiiyaki</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      
        @livewire('profil.SidebarProfil')
      
      

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="{{ route('dashboard') }}" class="nav-link {{ (strtolower($title) === "dashboard") ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            
          </li>

          @php
              $users = Auth::user();
          @endphp

          <li class="nav-header">PAGES</li>
          
          @if($users->admin == true)
          <li class="nav-item">
            <a href="{{ route('view.user') }}" class="nav-link {{ ($title === "ViewAdmin") ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Admin
              </p>
            </a>
          </li>
          @else
            
          @endif
          
          @if($users->product == 1)
          <li class="nav-item">
            <a href="{{ route('view.product') }}" class="nav-link {{ ($title === "Product") ? 'active' : '' }}">
              <i class="nav-icon fas fa-box-open"></i>
              <p>
                Product
              </p>
            </a>
          </li>
          @endif

          @if($users->product == 1)
          <li class="nav-item">
            <a href="{{ route('view.toping') }}" class="nav-link {{ ($title === "Toping") ? 'active' : '' }}">
              <i class="nav-icon fas fa-cheese"></i>
              <p>
                Toping
              </p>
            </a>
          </li>
          @endif

          @if($users->product == 1)
          <li class="nav-item">
            <a href="{{ route('view.Ukuran') }}" class="nav-link {{ ($title === "Ukuran") ? 'active' : '' }}">
              <i class="nav-icon fas fa-ruler"></i>
              <p>
                Ukuran Toping
              </p>
            </a>
          </li>
          @endif

          @if($users->kategori = 1)
          <li class="nav-item">
            <a href="{{ route('view.kategori') }}" class="nav-link {{ ($title === "ViewKategori") ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Kategori
              </p>
            </a>
          </li>
            
          @endif

          @if($users->orderpes == 1)
            
          <li class="nav-item">
            <a href="{{ route('view.order') }}" class="nav-link {{ ($title === "Order Pesanan") ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Order Pesanan
              </p>
            </a>
          </li>
            
          @endif

          @if($users->riwayat == 1)
          <li class="nav-item">
            <a href="{{ route('view.report') }}" class="nav-link {{ ($title === "viewReport") ? 'active' : '' }}">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Riwayat & Laporan
              </p>
            </a>
          </li>
          @endif


          @if($users->pengeluaran == 1)
          <li class="nav-item">
            <a href="{{ route('view.pengeluaran') }}" class="nav-link {{ ($title === "viewPengeluaran") ? 'active' : '' }}">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Pengeluaran
              </p>
            </a>
          </li>
          @endif

          @if($users->admin == true)
          <li class="nav-item">
            <a href="{{ route('ml.dashboard') }}" class="nav-link {{ ($title === "ML Dashboard") ? 'active' : '' }}">
              <i class="nav-icon fas fa-brain"></i>
              <p>
                ML Dashboard
              </p>
            </a>
          </li>
          @endif

          
        

          
          

          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>