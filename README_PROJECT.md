# Panduan Menjalankan ML Dashboard Project

## 📋 Prerequisites
- **XAMPP** (untuk MySQL database)
- **PHP 8.2+** dengan Composer
- **Python 3.8+** dengan pip
- **Git** (untuk clone repository)

## 🚀 Langkah Startup Lengkap

### 1. **Persiapan Database**
```bash
# Jalankan XAMPP Control Panel
# Start Apache & MySQL services
```

### 2. **Clone & Setup Project**
```bash
# Clone repository
git clone <your-repo-url>
cd Kasir-project

# Install PHP dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_kasir
DB_USERNAME=root
DB_PASSWORD=

# Migrate database
php artisan migrate

# Seed data (opsional)
php artisan db:seed
```

### 3. **Setup Python ML Engine**
```bash
# Masuk ke folder ML engine
cd ml_engine

# Install Python dependencies
pip install flask flask-cors mysql-connector-python pandas numpy scikit-learn joblib python-dotenv

# Atau install dari requirements.txt jika ada
pip install -r requirements.txt
```

### 4. **Jalankan Services**

#### Terminal 1: Laravel Web Server
```bash
# Dari root project directory
php artisan serve --host=127.0.0.1 --port=8000
```
✅ **Akses**: http://127.0.0.1:8000

#### Terminal 2: Flask ML API
```bash
# Dari root project directory
cd ml_engine

# Jalankan ML API (default port 5003)
python app.py
```
✅ **API Health Check**: http://127.0.0.1:5003/health

### 5. **Training Models (Pertama Kali)**
Buka browser ke: http://127.0.0.1:8000/ml/dashboard

Klik tombol training untuk setiap model:
- 🔵 Train Menu Recommendation
- 🟢 Train Revenue Forecasting
- 🔵 Train Seasonal Pattern

## 📊 Struktur Project

```
Kasir-project/
├── app/                    # Laravel application
├── ml_engine/             # Python Flask ML API
│   ├── app.py            # Main Flask application
│   ├── models/           # Trained ML models
│   └── logs/             # ML engine logs
├── public/               # Static assets
├── resources/views/      # Blade templates
├── routes/               # Laravel routes
├── database/             # Migrations & seeders
└── vendor/               # Composer dependencies
```

## 🔧 Troubleshooting

### Error: "Address already in use"
```bash
# Kill existing processes
pkill -f "php artisan serve"
pkill -f "python.*app.py"

# Check port usage
lsof -i :8000  # Laravel port
lsof -i :5003  # Flask port
```

### Error: "Connection refused" ke ML API
- Pastikan Flask API running di port 5003
- Check firewall/antivirus
- Verify Python dependencies terinstall

### Error: Database connection failed
- Pastikan XAMPP MySQL running
- Check .env database credentials
- Run: `php artisan migrate` jika perlu

### Models tidak muncul setelah training
- Check Flask logs di `ml_engine/logs/`
- Pastikan database memiliki data order
- Verify model files tersimpan di `ml_engine/models/`

## 🎯 Quick Start Commands

```bash
# Terminal 1 - Laravel
cd /path/to/Kasir-project
php artisan serve --host=127.0.0.1 --port=8000

# Terminal 2 - Flask ML API
cd /path/to/Kasir-project/ml_engine
python -c "from app import app; app.run(host='127.0.0.1', port=5003, debug=True)"

# Browser
open http://127.0.0.1:8000/ml/dashboard
```

## 📝 Catatan Penting

1. **Selalu jalankan XAMPP MySQL** sebelum start aplikasi
2. **Port 5003** untuk Flask API (jangan gunakan port lain)
3. **Training models** hanya perlu dilakukan sekali, atau ketika ada data baru
4. **Auto-refresh** bisa dinonaktifkan di dashboard jika tidak diinginkan
5. **Logs** tersedia di `ml_engine/logs/ml_engine.log` untuk debugging

## 🔄 Update Project

```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer install
pip install -r ml_engine/requirements.txt

# Migrate database jika ada perubahan
php artisan migrate
```

---

**🎉 Project siap digunakan!**

Dashboard ML akan menampilkan:
- ✅ Menu Recommendations
- ✅ Revenue Prediction
- ✅ Seasonal Patterns Analysis
- ✅ Model Training Status