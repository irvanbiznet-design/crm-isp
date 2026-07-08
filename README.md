# CRM ISP RT/RW Net & ISP Management System

Website CRM (Customer Relationship Management) berbasis web modern, profesional, responsif untuk bisnis RT/RW Net atau penyedia layanan Internet Rumahan.

## 🚀 Fitur Utama

### Dashboard Realtime
- Total Pelanggan, Pelanggan Aktif, Suspend
- Pendapatan Harian & Bulanan
- Monitoring Perangkat (OLT, MikroTik, ONU)
- Grafik Dinamis (Pendapatan, Pelanggan, Gangguan, Bandwidth)
- Widget realtime PPPoE, Traffic Internet

### CRM Pelanggan
- Data lengkap pelanggan dengan foto & GPS
- Area management (Kota, Kecamatan, Desa, Cluster)
- Integrasi peta Leaflet.js dengan heatmap
- Import/Export Excel & PDF
- Status management (Aktif, Suspend, Non-Aktif)

### Manajemen MikroTik
- Multi-router support dengan API RouterOS
- Monitoring resource (CPU, Memory, Traffic, Ping)
- Sinkronisasi PPPoE, Queue, Address List otomatis
- Status realtime router
- Log viewer

### Manajemen OLT GPON
- Support: Huawei, ZTE, FiberHome, VSOL, C-DATA
- ONU monitoring (Serial, Power, Temperature, Distance)
- Optical power & temperature monitoring
- Alarm management
- Auto discovery ONU

### PPPoE Management
- Buat, edit, hapus, suspend, aktivasi PPPoE
- Auto generate username & password
- Ganti profile & password
- Monitoring online time, last seen, IP/MAC client
- RX/TX monitoring

### Ticketing Gangguan
- Buat tiket dengan foto & lokasi
- Status: Open, Pending, On Progress, Solved, Closed
- Prioritas: Low, Medium, High, Critical
- Assign ke teknisi
- Mobile app untuk teknisi

### Billing & Invoicing
- Generate tagihan otomatis
- Invoice management
- Riwayat pembayaran
- Denda & diskon
- Status: Lunas, Belum Bayar, Jatuh Tempo, Suspend

### Monitoring Perangkat
- Ping, SNMP, API, ICMP monitoring
- Real-time status (Online/Offline)
- Alert ke Telegram, WhatsApp, Email
- Monitoring: MikroTik, OLT, Switch, AP, Server

### Customer Portal
- Login pelanggan
- Lihat tagihan & pembayaran
- Buat tiket gangguan
- Download invoice
- Status PPPoE

### Notifikasi
- WhatsApp Gateway
- Telegram Bot
- Email SMTP
- Auto send: tagihan, invoice, gangguan, pembayaran

### Laporan Lengkap
- Pelanggan, Pembayaran, Pendapatan, Gangguan
- Filter: Tanggal, Area, Teknisi, Router, OLT
- Export PDF & Excel

### API REST
- Full REST API dengan JWT authentication
- Endpoints: Login, Customer, Billing, MikroTik, OLT, Ticket
- API Documentation

## 💻 Teknologi

- **Backend:** Laravel 12, PHP 8.3
- **Database:** MySQL 8.0
- **Frontend:** Tailwind CSS, Alpine.js, Livewire
- **Charts:** Chart.js
- **Maps:** Leaflet.js, OpenStreetMap
- **Icons:** Bootstrap Icons
- **API Integrasi:** MikroTik RouterOS API, SNMP, REST API
- **Deployment:** Docker (optional), Nginx, PHP-FPM
- **Authentication:** Laravel Sanctum, JWT
- **Security:** CSRF Protection, Rate Limit, Audit Log

## 🛠️ Instalasi

### Prerequisites
- Docker & Docker Compose (recommended)
- PHP 8.3+
- MySQL 8.0+
- Composer
- Node.js 18+

### Setup dengan Docker

```bash
# Clone repository
git clone https://github.com/irvanbiznet-design/crm-isp.git
cd crm-isp

# Copy environment file
cp .env.example .env

# Build & run docker
docker-compose up -d

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# Generate app key
docker-compose exec app php artisan key:generate

# Run migrations & seeders
docker-compose exec app php artisan migrate --seed

# Build assets
docker-compose exec app npm run build
```

### Setup Manual

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Build assets
npm run build

# Start server
php artisan serve
```

## 📁 Struktur Direktori

```
crm-isp/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Repositories/
│   ├── Services/
│   ├── Events/
│   ├── Jobs/
│   └── Notifications/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   ├── js/
│   ├── css/
│   └── lang/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── admin.php
├── storage/
├── tests/
├── config/
├── docker/
│   ├── Dockerfile
│   └── nginx.conf
├── docker-compose.yml
├── .env.example
└── README.md
```

## 🔐 Keamanan

- Laravel Sanctum untuk autentikasi API
- CSRF Protection pada semua form
- Rate Limiting
- Audit Log untuk semua aktivitas
- Enkripsi password
- Two Factor Authentication (2FA)
- Backup database otomatis

## 👥 Role & Permission

- **Super Admin** - Full access
- **Admin** - Manage users, settings, reports
- **Finance** - Billing, invoicing, pembayaran
- **Teknisi** - Ticket, maintenance, monitoring
- **Customer Service** - Customer management, support
- **Operator NOC** - Network monitoring
- **Pelanggan** - Customer portal

## 📊 Laporan

Tersedia laporan lengkap:
- Pelanggan (aktif, suspend, baru)
- Pembayaran & pendapatan
- Gangguan & resolusi
- Teknisi & performa
- Infrastructure (Router, OLT, ONU, PPPoE)
- Area coverage analysis

## 🚀 Deploy

### Nginx + PHP-FPM + MySQL

```bash
# Upload ke server Ubuntu
scp -r crm-isp/ user@server:/home/user/

# SSH ke server
ssh user@server

# Setup Nginx
sudo cp docker/nginx.conf /etc/nginx/sites-available/crm-isp
sudo ln -s /etc/nginx/sites-available/crm-isp /etc/nginx/sites-enabled/
sudo systemctl reload nginx

# Setup PHP-FPM
sudo systemctl restart php8.3-fpm

# Setup database
mysql -u root -p < database/dump.sql

# Install dependencies
composer install --optimize-autoloader --no-dev
npm run build

# Setup permissions
sudo chown -R www-data:www-data /home/user/crm-isp/storage
sudo chmod -R 775 /home/user/crm-isp/storage

# Generate app key & run migrations
php artisan key:generate
php artisan migrate --force
```

### Docker Deployment

```bash
docker-compose -f docker-compose.prod.yml up -d
```

## 📚 API Documentation

API documentation tersedia di `/api/docs`

### Authentication
```bash
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

Response:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": {...}
}
```

### Example Endpoints

```bash
# Customers
GET /api/customers
POST /api/customers
GET /api/customers/{id}
PUT /api/customers/{id}
DELETE /api/customers/{id}

# Billing
GET /api/billing/invoices
GET /api/billing/invoices/{id}
POST /api/billing/payments
GET /api/billing/payments/{id}

# Tickets
GET /api/tickets
POST /api/tickets
GET /api/tickets/{id}
PUT /api/tickets/{id}

# Dashboard
GET /api/dashboard/summary
GET /api/dashboard/revenue
GET /api/dashboard/devices
```

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run tests dengan coverage
php artisan test --coverage

# Run specific test
php artisan test tests/Unit/CalculationTest.php
```

## 📝 Changelog

Lihat [CHANGELOG.md](CHANGELOG.md) untuk history perubahan.

## 📄 Lisensi

Proprietary License. Semua hak cipta dilindungi.

## 👨‍💻 Author

Created for ISP RT/RW Net Management Solutions

## 📞 Support

Untuk support & consultation:
- Email: support@example.com
- Telegram: @irvanbiznet
- WhatsApp: +62xxx

---

**Last Updated:** 2026-07-08
