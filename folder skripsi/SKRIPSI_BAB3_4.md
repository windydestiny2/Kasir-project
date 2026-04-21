UNIVERSITAS GUNADARMA
FAKULTAS ILMU KOMPUTER & TEKNOLOGI INFORMASI
 
IMPLEMENTASI MACHINE LEARNING PADA SISTEM POINT OF SALES KEDAI SUGOIIYAKI UNTUK REKOMENDASI MENU DAN PREDIKSI PENDAPATAN
Disusun Oleh:
Nama		: Windy Destiny Tarmidi
NPM		: 11122475
Jurusan	: Sistem Informasi
Pembimbing	: Dr. Dina Agusten, ST., MMSI.

Diajukan Guna Melengkapi Sebagian Syarat 
Dalam Mencapai Gelar Setara Strata Satu (S1)

JAKARTA
2026
  

Lembar originalitas
























Lembar Pengesahan























Abstrak
























Kata pengantar
 
























Contents
I. PENDAHULUAN	7
1.1. Latar Belakang	7
1.2. Ruang Lingkup dan Batasan Masalah	9
1.4. Sistematika Penulisan	11
2. TINJAUAN PUSTAKA	12
2.1 Sistem Point of Sales (POS)	12
2.2 Machine Learning dan Algoritma	12
2.3 Sistem Rekomendasi Berbasis Popularitas	13
2.4 Linear Regression untuk Prediksi Pendapatan	14
2.5 Time Series Analysis dan Pola Musiman	14
2.6 Integrasi Web Service dan REST API	16
2.7 Penelitian Terkait	16
2.7.1 Sistem Rekomendasi untuk Food & Beverage	16
2.7.2 Revenue Forecasting untuk Retail dan F&B	17
2.7.3 Implementasi Machine Learning pada Sistem POS	17
DAFTAR PUSTAKA	18

  

I. PENDAHULUAN
1.1. Latar Belakang
Perkembangan teknologi informasi dan machine learning membuka peluang baru untuk mengolah data transaksi bisnis menjadi insight yang bernilai tinggi. Pada usaha kuliner, data transaksi penjualan yang tersimpan dalam sistem Point of Sales (POS) memiliki potensi untuk dianalisis menggunakan algoritma machine learning guna mengidentifikasi pola pembelian pelanggan, preferensi menu, dan tren penjualan.
Saat ini, banyak usaha kecil dan menengah di sektor food & beverage hanya memanfaatkan sistem POS sebagai alat pencatat transaksi dan pelaporan standar. Data transaksi yang terukumpul selama berbulan-bulan tidak dimaksimalkan untuk memberikan informasi strategis tentang perilaku konsumen dan proyeksi pendapatan. Padahal, dengan menerapkan machine learning, data tersebut dapat ditransformasi menjadi rekomendasi menu pintar, prediksi pendapatan akurat, dan analisis pola penjualan yang membantu pengambilan keputusan bisnis.
Machine learning menawarkan solusi otomatis untuk ekstraksi pengetahuan dari data historis tanpa perlu analisis manual yang intensif. Algoritma seperti popularity-based filtering, linear regression, dan time series analysis dapat dikembangkan untuk memberikan insights real-time kepada pemilik usaha. Dengan model machine learning yang terlatih, sistem POS dapat beradaptasi dengan perubahan pola penjualan dan memberikan rekomendasi yang semakin akurat seiring waktu.
Kedai Sugoiiyaki merupakan usaha kuliner yang telah mengimplementasikan sistem POS berbasis web dengan database transaksi yang lengkap. Data tersebut mencakup informasi produk yang terjual, jumlah transaksi, waktu pembelian, topping pilihan, varian ukuran, dan nilai penjualan harian. Untuk memaksimalkan potensi data ini, penelitian ini mengimplementasikan tiga model machine learning yang terintegrasi dengan sistem POS.
Berdasarkan kondisi tersebut, penelitian ini mengimplementasikan machine learning pada sistem Point of Sales Kedai Sugoiiyaki untuk menghasilkan informasi prediktif dan rekomendatif yang mendukung pengelolaan usaha. Tiga fitur machine learning yang dikembangkan meliputi: (1) model rekomendasi menu berbasis popularity-based filtering dengan mempertimbangkan day-of-week dan preferensi toping, (2) model prediksi pendapatan harian menggunakan algoritma linear regression dengan features day-of-week dan expected orders, dan (3) model analisis pola musiman menggunakan time series decomposition untuk mengidentifikasi peak hours dan trend penjualan. Ketiga model tersebut dilatih menggunakan data transaksi 120 hari terakhir dan diakses melalui REST API yang terintegrasi dengan dashboard web.
Dengan implementasi machine learning yang terstruktur pada sistem POS, data transaksi yang tersimpan dapat dimanfaatkan secara optimal menjadi sistem decision support yang powerful untuk Kedai Sugoiiyaki, sehingga pemilik usaha dapat membuat keputusan operasional berbasis data dan prediksi yang lebih akurat.
Berdasarkan latar belakang yang telah diuraikan, maka rumusan masalah dalam penelitian ini dirumuskan sebagai berikut.
Rumusan Masalah
Berdasarkan latar belakang yang telah dijelaskan, maka rumusan masalah dalam penelitian ini adalah sebagai berikut:
1.	Bagaimana mengimplementasikan model machine learning untuk recommendation system berbasis popularity-based filtering pada sistem Point of Sales Kedai Sugoiiyaki guna memberikan rekomendasi menu yang relevan sesuai hari dalam seminggu dan preferensi toping.
2.	Bagaimana melatih dan mengimplementasikan model linear regression untuk prediksi pendapatan harian pada Kedai Sugoiiyaki dengan menggunakan features day-of-week dan expected orders sehingga dapat membantu perencanaan keuangan operasional.
3.	Bagaimana mengimplementasikan time series analysis untuk mengidentifikasi pola musiman, peak hours, dan tren penjualan pada Kedai Sugoiiyaki berdasarkan data transaksi historis.
4.	Bagaimana mengintegrasikan ketiga model machine learning dengan REST API dan aplikasi web POS sehingga hasil prediksi dan rekomendasi dapat diakses secara real-time melalui dashboard untuk mendukung pengambilan keputusan operasional. 

1.2. Ruang Lingkup dan Batasan Masalah
Penelitian ini berfokus pada pemanfaatan data transaksi penjualan pada sistem Point of Sales (POS) yang digunakan oleh Kedai Sugoiiyaki untuk menghasilkan informasi yang dapat mendukung pengambilan keputusan operasional usaha. Sistem yang digunakan merupakan sistem POS berbasis web yang terhubung dengan database MySQL, dimana data transaksi diproses menggunakan model machine learning yang diimplementasikan dalam Python dan diakses melalui REST API Flask. 
Batasan masalah dalam penelitian ini adalah sebagai berikut:
1.	Data training yang digunakan adalah data transaksi penjualan Kedai Sugoiiyaki dari 120 hari terakhir yang tersimpan pada basis data MySQL sistem POS. 
2.	Model rekomendasi menu menggunakan algoritma popularity-based filtering dengan mempertimbangkan day-of-week, menu name, topping, dan ukuran produk
3.	Model prediksi pendapatan menggunakan linear regression dengan features day-of-week dan expected orders, dilatih dengan train-test split 80-20.
4.	Model time series analysis menggunakan seasonal decomposition dan moving average untuk mengidentifikasi pola musiman dan trend.
5.	Integrasi dilakukan melalui REST API dengan endpoint untuk prediksi menu, prediksi revenue, dan analisis seasonal patterns.
6.	Data yang dianalisis terbatas pada transaksi penjualan tanpa mempertimbangkan faktor eksternal seperti weather, event spesial, atau kampanye promosi.

1.3. Tujuan Penelitian
Tujuan dari penelitian ini adalah untuk mengimplementasikan model machine learning pada sistem Point of Sales Kedai Sugoiiyaki dengan tujuan menghasilkan insights prediktif dan rekomendatif yang mendukung pengambilan keputusan operasional. Secara lebih rinci, tujuan penelitian ini adalah:
1.	Menghasilkan informasi mengenai pola penjualan berdasarkan data transaksi yang tersimpan pada sistem Point of Sales.
2.	Mengembangkan fitur prediksi pendapatan harian untuk membantu pemilik usaha dalam memperkirakan potensi pemasukan.
3.	Memberikan rekomendasi menu berdasarkan day-of-week dan preferensi produk (topping, ukuran). 
4.	Mengidentifikasi pola musiman, peak hours, dan trend penjualan dalam setiap hari dalam seminggu.
5.	Mengintegrasikan ketiga model machine learning dengan REST API Flask dan aplikasi POS berbasis Laravel sehingga hasil prediksi dapat diakses secara real-time melalui dashboard untuk mendukung keputusan inventory management dan strategi penjualan.

1.4. Sistematika Penulisan
Sistematika penulisan skripsi ini disusun untuk memberikan gambaran mengenai alur pembahasan dalam penelitian. Bab I Pendahuluan berisi latar belakang, ruang lingkup, tujuan penelitian, dan sistematika penulisan. Bab II Tinjauan Pustaka berisi landasan teori yang mendukung penelitian seperti konsep Point of Sales, analisis data penjualan, sistem rekomendasi, dan machine learning. Bab III Metode Penelitian menjelaskan mengenai perancangan sistem, arsitektur aplikasi, metode machine learning yang digunakan, serta proses pengujian sistem. Bab IV Implementasi dan Hasil memaparkan hasil implementasi sistem, proses pelatihan model, serta hasil analisis dan prediksi yang dihasilkan oleh sistem. Bab V Pembahasan berisi analisis terhadap hasil implementasi serta evaluasi kinerja sistem. Bab VI Kesimpulan dan Saran berisi kesimpulan dari penelitian yang telah dilakukan serta saran untuk pengembangan penelitian selanjutnya.








II. TINJAUAN PUSTAKA

2.1 Sistem Point of Sales (POS)
Sistem Point of Sales (POS) merupakan sistem informasi yang digunakan untuk memproses transaksi penjualan dan mengelola data operasional bisnis secara terintegrasi. Sistem ini menggabungkan komponen perangkat keras seperti barcode scanner dan printer struk dengan perangkat lunak yang mengelola transaksi, inventori, serta laporan penjualan. Menurut Kolte (2024), sistem POS modern telah berkembang dari mesin kasir tradisional menjadi platform digital yang mampu mendukung pengelolaan transaksi, manajemen penjualan, serta analisis performa bisnis secara lebih efektif. 
Perkembangan teknologi juga mendorong munculnya POS berbasis web dan cloud, yang memungkinkan pemilik usaha untuk mengakses data transaksi secara real-time dari berbagai perangkat dan lokasi. Santos dan Mendes (2023)menyatakan bahwa transformasi digital dalam sistem POS memungkinkan integrasi dengan teknologi kecerdasan buatan untuk menganalisis data pelanggan dan meningkatkan pengambilan keputusan bisnis. 
Selain itu, sistem POS modern juga menghasilkan volume data transaksi yang besar sehingga dapat dimanfaatkan untuk analisis perilaku pelanggan dan pengambilan keputusan berbasis data. Kholod et al. (2024)menjelaskan bahwa integrasi data POS dengan teknologi analitik memungkinkan perusahaan melakukan analisis transaksi pelanggan secara lebih mendalam untuk meningkatkan efisiensi operasional dan strategi penjualan. 
2.2 Machine Learning dan Algoritma
Machine Learning merupakan cabang dari Artificial Intelligence (AI) yang memungkinkan komputer mempelajari pola dari data dan membuat prediksi tanpa perlu diprogram secara eksplisit. Teknologi ini banyak digunakan dalam analisis data bisnis, prediksi penjualan, dan sistem rekomendasi produk.
Menurut Pan dan Zhao (2022), machine learning memungkinkan sistem untuk membangun model dari data historis sehingga dapat mengenali pola tertentu dan menghasilkan prediksi terhadap data baru. Teknologi ini sangat penting dalam pengolahan big data karena mampu mengekstraksi informasi yang tidak dapat dianalisis secara manual. 
Secara umum, machine learning memiliki tiga pendekatan utama yaitu:
1.	Supervised Learning, yaitu pembelajaran menggunakan data yang telah memiliki label.
2.	Unsupervised Learning, yaitu pembelajaran dari data tanpa label untuk menemukan pola tersembunyi.
3.	Reinforcement Learning, yaitu pembelajaran melalui interaksi dengan lingkungan dan feedback.
Dalam sistem POS berbasis analitik, pendekatan yang sering digunakan adalah supervised learning, karena model dilatih menggunakan data historis transaksi penjualan untuk menghasilkan prediksi atau rekomendasi.
2.3 Sistem Rekomendasi Berbasis Popularitas
Sistem rekomendasi merupakan teknologi yang digunakan untuk memberikan saran item kepada pengguna berdasarkan pola data tertentu. Dalam konteks bisnis kuliner, sistem ini dapat membantu pelanggan menemukan menu yang sesuai dengan preferensi mereka serta membantu bisnis meningkatkan penjualan.
Menurut Chen dan Xia (2021), sistem rekomendasi pada restoran bekerja dengan menganalisis data preferensi pengguna serta informasi kontekstual seperti waktu, lokasi, dan harga untuk menghasilkan rekomendasi yang lebih akurat. 
Salah satu metode yang sering digunakan adalah popularity-based recommendation, yaitu metode yang merekomendasikan item berdasarkan tingkat popularitasnya, seperti frekuensi pemesanan atau tingkat rating produk. Metode ini dianggap efektif terutama ketika sistem belum memiliki banyak data preferensi pengguna.
Penelitian oleh Tyagi et al. (2024) mengembangkan sistem rekomendasi restoran berbasis machine learning yang memanfaatkan popularity ranking untuk merekomendasikan restoran dan menu populer kepada pengguna. Hasil penelitian menunjukkan bahwa pendekatan popularity-based dapat membantu pengguna menemukan menu populer secara lebih mudah dan meningkatkan pengalaman pengguna dalam memilih makanan. 
2.4 Linear Regression untuk Prediksi Pendapatan
Linear Regression merupakan salah satu algoritma machine learning yang digunakan untuk memodelkan hubungan antara variabel independen dan variabel dependen. Metode ini sering digunakan untuk melakukan prediksi, termasuk prediksi penjualan atau pendapatan bisnis.
Dalam konteks analisis bisnis, model regresi dapat digunakan untuk memprediksi pendapatan berdasarkan variabel seperti jumlah transaksi, jumlah pelanggan, atau pola penjualan historis. Penggunaan data transaksi dari sistem POS memungkinkan model regresi mempelajari hubungan antara aktivitas penjualan dan pendapatan yang dihasilkan.
Menurut Pan dan Zhao (2022), algoritma machine learning seperti regresi dapat digunakan untuk menganalisis pola data bisnis dan menghasilkan model prediksi yang membantu organisasi dalam mengambil keputusan berbasis data. 

2.5 Time Series Analysis dan Pola Musiman
Time series analysis merupakan metode analisis data yang digunakan untuk mempelajari pola dari data yang tersusun berdasarkan urutan waktu. Teknik ini sering digunakan dalam analisis penjualan untuk mengidentifikasi tren, pola musiman, serta fluktuasi permintaan pelanggan.
Dalam bisnis retail dan food & beverage, pola musiman biasanya muncul pada jam tertentu seperti jam makan siang dan makan malam, serta perbedaan antara hari kerja dan akhir pekan. Analisis pola tersebut dapat membantu bisnis dalam melakukan perencanaan operasional seperti pengelolaan stok dan penjadwalan karyawan.
Menurut Kholod et al. (2024), data transaksi dari sistem POS dapat digunakan sebagai sumber utama untuk analisis pola perilaku pelanggan karena data tersebut merekam aktivitas penjualan secara kronologis dan real-time. Analisis time series terhadap data transaksi tersebut memungkinkan bisnis memahami tren penjualan dan meningkatkan akurasi prediksi permintaan. 


2.6 Integrasi Web Service dan REST API
Time series analysis merupakan metode analisis data yang digunakan untuk mempelajari pola dari data yang tersusun berdasarkan urutan waktu. Teknik ini sering digunakan dalam analisis penjualan untuk mengidentifikasi tren, pola musiman, serta fluktuasi permintaan pelanggan. Dalam konteks ilmu machine learning, analisis time series sering digunakan untuk melakukan forecasting atau prediksi nilai di masa depan berdasarkan data historis. Menurut Hall dan Rasheed (2025), time series prediction merupakan proses memprediksi nilai masa depan dengan memanfaatkan urutan observasi historis, dan berbagai algoritma machine learning seperti tree-based models, neural networks, serta deep learning sering digunakan untuk meningkatkan akurasi prediksi pada data temporal. 
Dalam bisnis retail dan food & beverage, pola musiman biasanya muncul pada jam tertentu seperti jam makan siang dan makan malam, serta perbedaan antara hari kerja dan akhir pekan. Analisis pola tersebut dapat membantu bisnis dalam melakukan perencanaan operasional seperti pengelolaan stok dan penjadwalan karyawan. Selain itu, perkembangan machine learning juga memungkinkan penggunaan model yang lebih kompleks seperti recurrent neural networks (RNN), convolutional neural networks (CNN), dan transformer models untuk mempelajari pola temporal dalam data time series secara lebih mendalam. Menurut Torres et al. (2021), teknik deep learning telah banyak digunakan dalam time series forecasting karena kemampuannya menangkap hubungan non-linear dan dependensi jangka panjang pada data berurutan. 
Menurut Kholod et al. (2024), data transaksi dari sistem POS dapat digunakan sebagai sumber utama untuk analisis pola perilaku pelanggan karena data tersebut merekam aktivitas penjualan secara kronologis dan real-time. Analisis time series terhadap data transaksi tersebut memungkinkan bisnis memahami tren penjualan, mengidentifikasi pola musiman, serta meningkatkan akurasi prediksi permintaan pelanggan.
2.7 Penelitian Terkait
2.7.1 Sistem Rekomendasi untuk Food & Beverage
Penelitian oleh Asani et al. (2021) mengembangkan sistem rekomendasi restoran berbasis analisis sentimen dari ulasan pelanggan. Sistem ini mampu mengekstraksi preferensi pengguna dari komentar pelanggan dan menghasilkan rekomendasi restoran yang lebih personal. 
Penelitian lain oleh Benhard et al. (2024) mengembangkan sistem rekomendasi menu restoran yang mampu meningkatkan kepuasan pelanggan serta membantu restoran memberikan rekomendasi menu yang relevan berdasarkan data transaksi. 
2.7.2 Implementasi Machine Learning pada Sistem POS
Penelitian oleh Santos dan Mendes (2023) menunjukkan bahwa integrasi teknologi kecerdasan buatan dan machine learning dalam sistem POS memungkinkan analisis data pelanggan dan transaksi secara otomatis sehingga membantu bisnis dalam meningkatkan performa penjualan. 
Selain itu, Kholod et al. (2024) menunjukkan bahwa integrasi data POS dengan teknologi analitik memungkinkan perusahaan melakukan analisis perilaku pelanggan secara lebih mendalam serta meningkatkan efisiensi operasional bisnis retail.









III. METODE PENELITIAN
3.1 Jenis dan Pendekatan Penelitian
Penelitian ini menggunakan pendekatan penelitian pengembangan sistem (system development research) dengan metode Rapid Application Development (RAD). Metode RAD dipilih karena mampu mempercepat proses pengembangan aplikasi melalui pembuatan prototipe secara iteratif dan melibatkan pengguna secara langsung dalam proses evaluasi sistem.
Rapid Application Development merupakan metode pengembangan perangkat lunak yang menekankan pada proses pembangunan prototipe yang cepat, pengujian secara berulang, serta umpan balik dari pengguna untuk menyempurnakan sistem. Dengan pendekatan ini, sistem yang dikembangkan dapat disesuaikan secara langsung dengan kebutuhan pengguna dalam waktu yang relatif singkat.
Dalam penelitian ini metode RAD digunakan untuk mengembangkan sistem Point of Sales (POS) yang terintegrasi dengan machine learning guna menghasilkan fitur:
1.	Rekomendasi menu berbasis data transaksi
2.	Prediksi pendapatan harian
3.	Analisis pola penjualan dan tren musiman
Metode RAD dalam penelitian ini terdiri dari empat tahapan utama yaitu:
1.	Requirements Planning
Tahap identifikasi kebutuhan sistem dan analisis data transaksi yang tersedia pada sistem POS Kedai Sugoiiyaki.
2.	User Design
Tahap perancangan sistem meliputi desain arsitektur sistem, dashboard analisis data, serta perancangan API untuk integrasi machine learning.
3.	Construction
Tahap implementasi sistem meliputi pengembangan model machine learning, pembuatan REST API menggunakan Flask, serta integrasi dengan aplikasi POS berbasis Laravel.
4.	Cutover
Tahap pengujian sistem, evaluasi hasil model, serta implementasi sistem secara operasional.
3.2 Lokasi dan Waktu Penelitian
Penelitian ini dilaksanakan pada Kedai Sugoiiyaki, sebuah usaha kuliner yang telah menggunakan sistem Point of Sales berbasis web untuk mengelola transaksi penjualan.
Lokasi penelitian berfungsi sebagai sumber data transaksi yang digunakan dalam proses analisis dan pelatihan model machine learning.
Adapun waktu pelaksanaan penelitian berlangsung selama beberapa tahap yang meliputi:
Tahap Penelitian	Waktu
Pengumpulan data transaksi	Februari – Juni 2026
Pengembangan sistem	Mei – Juni 2026
Pengujian sistem dan evaluasi	Juni 2026
Data yang digunakan dalam penelitian merupakan data transaksi penjualan selama 120 hari terakhir yang tersimpan dalam database sistem POS.
 
3.3 Bahan dan Peralatan Penelitian
3.3 Bahan dan Peralatan Penelitian
Bagian ini menjelaskan perangkat keras, perangkat lunak, dan komponen utama yang digunakan dalam pengembangan sistem Point of Sales Kedai Sugoiiyaki dengan fitur machine learning.

3.3.1 Perangkat Keras
Perangkat keras yang digunakan dalam penelitian ini meliputi:
- Device: MacBook Air 2020
- Prosesor: Apple M1
- RAM: 8 GB
- Penyimpanan: 256 GB SSD
- Koneksi jaringan: akses internet untuk instalasi paket dan dokumentasi

3.3.2 Perangkat Lunak
Perangkat lunak yang digunakan dalam penelitian ini terdiri dari sistem operasi, lingkungan pengembangan, framework backend, library machine learning, serta server dan database.

Tabel 3.1 Perangkat Lunak yang Digunakan
Kategori	Software / Library	Versi	Fungsi
Sistem Operasi	macOS Sonoma	14.6	Menjalankan lingkungan pengembangan
Code Editor	Visual Studio Code	1.102.1	Menulis dan mengelola kode program
Local Server	XAMPP	8.2.4-0	Menjalankan Apache, PHP, dan MySQL secara lokal
Web Browser	Safari	17.6	Testing dan pengujian aplikasi web
Version Control	Git	-	Mengelola versi kode dan riwayat perubahan
Backend Framework	Laravel	12.11.1	Pengembangan aplikasi POS berbasis web
Frontend / UI	AdminLTE	3.2.0	Template dashboard berbasis Bootstrap
Frontend Build	Vite	5.0.0	Membangun aset JavaScript dan CSS
Bahasa Pemrograman	PHP	^8.2	Logika aplikasi POS dan backend Laravel
Bahasa Pemrograman	JavaScript	-	Interaksi frontend dan permintaan API
Bahasa Pemrograman	Python	3.11.x	Pemrosesan data dan implementasi model ML
Web API	Flask	3.x	Membangun REST API untuk layanan machine learning
Machine Learning	scikit-learn	-	Implementasi Linear Regression dan scoring
Data Processing	pandas	-	Pembersihan dan transformasi data transaksi
Data Processing	numpy	-	Komputasi numerik dan feature engineering
Model Serialization	joblib	-	Menyimpan dan memuat model ML
Database	MySQL	14.14	Penyimpanan data transaksi dan master data
PHP Package	barryvdh/laravel-dompdf	^3.1	Pembuatan laporan PDF (opsional)
PHP Package	livewire/livewire	^3.6	Interaksi dinamis tanpa JavaScript manual
PHP Package	milon/barcode	^12.0	Pencetakan barcode pada nota
npm Package	axios	^1.6.4	HTTP client untuk komunikasi frontend dan API

3.4 Data dan Sumber Data Penelitian
Data penelitian menggunakan data primer dari sistem Point of Sales Kedai Sugoiiyaki. Data ini diambil langsung dari basis data MySQL yang memuat transaksi penjualan harian.

Variabel yang dianalisis meliputi:
- tanggal transaksi
- nama menu
- topping
- ukuran produk
- jumlah item
- total nilai transaksi
- hari dalam minggu
- jam transaksi

Sumber data terdiri dari tabel-tabel berikut:
- orders
- order_items
- products
- topings
- ukurans

Jumlah total data yang digunakan sekitar 5.247 item transaksi selama periode 120 hari terakhir. Data tersebut digunakan untuk:
- pelatihan model machine learning
- validasi model
- analisis pola musiman dan tren penjualan

3.5 Teknik Pengumpulan Data
Teknik pengumpulan data dilakukan dengan mengekstrak data transaksi dari database MySQL sistem POS menggunakan query SQL.

Proses pengumpulan data mencakup:
1. Ekstraksi data menggunakan query JOIN untuk menggabungkan informasi order, produk, topping, dan ukuran.
2. Eksport data menjadi format yang dapat diolah oleh Python.
3. Preprocessing data menggunakan pandas untuk membersihkan nilai kosong, melakukan normalisasi, dan membuat fitur tambahan.

Contoh query yang digunakan:
SELECT o.created_at, DATE(o.created_at) AS order_date,
       DAYOFWEEK(o.created_at) AS day_of_week,
       HOUR(o.created_at) AS order_hour,
       p.nm_produk,
       t.name_toping,
       u.nama AS ukuran,
       oi.qty,
       oi.total AS item_total
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
LEFT JOIN topings t ON oi.toping_id = t.id
LEFT JOIN ukurans u ON oi.ukuran_id = u.id;

Data hasil query selanjutnya diproses di Python dengan pandas untuk keperluan preprocessing, feature engineering, dan pembentukan dataset pelatihan.

3.6 Metode Analisis Data dan Machine Learning
Penelitian ini menerapkan tiga pendekatan machine learning untuk menghasilkan informasi yang dapat mendukung pengambilan keputusan operasional.

3.6.1 Sistem Rekomendasi Menu
Sistem rekomendasi menu menggunakan pendekatan popularity-based recommendation. Metode ini memberikan rekomendasi menu berdasarkan popularitas yang dihitung dari jumlah pesanan dan kontribusi pendapatan.

Formula popularitas yang digunakan:
popularity_score = (order_count × 0.6) + (normalized_revenue × 0.4)

di mana:
- order_count adalah jumlah pesanan per kombinasi menu, topping, dan ukuran
- normalized_revenue adalah total pendapatan yang dinormalisasi

Pengelompokan data dilakukan berdasarkan:
- day_of_week
- nama produk
- topping
- ukuran

Hasil rekomendasi ditampilkan pada dashboard POS untuk membantu pemilihan menu populer sesuai hari dan preferensi pelanggan.

3.6.2 Prediksi Pendapatan Harian
Model prediksi pendapatan harian menggunakan algoritma Linear Regression dari scikit-learn. Model ini dilatih menggunakan fitur berikut:
- day_of_week
- jumlah pesanan harian
- total pendapatan harian (jika tersedia)

Persamaan regresi linear yang digunakan:
Y = β0 + β1X1 + β2X2 + ε

di mana:
- Y adalah prediksi pendapatan harian
- X1 adalah representasi numerik hari dalam minggu
- X2 adalah jumlah pesanan per hari

Evaluasi model dilakukan menggunakan metrik:
- Mean Squared Error (MSE)
- R² Score

3.6.3 Analisis Pola Musiman Penjualan
Analisis pola musiman dilakukan dengan teknik time series untuk mengidentifikasi tren dan jam puncak penjualan.

Metode yang digunakan meliputi:
- moving average untuk meratakan fluktuasi harian
- daily aggregation untuk melihat total penjualan per hari
- peak hour detection untuk menemukan jam-jam dengan volume transaksi tertinggi

Analisis ini membantu memahami perbedaan antara hari kerja dan akhir pekan, serta penentuan periode penjualan yang paling sibuk.

3.7 Rancangan Sistem dan Arsitektur
Sistem yang dikembangkan terdiri dari dua komponen utama:
1. Sistem POS berbasis Laravel
2. Sistem Machine Learning berbasis Python Flask

Arsitektur sistem digambarkan sebagai berikut:
POS Web Dashboard (Laravel)
        │
        │ HTTP Request
        ▼
Machine Learning API (Flask)
        │
        │ Model dan Data
        ▼
Database MySQL

Dashboard POS akan mengambil data prediksi melalui REST API yang disediakan oleh layanan machine learning.

Komponen utama sistem:
- Aplikasi Laravel: mengelola transaksi, menampilkan dashboard, dan memanggil layanan ML
- Database MySQL: menyimpan data master produk, topping, ukuran, dan transaksi
- API Flask: menyediakan endpoint prediksi dan rekomendasi
- Model ML: diserialisasi dengan joblib untuk pemanggilan ulang tanpa pelatihan ulang

3.8 Prosedur Penelitian
Tahapan penelitian yang dilakukan dalam penelitian ini adalah sebagai berikut:
1. Pengumpulan Data
   - Mengambil data transaksi dari database sistem POS
2. Preprocessing Data
   - Membersihkan dan mempersiapkan data untuk analisis machine learning
3. Pengembangan Model Machine Learning
   - Melatih model rekomendasi menu, model prediksi pendapatan, dan model analisis pola musiman
4. Implementasi API Machine Learning
   - Mengembangkan REST API Flask untuk menyediakan layanan prediksi
5. Integrasi Sistem POS
   - Menghubungkan dashboard POS berbasis Laravel dengan API Flask
6. Pengujian Sistem
   - Menguji seluruh fitur dan memastikan sistem berjalan sesuai rancangan

3.9 Pengujian dan Evaluasi Sistem
Pengujian sistem dilakukan dengan beberapa metode berikut:
1. Unit Testing
   - Menguji setiap fungsi dan endpoint API Flask
2. Evaluasi Model
   - Mengukur akurasi model menggunakan MSE dan R²
3. Integration Testing
   - Menguji alur data dari Laravel ke API Flask
4. User Acceptance Testing (UAT)
   - Pengujian oleh pemilik Kedai Sugoiiyaki untuk memastikan sistem sesuai kebutuhan operasional

Selain itu, pengujian mencakup verifikasi konsistensi data, kecepatan respon API, dan validitas rekomendasi menu.

3.10 Alur Penelitian
Alur penelitian dalam penelitian ini dapat digambarkan sebagai berikut:
Pengumpulan Data
        ↓
Preprocessing Data
        ↓
Pengembangan Model Machine Learning
        ↓
Evaluasi Model
        ↓
Implementasi REST API
        ↓
Integrasi dengan Sistem POS
        ↓
Pengujian Sistem
        ↓
Analisis Hasil






DAFTAR PUSTAKA
Aggarwal, C. C. (2016). Recommender Systems. Springer International Publishing.
Alsharif, M. H., Younes, M. K., & Kim, J. (2020). Time series ARIMA model for prediction of daily wind speed using a dimensionality reduction and principal component analysis. Energies, 13(10), 2505.
Bishop, C. M. (2006). Pattern Recognition and Machine Learning. Springer Science+Business Media.
Box, G. E., Jenkins, G. M., Reinsel, G. C., & Ljung, G. M. (2015). Time Series Analysis: Forecasting and Control (5th ed.). John Wiley & Sons.
Cleveland, R. B., Cleveland, W. S., McRae, J. E., & Terpenning, I. (1990). STL: A seasonal-trend decomposition procedure for time series. Journal of Official Statistics, 6(1), 3-33.
Fielding, R. T. (2000). Architectural styles and the design of network-based software architectures. Doctoral dissertation, University of California, Irvine.
Gao, L., Zhang, X., Zhang, W., & Dong, M. (2018). A mobile point-of-sale system for small merchants: Design and implementation. Journal of Retail and Consumer Services, 42(3), 178-189.
Goodfellow, I., Bengio, Y., & Courville, A. (2016). *Deep Learning*. MIT Press.

Hastie, T., Tibshirani, R., & Friedman, J. (2009). The Elements of Statistical Learning: Data Mining, Inference, and Prediction (2nd ed.). Springer.
Hendro, W., Santoso, H., & Wijaya, A. (2020). Hybrid recommendation system for restaurant menu using collaborative filtering and content-based filtering. Procedia Computer Science, 179(1), 423-432.
Nangoy, B. S., Suhartanto, D., & Riyanto, I. (2019). Development of collaborative filtering-based menu recommendation system for Indonesian restaurant. International Journal of Computer Applications, 177(19), 28-35.
Prabowo, R., Sembiring, A., Kusuma, I., & Suryanto, H. (2021). Development and evaluation of web-based point of sale system with integrated inventory management. Journal of Information Technology Education, 20(8), 125-142.
Praktomo, A., Wijaya, H., Santoso, B., & Kusuma, R. (2019). Machine learning approach for revenue forecasting in quick service restaurant: A gradient boosting study. International Journal of Business Analytics, 6(2), 45-62.
Ricci, F., Rokach, L., & Shapira, B. (2015). Recommender Systems Handbook, (2nd ed.). Springer Publishing.

Asani, N., Nejad, M. G., & Sadri, J. (2021). Restaurant recommendation system based on sentiment analysis of user reviews. Journal of Hospitality and Tourism Technology, 12(2), 261–276.
Benhard, M., Hugeng, H., & Lauro, M. (2024). Restaurant menu recommendation system using machine learning approaches. Journal of Information System Technology, 5(1), 1–10.
Chen, L., & Xia, Y. (2021). Restaurant recommendation system based on machine learning techniques. Journal of Intelligent & Fuzzy Systems, 40(2), 2321–2333.
Hall, A., & Rasheed, K. (2025). Machine learning approaches for time series prediction: A survey. Applied Sciences, 15(1), 1–21.
Kholod, M., Celani, A., & Ciaramella, G. (2024). The analysis of customers’ transactions based on POS and RFID data using big data analytics tools in the retail space of the future. Applied Sciences, 14(24), 11567. https://doi.org/10.3390/app142411567
Pan, S. J., & Zhao, Q. (2022). A survey on machine learning methods for data analytics. Journal of Artificial Intelligence Research, 73, 1–35.
Santos, V., & Mendes Bacalhau, L. (2023). Digital transformation of the retail point of sale in the artificial intelligence era. In J. D. Santos, I. V. Pereira, & P. B. Pires (Eds.), Management and Marketing for Improved Retail Competitiveness and Performance (pp. 200–216). IGI Global. https://doi.org/10.4018/978-1-6684-8574-3.ch010
Tyagi, R., Sinha, P., Garg, S., & Chandra, S. (2024). Machine learning-based restaurant recommendation system using popularity ranking. SSRN Electronic Journal. https://doi.org/10.2139/ssrn.4851646
Torres, J., Hadjout, D., Sebaa, A., Martínez, A., & Herrera, F. (2021). Deep learning for time series forecasting: A survey. Big Data, 9(1), 3–21.
Ramadhani, I., Nindyasari, R., & Murti, A. C. (2024). Design and development of a web-based point of sale system for small-scale retail management. Bit-Tech Journal, 3(2), 45–56.
Raja, M. W. P., Noviana, L. P. R., & Dewi, A. A. K. (2024). Analisis sistem point of sale untuk meningkatkan efisiensi dan optimalisasi bisnis retail. Jurnal Manajemen dan Teknologi Informasi, 7(1), 1–9.
Sari, M. M., Arribathi, A. H., & Astriyani, E. (2025). Pengembangan aplikasi point of sale berbasis website menggunakan metodologi agile. ICIT Journal, 10(1), 45–53.

