<div>
    <div class="card d-flex flex-fill">

        
        <div class="card-header text-muted border-bottom-0">
          {{ $users->job }}
        </div>
        <div class="card-body pt-0">
          <div class="row">
            <div class="col-7">
              <h2 class="lead"><b>{{ $users->name }}</b></h2>
              <p class="text-muted text-sm"><b>About: </b> {{ $users->about }} </p>
              <ul class="ml-4 mb-0 fa-ul text-muted">
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{ $users->addres }}</li>
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #:{{ $users->phone }}</li>
              </ul>
            </div>
            <div class="col-5 text-center">
              <img src="{{ $users->profil ? asset('storage/' . $users->profil) : asset('asset/dist/img/user1-128x128.jpg') }}" alt="user-avatar" class="img-circle img-fluid">

              {{-- <img src="{{ Auth::user()->profil ? asset('storage/' . Auth::user()->profil) : asset('asset/dist/img/user1-128x128.jpg') }}" class="img-thumbnail mt-2" width="100"> --}}
            </div>
          </div>
        </div>


        <div class="card-footer">
          <div class="text-right">
            <a href="#" class="btn btn-sm bg-teal">
              <i class="fas fa-comments"></i>
            </a>
            <a href="#" class="btn btn-sm btn-primary">
              <i class="fas fa-user"></i> View Profile
            </a>
          </div>
        </div>
      </div>
</div>
