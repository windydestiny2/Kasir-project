# ✅ SETUP CHECKLIST - ML KASIR

**Panduan step-by-step memastikan semua siap untuk ML**

---

## BAGIAN A: PRE-SETUP CHECKS (Sebelum mulai)

### ✅ Environment Readiness

- [ ] macOS / Linux / Windows (noted: using macOS)
- [ ] Python 3.8+ installed
  ```bash
  python3 --version
  # Expected: Python 3.x.x
  ```
- [ ] XAMPP / MySQL running
  - [ ] Open XAMPP Control Panel
  - [ ] MySQL status = "Running"
- [ ] Laravel project berjalan
  ```bash
  # Terminal buka
  cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project
  php artisan serve
  # Akses: http://localhost:8000 ✅
  ```

### ✅ Database Readiness

- [ ] Database `db_kasir` sudah ada
  ```bash
  # phpMyAdmin → Cek list database
  # atau SQL: SHOW DATABASES;
  ```
- [ ] Tabel `orders` ada & punya data
  ```bash
  # SQL: SELECT COUNT(*) FROM orders;
  # Expected: > 0 rows
  ```
- [ ] Tabel terkait ada:
  - [ ] `order_items`
  - [ ] `products`
  - [ ] `topings` / `toppings`
  - [ ] `ukurans`
  - [ ] `users`

### ✅ File Structure

- [ ] Folder `ml_engine/` ada
- [ ] File ada:
  - [ ] `app.py`
  - [ ] `train_menu_recommendation.py`
  - [ ] `train_revenue_forecasting.py`
  - [ ] `train_seasonal_pattern.py`
  - [ ] `test_api.py`
  - [ ] `requirements.txt`
  - [ ] `.env` (atau create baru)

---

## BAGIAN B: INSTALLATION SETUP (Instalasi awal)

### 1️⃣ Virtual Environment

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine

# Create venv
python3 -m venv venv

# Activate
source venv/bin/activate

# Check: Prompt seharusnya jadi (venv) python3 ...
```

**Checklist:**
- [ ] Folder `venv/` ada
- [ ] Aktif terlihat dari prefix `(venv)` di terminal

### 2️⃣ Install Dependencies

```bash
# Pastikan venv aktif dulu!
# Prompt seharusnya: (venv) user@...

pip install -r requirements.txt

# Tunggu sampai selesai (2-5 menit)
# Expected output terakhir: Successfully installed ...
```

**Checklist:**
- [ ] Tidak ada error (-y atau -n question)
- [ ] Semua package terinstall:
  ```bash
  pip list | grep -E 'pandas|numpy|scikit|flask|mysql'
  # Seharusnya muncul semua
  ```

### 3️⃣ Configure .env

**File:** `ml_engine/.env`

```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=db_kasir
DB_PORT=3306
```

**Checklist:**
- [ ] File `.env` ada di folder `ml_engine/`
- [ ] Isi sesuai dengan database Anda:
  ```bash
  # Test koneksi dengan Python
  python3 -c "
  import mysql.connector
  config = {
      'host': 'localhost',
      'user': 'root',
      'password': '',
      'database': 'db_kasir'
  }
  conn = mysql.connector.connect(**config)
  print('✅ Database connection OK!')
  conn.close()
  "
  # Expected: ✅ Database connection OK!
  ```

---

## BAGIAN C: TRAINING MODELS (Ajarim AI)

### 1️⃣ Training Menu Recommendation

```bash
# Pastikan di folder ml_engine & venv aktif
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine
source venv/bin/activate

# Run training
python train_menu_recommendation.py

# Tunggu sampai selesai
# Expected output:
# ✅ Model trained successfully with XXX data points
```

**Checklist:**
- [ ] Training berjalan tanpa error
- [ ] File `models/menu_recommendation.pkl` ada (baru atau updated)
- [ ] Data points > 0 (semakin banyak semakin baik)

### 2️⃣ Training Revenue Forecasting

```bash
python train_revenue_forecasting.py

# Tunggu sampai selesai
# Expected: File models/revenue_forecasting.pkl created
```

**Checklist:**
- [ ] Tanpa error
- [ ] File `models/revenue_forecasting.pkl` ada

### 3️⃣ Training Seasonal Pattern

```bash
python train_seasonal_pattern.py

# Tunggu sampai selesai
```

**Checklist:**
- [ ] Tanpa error
- [ ] File `models/seasonal_pattern.pkl` ada

### 4️⃣ Verify All Models Trained

```bash
ls -lh models/

# Expected output:
# menu_recommendation.pkl
# revenue_forecasting.pkl
# seasonal_pattern.pkl
```

**Checklist:**
- [ ] Ketiga file ada
- [ ] File size > 0 (bukan file kosong)

---

## BAGIAN D: API TESTING (Test Flask)

### 1️⃣ Start Flask Server

**Terminal 1:**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine
source venv/bin/activate
python app.py

# Tunggu muncul output seperti:
# * Running on http://127.0.0.1:5000
# ⚠️ JANGAN CLOSE TERMINAL INI!
```

**Checklist:**
- [ ] Server berjalan tanpa error
- [ ] Port 5000 available (tidak ada error "Address already in use")

### 2️⃣ Test API Endpoints

**Terminal 2 (baru):**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine
source venv/bin/activate

# Run comprehensive test
python test_api.py

# Expected: Semua test ✅
```

**Checklist:**
- [ ] Health check: ✅
- [ ] Models status: ✅
- [ ] Menu predictions: ✅
- [ ] Revenue predictions: ✅
- [ ] Seasonal patterns: ✅

### 3️⃣ Manual Test (Optional)

```bash
# Test health check
curl http://127.0.0.1:5000/health

# Expected response:
# {"status":"ok","timestamp":"2026-04-19..."}

# Test models status
curl http://127.0.0.1:5000/models/status

# Expected response:
# {"models":{"menu_recommendation":{"status":"trained"},...}}
```

**Checklist:**
- [ ] Bisa akses semua endpoints
- [ ] Response JSON valid (no error)

---

## BAGIAN E: LARAVEL INTEGRATION (Hubungkan dengan website)

### 1️⃣ Check .env (Laravel)

**File:** Root project `.env`

```env
ML_API_URL=http://127.0.0.1:5000
```

**Checklist:**
- [ ] Sudah ada di file atau tambahkan
- [ ] Value benar (sesuai dengan Flask port)

### 2️⃣ Verify MLController

**File:** `app/Http/Controllers/MLController.php`

```bash
# Check file ada & readable
file app/Http/Controllers/MLController.php

# Expected: readable
```

**Checklist:**
- [ ] File ada
- [ ] Punya method `dashboard()`, `trainMenuRecommendation()`, dll

### 3️⃣ Verify Routes

**File:** `routes/web.php`

Cari atau tambahkan:
```php
Route::get('/ml', [MLController::class, 'dashboard'])->name('ml.dashboard');
```

**Checklist:**
- [ ] Route `/ml` exists
- [ ] Pointing ke MLController

### 4️⃣ Access Dashboard

Pastikan:
1. Flask API berjalan: `python app.py` (Terminal 1)
2. Laravel running: `php artisan serve` (Terminal 2)

Buka browser:
```
http://localhost:8000/ml
```

**Checklist:**
- [ ] Page load tanpa error
- [ ] Bisa melihat ML Dashboard
- [ ] Data prediksi ditampilkan:
  - [ ] Menu recommendations
  - [ ] Revenue forecast
  - [ ] Seasonal patterns
  - [ ] Model status

---

## BAGIAN F: FINAL CHECKS (Verifikasi Final)

### ✅ Complete System Test

```bash
# Scenario: Fresh morning
# 1. Close semua terminal
# 2. Buka semula:
```

**Terminal 1: Start Flask**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine
source venv/bin/activate
python app.py
# Tunggu: Running on http://127.0.0.1:5000
```

**Terminal 2: Start Laravel**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project
php artisan serve
# Tunggu: localhost:8000
```

**Terminal 3: Test**
```bash
# Health check
curl http://127.0.0.1:5000/health
# Expected: {"status":"ok",...}
```

**Browser:**
```
http://localhost:8000/ml
# Expected: Dashboard loaded dengan data
```

**Checklist:**
- [ ] Flask API ✅
- [ ] Laravel ✅
- [ ] API responding ✅
- [ ] Dashboard visible ✅
- [ ] Data terupdate ✅

---

## BAGIAN G: PRODUCTION READINESS

### 📋 Pre-Production

- [ ] Database backup sudah ada
- [ ] 120+ hari data sudah terkumpul
- [ ] Model accuracy sudah test
- [ ] Error handling sudah siap
- [ ] Logs directory writable
- [ ] Monitoring setup (optional)

### 📋 Monitoring

```bash
# Check logs regularly
tail -f ml_engine/logs/ml_engine.log

# Alert jika ada error
```

- [ ] Logs directory: `ml_engine/logs/` accessible
- [ ] Script monitor berjalan (optional)

### 📋 Backup & Recovery

```bash
# Backup models
cp -r ml_engine/models ~/backup/models_$(date +%Y%m%d)

# Backup database
mysqldump -u root db_kasir > ~/backup/db_kasir_$(date +%Y%m%d).sql
```

- [ ] Backup script siap
- [ ] Backup location prepared

---

## BAGIAN H: DAILY OPERATIONS

### 🌅 Setiap Hari (Pagi)

```
Morning checklist:
- [ ] Flask API running? (Terminal)
- [ ] Laravel running? (Terminal)
- [ ] Dashboard accessible? (Browser)
- [ ] Data updated? (Check last trained time)
```

**Command:**
```bash
# Terminal buka
cd /path/to/ml_engine
source venv/bin/activate
python app.py
# Biarkan berjalan
```

### 📅 Setiap Minggu (e.g., Minggu pagi)

```
Weekly checklist:
- [ ] Refresh training? (Optional, rekomendasi weekly)
- [ ] Check accuracy? (Dashboard)
- [ ] Review logs? (Any errors?)
- [ ] Backup models? (If important)
```

**Command:**
```bash
# Training ulang
python train_menu_recommendation.py
python train_revenue_forecasting.py
python train_seasonal_pattern.py
```

### 📆 Setiap Bulan

```
Monthly checklist:
- [ ] Data quality review
- [ ] Model performance analysis
- [ ] Database optimization?
- [ ] Hardware capacity check?
```

---

## BAGIAN I: TROUBLESHOOTING CHECKLIST

### ❌ Error: ModuleNotFoundError

**Quick Fix:**
```bash
source venv/bin/activate
pip install -r requirements.txt
```

**Checklist:**
- [ ] venv aktif? (Lihat prompt)
- [ ] requirements.txt ada?
- [ ] Internet connection OK?

### ❌ Error: Database Connection

**Quick Fix:**
```bash
# Check XAMPP MySQL running
# Start: XAMPP Control Panel → MySQL "Start"

# Verify .env
cat .env
# Check: DB_HOST, DB_USER, DB_PASSWORD

# Test koneksi Python
python3 -c "
import mysql.connector
conn = mysql.connector.connect(
    host='localhost', user='root', password='', 
    database='db_kasir'
)
print('✅ OK')
"
```

**Checklist:**
- [ ] MySQL running? (XAMPP Control Panel)
- [ ] .env config correct?
- [ ] Database `db_kasir` exists?

### ❌ Error: Port 5000 in use

**Quick Fix:**
```bash
# Kill process using port 5000
lsof -i :5000
# Find PID dan kill: kill -9 <PID>

# Or use different port
# Edit app.py: app.run(..., port=5001)
```

**Checklist:**
- [ ] Port 5000 available?
- [ ] Sudah ada process lain?

### ❌ Error: Model not trained

**Quick Fix:**
```bash
python train_menu_recommendation.py
python train_revenue_forecasting.py
python train_seasonal_pattern.py
```

**Checklist:**
- [ ] models/ folder ada?
- [ ] File .pkl ada?
- [ ] Training sudah dijalankan?

---

## BAGIAN J: SUCCESS INDICATORS

✅ **Semuanya berhasil jika:**

- [x] Python 3 installed
- [x] Virtual environment active
- [x] Dependencies installed (pip list)
- [x] Database connected (MySQL running)
- [x] All models trained (.pkl files exist)
- [x] Flask API running (http://127.0.0.1:5000/health ✅)
- [x] Test passed (python test_api.py)
- [x] Laravel dashboard accessible (http://localhost:8000/ml)
- [x] Predictions displayed (menu, revenue, seasonal)
- [x] Logs clean (no critical errors)

**Saat semua ✅, Anda SIAP menggunakan ML! 🎉**

---

## ⚡ QUICK START (Copy-Paste)

Jika sudah setup sebelumnya, setiap hari hanya:

**Terminal 1:**
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine && source venv/bin/activate && python app.py
```

**Browser:**
```
http://localhost:8000/ml
```

**Done!** ✅

---

## 📞 NEED HELP?

1. Re-read: [PENJELASAN_ML_DALAM_BAHASA_SEDERHANA.md](./PENJELASAN_ML_DALAM_BAHASA_SEDERHANA.md)
2. Check: [QUICK_START_ML.md](./QUICK_START_ML.md#-troubleshooting-quick-fix)
3. Debug: [TIPS_DAN_TRICKS_ML.md](./TIPS_DAN_TRICKS_ML.md#-when-things-go-wrong)

---

**Last Updated:** April 2026
**Status:** Production Ready ✅
