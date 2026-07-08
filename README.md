# CRM ISP - Customer Relationship Management untuk ISP

Aplikasi CRM (Customer Relationship Management) yang komprehensif untuk mengelola pelanggan Internet Service Provider (ISP).

## Fitur Utama

### 1. Manajemen Pelanggan
- Pendaftaran pelanggan baru
- Profil pelanggan lengkap
- Status pelanggan (aktif, suspend, tidak aktif)
- Pencarian dan filter pelanggan
- Riwayat pelanggan

### 2. Manajemen Invoice
- Pembuatan invoice otomatis
- Tracking pembayaran
- Laporan keuangan
- Invoice tertunggak
- Riwayat transaksi

### 3. Manajemen Tiket/Ticketing
- Pembuatan tiket dukungan
- Prioritas tiket (low, medium, high, critical)
- Penugasan tiket ke teknisi
- Tracking status tiket
- Riwayat tiket

### 4. Dashboard
- Statistik real-time
- Grafik dan visualisasi data
- Summary informasi penting

## Teknologi

### Backend
- **Framework**: Laravel 10
- **Database**: MySQL 8.0
- **API**: RESTful API
- **Authentication**: JWT (JSON Web Token)
- **ORM**: Eloquent

### Frontend
- **Framework**: Vue.js 3
- **UI Library**: Element Plus
- **State Management**: Vuex
- **HTTP Client**: Axios
- **Charts**: ECharts

### DevOps
- **Containerization**: Docker
- **Orchestration**: Docker Compose
- **Web Server**: Nginx
- **PHP Runtime**: PHP 8.1-FPM

## Struktur Proyek

```
crm-isp/
├── app/
│   ├── Models/              # Eloquent Models
│   ├── Repositories/        # Data Access Layer
│   ├── Services/            # Business Logic
│   ├── Http/
│   │   ├── Controllers/     # API Controllers
│   │   ├── Requests/        # Form Validation
│   │   ├── Resources/       # API Resources
│   │   └── Middleware/      # Middleware
│   └── ...
├── database/
│   ├── migrations/          # Database Migrations
│   ├── seeders/             # Database Seeders
│   └── factories/           # Model Factories
├── routes/
│   ├── api.php              # API Routes
│   └── web.php              # Web Routes
├── tests/
│   └── Unit/                # Unit Tests
├── frontend/
│   ├── src/
│   │   ├── components/      # Vue Components
│   │   ├── views/           # Page Components
│   │   ├── router/          # Vue Router
│   │   ├── store/           # Vuex Store
│   │   └── styles/          # Global Styles
│   └── package.json
├── docker-compose.yml       # Docker Compose Configuration
├── Dockerfile               # Docker Image
└── nginx.conf               # Nginx Configuration
```

## Instalasi

### Prerequisites
- Docker & Docker Compose
- Git

### Setup dengan Docker

1. Clone repository
```bash
git clone https://github.com/irvanbiznet-design/crm-isp.git
cd crm-isp
```

2. Copy environment file
```bash
cp .env.example .env
```

3. Start Docker containers
```bash
docker-compose up -d
```

4. Install dependencies
```bash
docker-compose exec app composer install
docker-compose exec frontend npm install
```

5. Generate application key
```bash
docker-compose exec app php artisan key:generate
```

6. Generate JWT secret
```bash
docker-compose exec app php artisan jwt:secret
```

7. Run migrations
```bash
docker-compose exec app php artisan migrate
```

8. Seed database
```bash
docker-compose exec app php artisan db:seed
```

### Akses Aplikasi
- Backend API: http://localhost:8000/api
- Frontend: http://localhost:8080

## API Endpoints

### Authentication
- `POST /api/register` - Daftar pengguna baru
- `POST /api/login` - Login pengguna
- `POST /api/logout` - Logout pengguna (require auth)
- `GET /api/me` - Get current user (require auth)
- `POST /api/refresh` - Refresh token (require auth)

### Customers
- `GET /api/customers` - Daftar pelanggan
- `POST /api/customers` - Tambah pelanggan
- `GET /api/customers/{id}` - Detail pelanggan
- `PUT /api/customers/{id}` - Update pelanggan
- `DELETE /api/customers/{id}` - Hapus pelanggan
- `GET /api/customers/search/query?q={query}` - Cari pelanggan

### Invoices
- `GET /api/invoices` - Daftar invoice
- `POST /api/invoices` - Buat invoice
- `GET /api/invoices/{id}` - Detail invoice
- `PUT /api/invoices/{id}` - Update invoice
- `DELETE /api/invoices/{id}` - Hapus invoice
- `GET /api/invoices/unpaid/list` - Invoice belum dibayar

### Tickets
- `GET /api/tickets` - Daftar tiket
- `POST /api/tickets` - Buat tiket
- `GET /api/tickets/{id}` - Detail tiket
- `PUT /api/tickets/{id}` - Update tiket
- `DELETE /api/tickets/{id}` - Hapus tiket
- `GET /api/tickets/open/list` - Tiket terbuka
- `GET /api/tickets/search/query?q={query}` - Cari tiket

## Testing

### Run Unit Tests
```bash
docker-compose exec app ./vendor/bin/phpunit
```

### Run Specific Test
```bash
docker-compose exec app ./vendor/bin/phpunit tests/Unit/Services/CustomerServiceTest.php
```

## Development

### Backend Development
```bash
# SSH ke container app
docker-compose exec app bash

# Run artisan commands
php artisan make:model YourModel -m
php artisan migrate
php artisan tinker
```

### Frontend Development
```bash
# SSH ke container frontend
docker-compose exec frontend bash

# Install dependencies
npm install

# Run development server
npm run serve

# Build for production
npm run build
```

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255),
    role ENUM('super_admin', 'admin', 'teknisi', 'finance', 'customer_service'),
    is_active BOOLEAN,
    last_login_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Customers Table
```sql
CREATE TABLE customers (
    id BIGINT PRIMARY KEY,
    customer_number VARCHAR(50) UNIQUE,
    name VARCHAR(255),
    nik VARCHAR(16),
    phone VARCHAR(15),
    email VARCHAR(255),
    address TEXT,
    latitude DECIMAL,
    longitude DECIMAL,
    area_id BIGINT,
    package_id BIGINT,
    status ENUM('active', 'suspend', 'inactive'),
    subscription_date DATE,
    due_date DATE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Invoices Table
```sql
CREATE TABLE invoices (
    id BIGINT PRIMARY KEY,
    invoice_number VARCHAR(50) UNIQUE,
    customer_id BIGINT,
    invoice_date DATE,
    due_date DATE,
    amount DECIMAL,
    tax DECIMAL,
    discount DECIMAL,
    total DECIMAL,
    status ENUM('unpaid', 'paid', 'overdue', 'partial'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tickets Table
```sql
CREATE TABLE tickets (
    id BIGINT PRIMARY KEY,
    ticket_number VARCHAR(50) UNIQUE,
    customer_id BIGINT,
    title VARCHAR(255),
    description TEXT,
    status ENUM('open', 'pending', 'on_progress', 'solved', 'closed'),
    priority ENUM('low', 'medium', 'high', 'critical'),
    assigned_to BIGINT,
    resolved_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## Troubleshooting

### Port Already in Use
Jika port 8000 atau 8080 sudah digunakan, ubah port di `docker-compose.yml`:
```yaml
ports:
  - "8001:80"  # Backend
  - "8081:8080" # Frontend
```

### Database Connection Error
Pastikan container database sudah berjalan:
```bash
docker-compose logs db
```

### Migration Error
Cek apakah .env sudah ter-generate:
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

## Contributing

1. Fork repository
2. Buat branch feature (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## License

MIT License - lihat file LICENSE untuk detail.

## Support

Untuk pertanyaan atau dukungan, hubungi:
- Email: support@crm-isp.com
- Issues: https://github.com/irvanbiznet-design/crm-isp/issues

## Changelog

### v1.0.0 (2024)
- Initial release
- Manajemen pelanggan
- Manajemen invoice
- Manajemen tiket
- Dashboard
- API RESTful dengan JWT
- Frontend Vue.js
- Docker setup
