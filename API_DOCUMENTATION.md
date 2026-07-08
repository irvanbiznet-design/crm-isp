# API Documentation

## Ringkasan

Dokumentasi lengkap untuk CRM ISP REST API. API ini menggunakan JSON untuk request dan response, serta JWT untuk authentication.

## Base URL

```
http://localhost:8000/api
```

## Authentication

Semua endpoint (kecuali `/register` dan `/login`) memerlukan JWT token di header:

```
Authorization: Bearer {token}
```

## Response Format

Semua response menggunakan format JSON:

```json
{
  "message": "Success message",
  "data": {
    // Response data
  }
}
```

## Error Handling

```json
{
  "error": "Error message",
  "message": "Detailed error message"
}
```

## HTTP Status Codes

- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `404` - Not Found
- `422` - Unprocessable Entity
- `500` - Server Error

---

## Authentication Endpoints

### Register

**POST** `/register`

Daftarkan pengguna baru.

#### Request Body

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "081234567890",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Response

```json
{
  "message": "User berhasil didaftarkan",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "081234567890"
  }
}
```

### Login

**POST** `/login`

Login pengguna.

#### Request Body

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Response

```json
{
  "message": "Login berhasil",
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "081234567890",
    "role": "admin"
  }
}
```

### Logout

**POST** `/logout`

Logout pengguna. Memerlukan authentication.

#### Response

```json
{
  "message": "Logout berhasil"
}
```

### Get Current User

**GET** `/me`

Mendapatkan data user yang sedang login.

#### Response

```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "081234567890",
    "role": "admin"
  }
}
```

### Refresh Token

**POST** `/refresh`

Memperbaharui JWT token.

#### Response

```json
{
  "message": "Token berhasil diperbarui",
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer"
}
```

---

## Customer Endpoints

### Get All Customers

**GET** `/customers?per_page=15&page=1`

Mendapatkan daftar semua pelanggan.

#### Query Parameters

- `per_page` (optional) - Jumlah data per halaman (default: 15)
- `page` (optional) - Halaman (default: 1)

#### Response

```json
{
  "message": "Data pelanggan berhasil diambil",
  "data": {
    "data": [
      {
        "id": 1,
        "customer_number": "CUST001",
        "name": "PT Maju Jaya",
        "nik": "1234567890123456",
        "phone": "081234567890",
        "email": "contact@majujaya.com",
        "address": "Jl. Sudirman No. 123",
        "status": "active",
        "subscription_date": "2024-01-01",
        "due_date": "2024-02-01"
      }
    ],
    "current_page": 1,
    "per_page": 15,
    "total": 50
  }
}
```

### Create Customer

**POST** `/customers`

Membuat pelanggan baru.

#### Request Body

```json
{
  "customer_number": "CUST002",
  "name": "CV Maju Bersama",
  "nik": "1234567890123457",
  "phone": "081234567891",
  "email": "contact@majubersama.com",
  "address": "Jl. Ahmad Yani No. 45",
  "latitude": "-6.2088",
  "longitude": "106.8456",
  "area_id": 1,
  "package_id": 2,
  "status": "active",
  "subscription_date": "2024-07-08",
  "due_date": "2024-08-08"
}
```

#### Response

```json
{
  "message": "Pelanggan berhasil ditambahkan",
  "data": {
    "id": 2,
    "customer_number": "CUST002",
    "name": "CV Maju Bersama",
    "status": "active",
    "created_at": "2024-07-08T12:00:00Z"
  }
}
```

### Get Customer Detail

**GET** `/customers/{id}`

Mendapatkan detail pelanggan spesifik.

#### Response

```json
{
  "message": "Data pelanggan berhasil diambil",
  "data": {
    "id": 1,
    "customer_number": "CUST001",
    "name": "PT Maju Jaya",
    "phone": "081234567890",
    "email": "contact@majujaya.com",
    "address": "Jl. Sudirman No. 123",
    "status": "active",
    "invoices": [
      {
        "id": 1,
        "invoice_number": "INV001",
        "total": 250000,
        "status": "paid"
      }
    ],
    "tickets": [
      {
        "id": 1,
        "ticket_number": "TKT001",
        "title": "Internet lambat",
        "status": "closed"
      }
    ]
  }
}
```

### Update Customer

**PUT** `/customers/{id}`

Update data pelanggan.

#### Request Body

```json
{
  "name": "PT Maju Jaya Updated",
  "phone": "081234567892",
  "email": "newemail@majujaya.com",
  "status": "suspend"
}
```

#### Response

```json
{
  "message": "Pelanggan berhasil diperbarui",
  "data": {
    "id": 1,
    "name": "PT Maju Jaya Updated",
    "status": "suspend",
    "updated_at": "2024-07-08T12:30:00Z"
  }
}
```

### Delete Customer

**DELETE** `/customers/{id}`

Menghapus pelanggan.

#### Response

```json
{
  "message": "Pelanggan berhasil dihapus"
}
```

### Search Customers

**GET** `/customers/search/query?q={query}`

Mencari pelanggan berdasarkan nama, email, atau nomor telepon.

#### Query Parameters

- `q` (required) - Kata kunci pencarian

#### Response

```json
{
  "message": "Data pelanggan berhasil ditemukan",
  "data": [
    {
      "id": 1,
      "customer_number": "CUST001",
      "name": "PT Maju Jaya",
      "phone": "081234567890"
    }
  ]
}
```

---

## Invoice Endpoints

### Get All Invoices

**GET** `/invoices?per_page=15&page=1`

Mendapatkan daftar semua invoice.

#### Response

```json
{
  "message": "Data invoice berhasil diambil",
  "data": {
    "data": [
      {
        "id": 1,
        "invoice_number": "INV20240701001",
        "customer_id": 1,
        "invoice_date": "2024-07-01",
        "due_date": "2024-07-08",
        "amount": 250000,
        "tax": 25000,
        "discount": 10000,
        "total": 265000,
        "status": "paid"
      }
    ],
    "total": 25
  }
}
```

### Create Invoice

**POST** `/invoices`

Membuat invoice baru.

#### Request Body

```json
{
  "customer_id": 1,
  "invoice_date": "2024-07-08",
  "due_date": "2024-07-15",
  "amount": 500000,
  "tax": 50000,
  "discount": 0,
  "total": 550000,
  "status": "unpaid"
}
```

#### Response

```json
{
  "message": "Invoice berhasil dibuat",
  "data": {
    "id": 2,
    "invoice_number": "INV20240708001",
    "customer_id": 1,
    "total": 550000,
    "status": "unpaid",
    "created_at": "2024-07-08T12:00:00Z"
  }
}
```

### Get Invoice Detail

**GET** `/invoices/{id}`

Mendapatkan detail invoice spesifik.

#### Response

```json
{
  "message": "Data invoice berhasil diambil",
  "data": {
    "id": 1,
    "invoice_number": "INV20240701001",
    "customer": {
      "id": 1,
      "name": "PT Maju Jaya",
      "phone": "081234567890"
    },
    "invoice_date": "2024-07-01",
    "due_date": "2024-07-08",
    "amount": 250000,
    "tax": 25000,
    "discount": 10000,
    "total": 265000,
    "status": "paid"
  }
}
```

### Update Invoice

**PUT** `/invoices/{id}`

Update invoice.

#### Request Body

```json
{
  "status": "paid"
}
```

#### Response

```json
{
  "message": "Invoice berhasil diperbarui",
  "data": {
    "id": 1,
    "status": "paid",
    "updated_at": "2024-07-08T13:00:00Z"
  }
}
```

### Delete Invoice

**DELETE** `/invoices/{id}`

Menghapus invoice.

#### Response

```json
{
  "message": "Invoice berhasil dihapus"
}
```

### Get Unpaid Invoices

**GET** `/invoices/unpaid/list`

Mendapatkan daftar invoice yang belum dibayar.

#### Response

```json
{
  "message": "Data invoice belum dibayar berhasil diambil",
  "data": [
    {
      "id": 2,
      "invoice_number": "INV20240708001",
      "customer": {
        "id": 1,
        "name": "PT Maju Jaya"
      },
      "total": 550000,
      "status": "unpaid"
    }
  ]
}
```

---

## Ticket Endpoints

### Get All Tickets

**GET** `/tickets?per_page=15&page=1`

Mendapatkan daftar semua tiket.

#### Response

```json
{
  "message": "Data tiket berhasil diambil",
  "data": {
    "data": [
      {
        "id": 1,
        "ticket_number": "TKT20240701001",
        "customer_id": 1,
        "title": "Internet tidak stabil",
        "status": "on_progress",
        "priority": "high"
      }
    ],
    "total": 15
  }
}
```

### Create Ticket

**POST** `/tickets`

Membuat tiket baru.

#### Request Body

```json
{
  "customer_id": 1,
  "title": "Internet Error 404",
  "description": "Pelanggan tidak bisa akses internet, muncul error 404",
  "priority": "high",
  "latitude": "-6.2088",
  "longitude": "106.8456"
}
```

#### Response

```json
{
  "message": "Tiket berhasil dibuat",
  "data": {
    "id": 2,
    "ticket_number": "TKT20240708001",
    "customer_id": 1,
    "status": "open",
    "priority": "high",
    "created_at": "2024-07-08T12:00:00Z"
  }
}
```

### Get Ticket Detail

**GET** `/tickets/{id}`

Mendapatkan detail tiket spesifik.

#### Response

```json
{
  "message": "Data tiket berhasil diambil",
  "data": {
    "id": 1,
    "ticket_number": "TKT20240701001",
    "customer": {
      "id": 1,
      "name": "PT Maju Jaya",
      "phone": "081234567890"
    },
    "title": "Internet tidak stabil",
    "description": "Kecepatan internet sering turun",
    "status": "on_progress",
    "priority": "high",
    "assignee": {
      "id": 2,
      "name": "Teknisi Budi"
    },
    "histories": [
      {
        "action": "created",
        "timestamp": "2024-07-01T10:00:00Z"
      },
      {
        "action": "assigned",
        "timestamp": "2024-07-01T11:00:00Z"
      }
    ]
  }
}
```

### Update Ticket

**PUT** `/tickets/{id}`

Update tiket.

#### Request Body

```json
{
  "status": "solved",
  "priority": "medium",
  "assigned_to": 2
}
```

#### Response

```json
{
  "message": "Tiket berhasil diperbarui",
  "data": {
    "id": 1,
    "status": "solved",
    "updated_at": "2024-07-08T13:00:00Z"
  }
}
```

### Delete Ticket

**DELETE** `/tickets/{id}`

Menghapus tiket.

#### Response

```json
{
  "message": "Tiket berhasil dihapus"
}
```

### Get Open Tickets

**GET** `/tickets/open/list`

Mendapatkan daftar tiket yang masih terbuka.

#### Response

```json
{
  "message": "Data tiket terbuka berhasil diambil",
  "data": [
    {
      "id": 1,
      "ticket_number": "TKT20240701001",
      "customer": {
        "id": 1,
        "name": "PT Maju Jaya"
      },
      "title": "Internet tidak stabil",
      "status": "on_progress"
    }
  ]
}
```

### Search Tickets

**GET** `/tickets/search/query?q={query}`

Mencari tiket berdasarkan judul atau deskripsi.

#### Query Parameters

- `q` (required) - Kata kunci pencarian

#### Response

```json
{
  "message": "Data tiket berhasil ditemukan",
  "data": [
    {
      "id": 1,
      "ticket_number": "TKT20240701001",
      "title": "Internet tidak stabil",
      "status": "on_progress"
    }
  ]
}
```

---

## Error Examples

### 401 Unauthorized

```json
{
  "error": "Unauthorized"
}
```

### 422 Validation Error

```json
{
  "error": "Email atau password salah",
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### 404 Not Found

```json
{
  "error": "Not Found"
}
```

---

## Pagination

Endpoint yang mengembalikan list data support pagination:

```
GET /customers?per_page=15&page=2
```

### Response Format

```json
{
  "data": [...],
  "current_page": 2,
  "per_page": 15,
  "total": 50,
  "last_page": 4,
  "from": 16,
  "to": 30
}
```
