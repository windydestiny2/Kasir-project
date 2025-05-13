@extends('Backend.main-master')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Order Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Order</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>

          <section class="content">
            <div class="container-fluid">
                @livewire('Order.order-pesanan')

                {{-- @livewire('Order.menu-order-table') --}}
            </div>
          </section>
    </div>

@endsection