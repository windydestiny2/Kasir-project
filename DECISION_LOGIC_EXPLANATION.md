# Logika 3 Decision Making Cards - Kasir Project ML Dashboard

## Overview
3 kartu **Pengambilan Keputusan** di dashboard menggunakan **ML predictions + business rules** untuk memberikan rekomendasi actionable untuk Kedai Sugoiiyaki.

## 1. Pengambilan Keputusan - Menu (Ungu)
**Data Source**: ML API `/insights/menu-recommendations` → `ml_engine/decision_support.py.get_menu_insights()`

**Logika Backend** (`decision_support.py`):
- **Top Menu Analysis**: 3 menu terpopuler berdasarkan `popularity_score`.
- **Co-purchase Patterns**: Menu yang sering dibeli bersama.
- **Stock Planning**: Hitung `expected_qty = order_count * multiplier` (high pop = +50%).
- **Bundle Recs**: Primary + secondary menu sebagai paket hemat.

**Prioritas & Actions**:
```
HIGH: 
- Utamakan promosi top menu
- Bundling top 2 menu  
- Persiapan bahan baku (BANYAK/NORMAL/STANDAR)
```

## 2. Pengambilan Keputusan - Pendapatan (Kuning) 
**Data Source**: ML API `/insights/revenue` → `get_revenue_insights()`

**Logika Backend**:
- **Performance**: `(predicted - avg_historical)/avg * 100%`
- **Staffing**: `staff = round(predicted / 200k)` (1 staff ~ Rp200k revenue).
- **Confidence**: 95% CI range.
- **Trend Comparison**: Vs historical averages.

**Prioritas & Actions** (contoh dari screenshot Anda):
```
HIGH: Analisis Performa Pendapatan
- Prediksi Rp320k vs avg Rp316k (+1.4%)
HIGH: Rekomendasi Staff  
- Pertahankan 2 orang
MEDIUM: Optimasi Biaya
- Maintain status quo
```

## 3. Pengambilan Keputusan - Operasional & Tren (Biru) 
**Data Source**: Client-side PHP dari `$seasonalPatterns` (no API needed)

**Logika Client-side** (blade @php):
```
$trend_pct = seasonalPatterns.trend_analysis.trend_percentage
$peak_hours = today_analysis.peak_hours
$expected_orders = today_analysis.expected_orders

if ($trend_pct > 15) HIGH "Tren Naik Kuat"
  → Tambah staff, stok extra, promo peak hours
elseif ($trend_pct < -15) HIGH "Tren Menurun" 
  → Kurangi staff, high-margin focus
else MEDIUM "Tren Stabil" 
  → Fokus peak hours: 18:00, 19:00

if ($expected_orders > 60) MEDIUM "Volume Tinggi"
  → Double-check inventory
```

**Contoh Output**:
```
HIGH: Tren Naik Kuat (16.2%)
"Tren penjualan naik 16%. Maksimalkan opportunity!"
Tindakan:
• Tambah 1 staff untuk peak hours 18:00, 19:00
• Stok extra 20% menu populer

MEDIUM: Volume Tinggi: 75 Orders
"Volume > rata-rata. Siapkan operasional ekstra."
```

## Arsitektur Umum
```
Livewire PHP ← HTTP → Flask ML API (5003)
           ↓
     $data properties
           ↓
    Blade Template
    @if success → @foreach insights → Render cards
```

## Prioritas System
- **HIGH**: Immediate action needed (±15% trend, staffing changes)
- **MEDIUM**: Monitor/prepare (stable trends, peak prep)

**Dashboard Flow**:
1. Load ML data → Generate insights (API/client-side)
2. Render cards with priority badges/actions
3. "Refresh Data" → Update real-time

Perfect balance ML predictions + restaurant business logic! 🍜📈
