<div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Bagian Scanner</h2>
            </div>
            <div class="card-body text-center">
                <!-- Tombol untuk memulai scanner -->
                <button class="btn btn-primary" id="btn-scan">Buka Scanner</button>
                <button class="btn btn-danger d-none mt-2" id="btn-stop">Tutup Scanner</button>
    
                <!-- Container untuk menampilkan QR Code Scanner -->
                <div id="scanner-container" class="mt-3 d-none">
                    <div id="reader" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk QR Code Scanner --}}
@push('scripts')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
    let scanner = new Html5Qrcode("reader");
    let isScanning = false;

    // Event untuk tombol "Buka Scanner"
    document.getElementById("btn-scan").addEventListener("click", function () {
        if (!isScanning) {
            // Menampilkan elemen scanner dan tombol stop
            document.getElementById("scanner-container").classList.remove("d-none");
            document.getElementById("btn-stop").classList.remove("d-none");
            this.classList.add("d-none"); // Sembunyikan tombol "Buka Scanner"
            
            // Mulai pemindaian QR code
            scanner.start(
                { facingMode: "environment" }, // Kamera belakang
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    // Setelah berhasil scan, update Livewire dengan hasil scan
                    Livewire.emit('set', 'qrCode', decodedText); // Mengupdate Livewire dengan hasil scan
                    scanner.stop();  // Hentikan scanner setelah berhasil scan
                    isScanning = false; // Set status scanning ke false
                },
                (errorMessage) => {
                    // Menangani error jika ada masalah dengan pemindaian
                    console.error(errorMessage);
                }
            ).then(() => {
                // Mengubah status scanning menjadi true
                isScanning = true;
            }).catch((err) => {
                // Tangani error jika pemindaian gagal
                console.error('Error starting QR code scanner: ', err);
            });
        }
    });

    // Event untuk tombol "Tutup Scanner"
    document.getElementById("btn-stop").addEventListener("click", function () {
        if (isScanning) {
            // Berhentikan pemindaian QR code
            scanner.stop().then(() => {
                // Menyembunyikan elemen scanner dan tombol stop
                document.getElementById("scanner-container").classList.add("d-none");
                document.getElementById("btn-scan").classList.remove("d-none");
                this.classList.add("d-none");

                // Mengubah status scanning menjadi false
                isScanning = false;
            }).catch((err) => {
                // Tangani error jika berhenti gagal
                console.error('Error stopping QR code scanner: ', err);
            });
        }
    });
</script>
@endpush