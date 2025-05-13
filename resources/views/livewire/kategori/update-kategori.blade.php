<div>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Kategori</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                
                <form wire:submit.prevent='EditKategori'>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="kategori">Jenis Kategori</label>
                                <input type="text" wire:model='kategori' class="form-control @error('kategori')
                                is-invalid
                                @enderror" id="kategori"
                                    placeholder="Masukan Nama Kategori">
                                    @error('kategori')    
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-primary w-100">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->


            <!-- /.card -->

        </div>

        


    </div>
</div>
