<div>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Ukuran</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                
                <form wire:submit.prevent='TambahUkuran'>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Pilih Produk</label>
                                <select wire:model.live='myProduct' class="form-control">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id }}">{{ $item->nm_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <div class="form-group col-md-6">
                                <label>Pilih Toping</label>
                                <select wire:model.live='myToping' class="form-control" @if(empty($topings)) disabled @endif>
                                    <option value="">Pilih Toping</option>
                                    @foreach ($topings as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_toping }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label>Nama Ukuran</label>
                                <input type="text" wire:model="nama" class="form-control" placeholder="Nama Ukuran">
                            </div>
                
                            <div class="form-group col-md-6">
                                <label>Harga</label>
                                <input type="number" wire:model="harga" class="form-control" placeholder="Harga">
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

        


    </div>
</div>






