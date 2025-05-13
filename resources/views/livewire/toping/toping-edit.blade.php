<div>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Toping</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                
                <form wire:submit.prevent='EditToping'>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="id_product">Product</label>
                                <select class="form-select form-control @error('id_product')
                                    is-invalid
                                    @enderror" wire:model='id_product' aria-label="Default select example">
                                    <option selected>Pilih Product</option>
                                    @foreach ($product as $item)
                                    <option value="{{ $item->id }}">{{ $item->nm_produk }}</option>
                                    @endforeach
                                  </select>

                                  @error('id_product')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="name_toping">Nama Toping</label>
                                <input type="text" wire:model='name_toping' class="form-control @error('name_toping')
                                is-invalid
                                @enderror" id="name_toping"
                                    placeholder="Masukan Nama Toping">
                                    @error('name_toping')    
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-primary w-100">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->


            <!-- /.card -->

        </div>

        


    </div>
</div>
