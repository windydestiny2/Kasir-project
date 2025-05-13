<div>
  {{-- In work, do what you enjoy. --}}
  <div class="row">
    <!-- Bagian Pesanan -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Layanan Pesanan</h3>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Produk</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($carts as $key => $cart)
                  <tr wire:key="cart-row-{{ $cart['id'] }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $cart['product']['nm_produk'] }}</td>
                    <td>Rp {{ number_format($cart['price'], 0, ',', '.') }}</td>
                    <td>
                      <button class="btn btn-danger py-0" wire:click='decrement({{ $cart['id'] }})'>-</button>
                      <span>{{ $cart['qty'] }}</span>
                      <button class="btn btn-primary py-0" wire:click='increment({{ $cart['id'] }})'>+</button>
                    </td>
                    <td>Rp {{ number_format($cart['qty'] * $cart['price'], 0, ',', '.') }}</td>
                    <td>
                      <button class="btn btn-danger" wire:click="DeletePesanan({{ $cart['id'] }})" onclick="if(!confirm('Apakah Yakin Ingin Dihapus?')) event.stopImmediatePropagation()">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>

                  @if (!empty($cart['product']['toping']) && count($cart['product']['toping']) > 0)
                  <tr wire:key="toping-row-{{ $cart['id'] }}">
                    {{-- Toping --}}
                    <td colspan="3">
                      <label>Toping</label>
                      <select class="form-control" wire:model.live="toping.{{ $cart['id'] }}">
                        <option value="">Pilih Toping</option>
                        @foreach ($cart['product']['toping'] as $topingItem)
                          <option value="{{ $topingItem['id'] }}">{{ $topingItem['name_toping'] }}</option>
                        @endforeach
                      </select>
                    </td>

                    {{-- Ukuran --}}
                    <td colspan="3">
                      <label>Ukuran</label>
                      <select class="form-control" wire:model.live="ukuran.{{ $cart['id'] }}" @if(empty($myUkuran[$cart['id']])) disabled @endif>
                        <option value="">Pilih Ukuran</option>
                        @foreach ($myUkuran[$cart['id']] ?? [] as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }} - Rp {{ number_format($item->harga, 0, ',', '.') }}</option>
                        @endforeach
                      </select>
                    </td>

                    {{-- Harga --}}
                    {{-- <td colspan="2">
                      <label>Harga Ukuran</label>
                      <input type="text" class="form-control" readonly
                        value="{{ isset($hargaUkuran[$cart['id']]) ? 'Rp ' . number_format($hargaUkuran[$cart['id']], 0, ',', '.') : '-' }}">
                    </td> --}}
                  </tr>
                @endif

                @endforeach

                <tr>
                  <th colspan="3">Catatan Pesanan <span class="text-danger small">(Opsional)</span></th>
                  <th colspan="3"><input type="text" class="form-control" wire:model='catatan'></th>
                </tr>
                <tr>
                  <th colspan="3">Total Belanja</th>
                  <th colspan="3">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</th>
                </tr>
                <tr>
                  <th colspan="3">Total Bayar</th>
                  <th colspan="3">
                    <input type="text" class="form-control" id="totalBayar" oninput="fungsi(this)" wire:model.live="totalBayar">
                  </th>
                </tr>
                <tr>
                  <th colspan="3">Kembalian</th>
                  <th colspan="3">Rp {{ number_format($this->kembalian, 0, ',', '.') }}</th>
                </tr>
                <tr>
                  <th colspan="6">
                    <button class="btn btn-primary" wire:click='bayar'>Bayar</button>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bagian Scanner -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Bagian Scanner</h2>
        </div>
        <div class="card-body text-center">
          <button class="btn btn-primary" id="btn-scan">Buka Scanner</button>
          <button class="btn btn-danger d-none mt-2" id="btn-stop">Tutup Scanner</button>
          <div id="scanner-container" class="mt-3 d-none">
            <div id="reader" style="width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Daftar Menu -->
  <div class="col-12" wire:noscroll>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Menu</h3>
      </div>
      <div class="container mt-3">
        <div class="col-sm-12 col-md-6">
          <input type="text" class="form-control form-control-sm" placeholder="Cari Produk" wire:model.live.debounce.300ms="search">
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Image</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $key => $product)
                <tr>
                  <td>{{ $products->firstItem() + $key }}</td>
                  <td>{{ $product->nm_produk }}</td>
                  <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                  <td>{{ $product->stok }}</td>
                  <td>
                    <img src="{{ asset('storage/'. $product->image) }}" class="img-fluid" width="50" alt="">
                  </td>
                  <td>
                    <button class="btn btn-danger" wire:click='tambahPesanan({{ $product->id }})'>
                      <i class="fas fa-plus"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div class="py-2">
            {{ $products->links() }}
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

{{-- ajak sub category --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('select[name="toping_id"]').on('change', function(){
          var toping_id = $(this).val();
          if(toping_id) {
              $.ajax({
                  url: "{{ url('/toping/ajax') }}/" + toping_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data){
                      var d = $('select[name="ukuran_id"]').empty();
                      $.each(data, function (key, value){
                          $('select[name="ukuran_id"]').append(
                              '<option value="' + value.id + '">' + value
                                  .nama + '</option>'
                                  );
                      });
                  },
              });
          } else {
              alert('danger');
          }
      });
  });
</script> --}}


<!-- Script format angka -->
<script>
  function fungsi(el) {
    let angka = el.value.replace(/\D/g, '');
    el.value = new Intl.NumberFormat('id-ID').format(angka);
    let inputEvent = new Event('input', { bubbles: true });
    el.dispatchEvent(inputEvent);
  }
  document.addEventListener('livewire:load', function () {
    let input = document.getElementById('totalBayar');
    if (input) {
      input.value = new Intl.NumberFormat('id-ID').format(input.value.replace(/\D/g, ''));
    }
  });
</script>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
  let scanner = new Html5Qrcode("reader");
  let isScanning = false;

  document.getElementById("btn-scan").addEventListener("click", function () {
    if (!isScanning) {
      document.getElementById("scanner-container").classList.remove("d-none");
      document.getElementById("btn-stop").classList.remove("d-none");
      this.classList.add("d-none");

      scanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText) => {
          
          @this.set('qrCode', decodedText);
          scanner.stop();
          isScanning = false;
        },
        (errorMessage) => {
          console.error(errorMessage);
        }
      ).then(() => {
        isScanning = true;
      }).catch((err) => {
        console.error('Error starting QR code scanner: ', err);
      });
    }
  });

  document.getElementById("btn-stop").addEventListener("click", function () {
    if (isScanning) {
      scanner.stop().then(() => {
        document.getElementById("scanner-container").classList.add("d-none");
        document.getElementById("btn-scan").classList.remove("d-none");
        this.classList.add("d-none");
        isScanning = false;
      }).catch((err) => {
        console.error('Error stopping QR code scanner: ', err);
      });
    }
  });
</script>
@endpush