<div>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengeluaran</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->


                <form wire:submit.prevent='EditPengeluaran'>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" wire:model='tanggal' class="form-control @error('tanggal')
                                    is-invalid
                                    @enderror" id="tanggal" placeholder="Masukan Nama ">
                                @error('tanggal')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" wire:model='keterangan' class="form-control @error('keterangan')
                                        is-invalid
                                    @enderror" id="keterangan" placeholder="Masukan Keterangan Pengeluaran">
                                @error('keterangan')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="jumlah">Jumlah </label>
                                <input type="text" wire:model='jumlah' class="form-control @error('jumlah')
                                        is-invalid
                                    @enderror" id="jumlah" oninput="formatRupiah(this)" placeholder="Masukan jumlah pengeluaran">
                                @error('jumlah')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>




                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-primary w-100">Edit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->


            <!-- /.card -->

        </div>




    </div>
</div>

{{-- number input --}}
<script>
    function formatRupiah(el) {
        let angka = el.value.replace(/\D/g, '');
        let format = new Intl.NumberFormat('id-ID').format(angka);
        el.value = format;

        // Kirim nilai asli ke Livewire
        let inputEvent = new Event('input', { bubbles: true });
        el.dispatchEvent(inputEvent);
    }

    document.addEventListener('livewire:load', function () {
        let input = document.getElementById('jumlah');
        if (input) {
            input.value = new Intl.NumberFormat('id-ID').format(input.value.replace(/\D/g, ''));
        }
    });
</script>