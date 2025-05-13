@extends('Backend.main-master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Profil</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Profil</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
          <div class="card-body pb-0">
            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                  @livewire('profil.CardProfil')
              </div>
          
              <div class="col-12 col-md-8">
                  @livewire('profil.EditProfil')
              </div>
          </div>
          </div>

      </div>
    </section>
    <!-- /.content -->
  </div>

  <script>
    document.getElementById('profile').addEventListener('change', function(e) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewImage').setAttribute('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    });
  </script>

@endsection