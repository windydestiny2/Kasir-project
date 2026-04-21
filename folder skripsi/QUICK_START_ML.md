# 🚀 QUICK START GUIDE - ML KASIR

**Panduan Cepat Menjalankan Machine Learning**

---

## 📋 CHECKLIST PERTAMA KALI SETUP

- [ ] Python 3.8+ sudah installed (`python3 --version`)
- [ ] XAMPP / MySQL sudah running
- [ ] Laravel bisa diakses di `http://localhost:8000`
- [ ] Folder `ml_engine/` ada di project

---

## ⚡ SETUP PERTAMA KALI (Copy-Paste)

**Terminal 1: Instalasi & Training**

```bash
# 1. Masuk folder ML
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine

# 2. Buat virtual environment (jangan ulang jika sudah ada)
python3 -m venv venv

# 3. Aktifkan (WAJIB setiap membuka terminal baru)
source venv/bin/activate

# 4. Install semua library (cukup 1x)
pip install -r requirements.txt

# 5. Cek file .env sudah benar
cat .env
# Seharusnya ada:
# DB_HOST=localhost
# DB_USER=root
# DB_PASSWORD=
# DB_NAME=db_kasir
# DB_PORT=3306

# 6. Training semua model (tunggu hingga selesai ✅)
python train_menu_recommendation.py
python train_revenue_forecasting.py
python train_seasonal_pattern.py
```

---

## 🔄 MENJALANKAN SETIAP HARI

### Opsi A: MANUAL (Recommended untuk awal)

**Terminal 1: Flask API**
```bash
# 1. Buka folder ML
cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine

# 2. Aktifkan virtual environment
source venv/bin/activate

# 3. Jalankan Flask API (Ctrl+C untuk stop)
python app.py

# Tunggu muncul: Running on http://127.0.0.1:5000
# Jangan close terminal ini!
```

**Terminal 2: Akses Dashboard**
```bash
# Buka browser dan pergi ke:
http://localhost:8000/ml

# Atau jika pakai port berbeda:
http://localhost:YOUR_PORT/ml
```

---

### Opsi B: OTOMATIS (Advanced)

Buat CRON job untuk training otomatis setiap malam:

```bash
# Edit crontab
crontab -e

# Tambahkan baris ini (menjalankan training setiap hari jam 23:00)
0 23 * * * cd /Applications/XAMPP/xamppfiles/htdocs/Kasir-project/ml_engine && source venv/bin/activate && python train_menu_recommendation.py > /tmp/ml_train.log 2>&1
```

---

## 🧪 TESTING (Verifikasi Semuanya Jalan)

```bash
# Terminal 2: Di folder ml_engine dengan venv aktif
python test_api.py

# Seharusnya output:
# 🩺 Testing Health Check...
# ✅ Health check passed
# 
# 📊 Testing Models Status...
# ✅ Models status retrieved
# 
# 🎯 Testing Menu Predictions...
# ✅ Menu predictions successful
# 
# Dst...
```

Jika semua `✅`, berarti baik!

---

## 🔥 COMMAND-COMMAND PENTING

| Command | Fungsi |
|---------|--------|
| `source venv/bin/activate` | Aktifkan virtual environment |
| `deactivate` | Keluar dari virtual environment |
| `python app.py` | Jalankan Flask API |
| `python test_api.py` | Test API endpoints |
| `python train_menu_recommendation.py` | Refresh training menu |
| `python train_revenue_forecasting.py` | Refresh training revenue |
| `python train_seasonal_pattern.py` | Refresh training seasonal |
| `pip install -r requirements.txt` | Install/update packages |
| `ls models/` | Lihat model apa saja |
| `rm models/*.pkl` | Hapus semua model (untuk fresh start) |

---

## 📊 LOGS & DEBUGGING

**Tempat logs disimpan:**
```
ml_engine/logs/ml_engine.log
```

**Buka dengan:**
```bash
tail -f ml_engine/logs/ml_engine.log
```

**Untuk clear logs:**
```bash
echo "" > ml_engine/logs/ml_engine.log
```

---

## 🔗 TESTING API MANUAL (cURL atau Browser)

**Health Check** (Cek apakah API hidup):
```bash
curl http://127.0.0.1:5000/health
```

**Menu Recommendations:**
```bash
curl http://127.0.0.1:5000/predict/menu-recommendations
```

**Revenue Forecast:**
```bash
curl http://127.0.0.1:5000/predict/revenue
```

**Model Status:**
```bash
curl http://127.0.0.1:5000/models/status
```

---

## ❌ TROUBLESHOOTING QUICK FIX

| Error | Solusi |
|-------|--------|
| `ModuleNotFoundError` | `source venv/bin/activate` + `pip install -r requirements.txt` |
| `Connection refused :3306` | Pastikan MySQL running di XAMPP |
| `Connection refused :5000` | Jalankan `python app.py` di terminal lain |
| `Model not trained yet` | Jalankan `python train_menu_recommendation.py` |
| `database db_kasir doesn't exist` | Buat database di phpMyAdmin |
| `AccessDenied for user 'root'` | Cek password di file `.env` |

---

## 📱 HAPUS FOLDER YANG TIDAK PERLU

Folder `__pycache__` bisa dihapus (akan recreate otomatis):

```bash
rm -rf ml_engine/__pycache__
```

---

## 🎯 RINGKASAN WORKFLOW

```
1. Terminal buka: source venv/bin/activate + python app.py
2. Browser buka: http://localhost:8000/ml
3. Lihat dashboard dengan rekomendasi menu & forecast
4. Setiap minggu: jalankan python train_*.py untuk refresh
5. Done! 🎉
```

---

**Pertanyaan sering?** Lihat file `PENJELASAN_ML_DALAM_BAHASA_SEDERHANA.md`
