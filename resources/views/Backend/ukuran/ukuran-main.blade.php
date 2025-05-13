@extends('Backend.main-master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ukuran Toping</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Ukuran Toping</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        @livewire('ukuran.TambahUkuran')
        {{-- <div class="row">
          <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                  <div class="card-header">
                      <h3 class="card-title">Tambah Ukuran</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  
                  
                  <form method="POST" action="{{ route('tambah.ukuran') }}" enctype="multipart/form-data">
                    @csrf
                      <div class="card-body">
                          <div class="row">
                              <div class="form-group col-md-6">
                                  <label>Pilih Produk</label>
                                  <select name="product_id" class="form-control">
                                      <option value="">Pilih Produk</option>
                                      @foreach ($product as $item)
                                          <option value="{{ $item->id }}">{{ $item->nm_produk }}</option>
                                      @endforeach
                                  </select>
                              </div>
                  
                              <div class="form-group col-md-6">
                                  <label>Pilih Toping</label>
                                  <select name="toping_id" class="form-control">
                                      <option value="">Pilih Toping</option>
                                      <option value="" selected="" disabled="">Pilih Toping</option>
                                  </select>
                              </div>
                          </div>
                  
                          <div class="row mt-3">
                              <div class="form-group col-md-6">
                                  <label>Nama Ukuran</label>
                                  <input type="text" wire:model="nama" name="nama" class="form-control" placeholder="Nama Ukuran">
                              </div>
                  
                              <div class="form-group col-md-6">
                                  <label>Harga</label>
                                  <input type="number" wire:model="harga" name="harga" class="form-control" placeholder="Harga">
                              </div>
                          </div>
                      </div>
                      <div class="card-footer">
                          <button class="btn btn-primary w-100">Tambah</button>
                      </div>
                  </form>
                  
                  
              </div>
              <!-- /.card -->
  
  
              <!-- /.card -->
  
          </div>
  
          
  
  
        </div> --}}

        @livewire('ukuran.Tableukuran')

      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- ajak sub category --}}
<script type="text/javascript">
  $(document).ready(function() {
      $('select[name="product_id"]').on('change', function(){
          var product_id = $(this).val();
          if(product_id) {
              $.ajax({
                  url: "{{ url('/subcategory/ajax') }}/" + product_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data){
                      var d = $('select[name="toping_id"]').empty();
                      $.each(data, function (key, value){
                          $('select[name="toping_id"]').append(
                              '<option value="' + value.id + '">' + value
                                  .name_toping + '</option>'
                                  );
                      });
                  },
              });
          } else {
              alert('danger');
          }
      });
  });
</script>
