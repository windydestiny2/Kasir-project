<div>
  <div class="card">
    <div class="card-header p-2">
      <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#profilForm" data-toggle="tab">Update Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="#passwordForm" data-toggle="tab">Update Password</a></li>
        
      </ul>
    </div><!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" id="profilForm">
          <form wire:submit.prevent='updateProfile' class="form-horizontal">
            <div class="form-group row">
              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="Name" wire:model='name'>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail" placeholder="Email" wire:model='email'>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="phone" placeholder="Telepon" wire:model='phone'>
              </div>
            </div>
      
            

            <div class="form-group row">
              <label for="inputExperience" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="inputExperience" placeholder="Alamat" wire:model='addres'></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputExperience" class="col-sm-2 col-form-label">Tentang</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="inputExperience" placeholder="Tentang" wire:model='about'></textarea>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="profile" class="col-sm-2 col-form-label">Profil</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" id="profile" placeholder="" wire:model='profil'>
              </div>
      
              <div class="col-5 py-3">
                @if ($profil)
                <img src="{{ $profil->temporaryUrl() }}" class="img-thumbnail mt-2" width="100">
                @else
                <img
                  src="{{ Auth::user()->profil ? asset('storage/' . Auth::user()->profil) : asset('asset/dist/img/user1-128x128.jpg') }}"
                  class="img-thumbnail mt-2" width="100">
                @endif
      
              </div>
            </div>
      
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-success w-100">Update</button>
              </div>
            </div>
          </form>
        </div>
      
        <div class="tab-pane" id="passwordForm">
          <form wire:submit.prevent='updatePassword' class="form-horizontal">
            <div class="form-group row">
              <label for="inputName" class="col-sm-2 col-form-label">Password Lama <span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <input type="password" class="form-control @error('old_password')
                  'is-invalid'
                @enderror" id="inputName" placeholder="Password Lama" wire:model='old_password'>
                @error('old_password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail" class="col-sm-2 col-form-label">Password Baru<span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <input type="password" class="form-control @error('password')
                  is-invalid
                @enderror" id="inputEmail" placeholder="Password" wire:model='password'>
                @error('password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
      
            <div class="form-group row">
              <label for="phone" class="col-sm-2 col-form-label">Konfirmasi Password<span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <input type="password" class="form-control @error('password_confirmation')
                  'is-invalid'
                @enderror" id="phone" placeholder="Konfirmasi Password" wire:model='password_confirmation'>
                @error('password_confirmation')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
      
            
      
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-success w-100">Update</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div><!-- /.card-body -->
  </div>
  


</div>