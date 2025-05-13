<div>
    <div class="card">
        <div class="card-body">
            <div class="box-body">
                <div class="row">
                    <div class="col">
                        <form action="" wire:submit.prevent='editUser' enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama <span class="text-danger">*</span></label>
                                                <input type="text" wire:model='name' class="form-control @error('name')
                                                        is-invalid
                                                    @enderror" id="name" placeholder="Masukan Nama Admin">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email<span class="text-danger">*</span></label>
                                                <input type="email" wire:model='email' class="form-control @error('email')
                                                is-invalid
                                                @enderror" id="email" placeholder="Masukan email admin">
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="kategori">Jabatan<span class="text-danger">*</span></label>
                                            <select  wire:model='job' class="form-select form-control @error('job')
                                            is-invalid
                                            @enderror" aria-label="Default select example">
                                                <option selected>Pilih Jabatan</option>
                                                <option value="admin">Admin</option>
                                                <option value="kasir">Kasir</option>
                                            </select>

                                            @error('job')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Telepon</label>
                                                <input type="number" wire:model='phone' class="form-control" id="phone" placeholder="Masukan Nomor Telepon ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="addres">Alamat</label>
                                                <textarea class="form-control" id="addres" placeholder="Alamat" wire:model="addres"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tentang">Tentang</label>
                                                    <textarea class="form-control" id="tentang" placeholder="Alamat" wire:model="about"></textarea>
                                            </div>
                                        </div>                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Foto Profile <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="file" wire:model='profil' class="form-control"
                                                        value="" id="image">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            @if($profil)
                                            <img src="{{ $profil->temporaryUrl() }}" class="img-fluid" width="150" alt="">
                                            @elseif($old_image)
                                            <img src="{{ asset('storage/' . $old_image) }}" class="img-fluid" width="150" alt="">
                                        @endif
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <div class="controls">

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary1"
                                                                wire:model="dashboard" {{ $user->dashboard == 1 ? 'checked' : '' }}>
                                                            <label for="checkboxPrimary1">
                                                                Dashboard
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary2" wire:model="admin"
                                                                 {{ $user->admin == 1 ? 'checked' : '' }}>
                                                            <label for="checkboxPrimary2">
                                                                Admin
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary3" wire:model="product"
                                                                 {{ $user->product == 1 ? 'checked' : '' }}>
                                                            <label for="checkboxPrimary3">
                                                                Product
                                                            </label>
                                                        </div>
                                                    </fieldset>



                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary4" wire:model="kategori"
                                                                 {{ $user->kategori == 1 ? 'checked' : '' }}>
                                                            <label for="checkboxPrimary4">
                                                                Kategori
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary5" wire:model="orderpes"
                                                                 {{ $user->orderpes == 1 ? 'checked' : '' }}>
                                                            <label for="checkboxPrimary5">
                                                                Order Pesanan
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="checkboxPrimary6" wire:model="riwayat"
                                                                 {{ $user->riwayat == 1 ? 'checked' : ''}}>
                                                            <label for="checkboxPrimary6">
                                                                Riwayat & Laporan
                                                            </label>
                                                        </div>
                                                    </fieldset>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <div class="controls">

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pengeluaran" wire:model="pengeluaran"
                                                                 {{ $user->pengeluaran == 1 ? 'checked' : '' }}>
                                                            <label for="pengeluaran">
                                                                Pengeluaran
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="toping" wire:model="toping"
                                                                 {{ $user->toping == 1 ? 'checked' : '' }}>
                                                            <label for="toping">
                                                                Toping
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="py-2">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ukuran" wire:model="ukuran"
                                                                 {{ $user->ukuran == 1 ? 'checked' : '' }}>
                                                            <label for="ukuran">
                                                                Ukuran
                                                            </label>
                                                        </div>
                                                    </fieldset>

                                                    


                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="text-xs-right">
                                        <button class="btn btn-success w-100">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
