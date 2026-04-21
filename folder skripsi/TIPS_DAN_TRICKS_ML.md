# 💡 TIPS & TRICKS MACHINE LEARNING KASIR

---

## 🎯 TIPS MENGOPTIMALKAN MODEL ML

### 1️⃣ DATA QUALITY = EVERYTHING

**Input yang baik = Model yang akurat**

```
Jangan:
❌ Simpan transaksi test/dummy di database
❌ Hapus data lama (butuh untuk training)
❌ Simpan transaksi dengan harga 0 / salah

Lakukan:
✅ Pastikan setiap transaksi real & akurat
✅ Jangan hapus data (120 hari minimum)
✅ Koreksi transaksi salah, jangan dihapus
```

---

### 2️⃣ BERAPA LAMA MODEL PERLU TRAINED?

| Ukuran Data | Akurasi | Training Time |
|-------------|---------|---------------|
| < 30 hari | Rendah (50-60%) | < 5 detik |
| 30-60 hari | Sedang (70-80%) | 5-10 detik |
| 60-120 hari | Tinggi (85-95%) | 10-20 detik |
| 120+ hari | Sangat tinggi (95%+) | 20-40 detik |

**Tips:** Biarkan sistem berjalan 4 bulan sebelum menggunakan ML secara serius.

---

### 3️⃣ KAPAN HARUS REFRESH MODEL?

```
Setiap hari?
❌ Overkill (data terlalu sedikit berubah)
⚠️ Lambat (server busy)

Setiap minggu?
✅ RECOMMENDED
✅ Cukup data baru untuk akurat
✅ Performa server baik

Setiap bulan?
✅ Bisa juga (untuk data besar)
⚠️ Tapi kurang responsif dengan tren terbaru

Kapan harus segera refresh?
🔥 Ada event/promo besar
🔥 Harga produk berubah drastis
🔥 Menu/topping baru ditambah
🔥 Tren musiman berubah
```

---

### 4️⃣ INTERPRETASI HASIL MODEL

#### Menu Recommendation

```json
{
    "menu_name": "Kopi Hitam",
    "popularity_score": 85.5,
    "order_count": 250,
    "total_qty": 350,
    "percent": 42.3,
    "avg_price": 18000
}
```

**Penjelasan:**
- `popularity_score`: Semakin tinggi = semakin populer (0-100)
- `order_count`: Berapa transaksi (pembeli) memesan menu ini
- `total_qty`: Total item (misal 1 transaksi beli 2 item = qty 2)
- `percent`: 42.3% dari total pesanan hari/minggu ini
- `avg_price`: Harga rata-rata per item

**Gunakan untuk:**
```
Jika score > 80 dan percent > 40%:
→ Ini TOP MENU, perlu stok banyak

Jika score 60-80:
→ Stok biasa, tapi tetap monitor

Jika score < 60:
→ Menu optional, prepare less
```

---

#### Revenue Forecast

```json
{
    "predicted_revenue": 3050000,
    "confidence_interval": {
        "lower": 2850000,
        "upper": 3250000
    },
    "trend": "stable",
    "growth_rate": 0.02
}
```

**Penjelasan:**
- `predicted_revenue`: Estimasi uang besok
- `confidence_interval`: Range (kemungkinan uang berada di sini 95%)
  - `lower`: Terburuk bisa -
  - `upper`: Terbaik bisa +

**Gunakan untuk:**
```
Jika prediction > budget_target:
→ On track! Fokus maintain quality

Jika prediction < budget_target:
→ Warning! Cek ada issue apa

Jika range (upper - lower) besar:
→ Data masih volatile, tunggu lebih data

Jika trend = "decline":
→ Revenue menurun, perlu action
```

---

### 5️⃣ BASELINE (Perbandingan)

**Jangan percaya ML jika tidak punya baseline:**

```python
# Bandingkan dengan simple average
7 hari lalu   : Rp 3.100.000
14 hari lalu  : Rp 2.900.000
30 hari lalu  : Rp 3.050.000
Rata-rata     : Rp 3.016.667

ML prediksi   : Rp 3.050.000
Selisih       : -Rp 33.333 (-1%) ← OK, reasonable

ML prediksi   : Rp 5.000.000
Selisih       : +Rp 1.983.333 (+66%) ← SUSPICIOUS!
                (Cek ada event khusus atau error data)
```

---

## 🚀 PERFORMANCE TUNING

### Optimization 1: Database Index

Jika training lambat (> 30 detik), tambahkan index:

```sql
ALTER TABLE orders ADD INDEX idx_created_at (created_at);
ALTER TABLE order_items ADD INDEX idx_order_id (order_id);
ALTER TABLE order_items ADD INDEX idx_product_id (product_id);
```

---

### Optimization 2: Limit Data Points

Jika 120 hari terlalu berat, ubah di `app.py`:

```python
# Sekarang: 120 hari
WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 120 DAY)

# Ubah ke: 60 hari (lebih cepat tapi kurang akurat)
WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)

# Atau: 90 hari (middle ground)
WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)
```

---

### Optimization 3: Caching

Hasil prediksi bisa di-cache agar tidak query API setiap request:

```php
// Di Laravel, di MLController.php
$predictions = Cache::remember('menu_predictions', 3600, function () {
    return $this->callMlApi('GET', '/predict/menu-recommendations');
});
```

Cache 1 jam (3600 detik) = lebih cepat, API tidak overload.

---

## 🔍 MONITORING & ALERTS

### Setup Basic Monitoring

**File: `ml_engine/monitor.py` (Ciptakan baru)**

```python
import requests
from datetime import datetime

BASE_URL = "http://127.0.0.1:5000"

def check_health():
    try:
        response = requests.get(f"{BASE_URL}/health", timeout=5)
        if response.status_code == 200:
            print(f"✅ {datetime.now().strftime('%H:%M:%S')} - API OK")
            return True
        else:
            print(f"⚠️ {datetime.now().strftime('%H:%M:%S')} - API Error: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ {datetime.now().strftime('%H:%M:%S')} - API Down: {str(e)}")
        return False

if __name__ == "__main__":
    while True:
        check_health()
        time.sleep(300)  # Check setiap 5 menit
```

**Jalankan:**
```bash
python monitor.py
```

---

### Alert Setup (via Email/Discord)

Jika mau notifikasi ketika ada masalah:

```python
import smtplib

def send_alert(message):
    # Kirim email ke admin
    # Atau push ke Discord webhook
    # Atau SMS via Twilio
    pass

# Di monitor.py:
if not check_health():
    send_alert("⚠️ ML API DOWN!")
```

---

## 📊 ANALISIS MODEL PERFORMANCE

### Script: Check Model Accuracy

```python
# File: ml_engine/check_accuracy.py

from app import MLService
import pandas as pd

ml = MLService()
df = ml.get_training_data()

# Ambil data minggu ini
this_week = df[df['day_of_week'] == datetime.now().weekday() + 1]

# Ambil top 3 menu dari model
recommendations = ml.predict_menu_recommendations()['recommendations']

print("Prediksi ML untuk hari ini:")
for i, rec in enumerate(recommendations, 1):
    print(f"{i}. {rec['menu_name']} (Score: {rec['popularity_score']:.2f})")

print(f"\nActual data minggu lalu ({len(this_week)} transaksi):")
actual_top = this_week.groupby('menu_name')['order_id'].count().nlargest(3)
for i, (menu, count) in enumerate(actual_top.items(), 1):
    print(f"{i}. {menu} ({count} orders)")

# Hitung accuracy
predicted_menus = [r['menu_name'] for r in recommendations]
actual_menus = actual_top.index.tolist()
matches = len(set(predicted_menus) & set(actual_menus))
accuracy = (matches / 3) * 100
print(f"\nAccuracy: {accuracy:.0f}%")
```

**Jalankan:**
```bash
python check_accuracy.py
```

---

## 🎲 DEBUGGING TIPS

### Tip 1: Enable SQL Logging

Edit `app.py`, ubah logging level:

```python
import logging
logging.basicConfig(
    filename='logs/ml_engine.log',
    level=logging.DEBUG,  # ← Ubah dari INFO ke DEBUG
    format='%(asctime)s - %(levelname)s - %(message)s'
)
```

Sekarang semua query akan tercatat di log.

---

### Tip 2: Export Data untuk Analysis

```python
# Di app.py, tambahkan endpoint

@app.route('/export/training-data', methods=['GET'])
def export_training_data():
    """Export training data sebagai CSV"""
    df = ml_service.get_training_data()
    df.to_csv('exported_data.csv', index=False)
    return {"status": "success", "rows": len(df), "file": "exported_data.csv"}
```

Jalankan:
```bash
curl http://127.0.0.1:5000/export/training-data
```

Kemudian buka `exported_data.csv` di Excel untuk analisis manual.

---

### Tip 3: Simple Statistics

```python
# File: ml_engine/stats.py

from app import MLService
import pandas as pd

ml = MLService()
df = ml.get_training_data()

print("=== STATISTICS ===")
print(f"Total orders: {len(df)}")
print(f"Date range: {df['order_date'].min()} to {df['order_date'].max()}")
print(f"Total revenue: Rp {df['total'].sum():,}")
print(f"Average order: Rp {df['total'].mean():,.0f}")
print(f"\nTop 10 menus:")
print(df.groupby('menu_name')['qty'].sum().nlargest(10))
```

---

## ⚙️ PRODUCTION SETTINGS

### Setup untuk Production (Bukan di localhost)

1. **Edit `app.py`:**
```python
if __name__ == "__main__":
    # Development (localhost hanya)
    app.run(host='127.0.0.1', port=5000, debug=True)
    
    # Production (bisa diakses dari mesin lain)
    # app.run(host='0.0.0.0', port=5000, debug=False)
```

2. **Gunakan Gunicorn (lebih stabil dari Flask dev server):**
```bash
pip install gunicorn

# Jalankan:
gunicorn -w 4 -b 0.0.0.0:5000 app:app

# Flags:
# -w 4 = 4 worker threads (ganti sesuai CPU cores)
# -b 0.0.0.0:5000 = bind to all IPs, port 5000
# app:app = nama file dan variable Flask app
```

3. **Update Laravel .env:**
```env
ML_API_URL=http://YOUR_SERVER_IP:5000
```

---

## 🆘 WHEN THINGS GO WRONG

**Jika model hasil sangat buruk:**

1. **Cek data valid:**
   ```bash
   python check_accuracy.py
   ```

2. **Cek ada transaksi test/dummy:**
   ```sql
   SELECT * FROM orders WHERE total = 0 OR total < 1000;
   ```

3. **Cek date range Data:**
   ```sql
   SELECT MIN(created_at), MAX(created_at), COUNT(*) FROM orders;
   ```

4. **Reset dan training ulang:**
   ```bash
   rm -rf models/*
   python train_menu_recommendation.py
   python train_revenue_forecasting.py
   ```

5. **Jika masih jelek, tunggu lebih data:**
   - Biarkan sistem berjalan 4 bulan
   - ML butuh volume data untuk akurat

---

## 📱 CHECKLIST PRODUCTION

- [ ] Database sudah backup
- [ ] Virtual environment sudah setup
- [ ] 120+ hari data sudah ada
- [ ] Model sudah trained
- [ ] API bisa diakses
- [ ] Laravel bisa connect ke API
- [ ] Dashboard bisa menampilkan hasil
- [ ] Logs setup untuk monitoring
- [ ] CRON job sudah setup untuk auto-training
- [ ] Error handling jika API down

---

**Semoga helpful! 🚀**
