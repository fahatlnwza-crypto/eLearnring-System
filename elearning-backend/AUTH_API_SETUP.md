# ระบบ Authentication สำหรับ Laravel elearning-backend

นี่คือคู่มือการตั้งค่า API authentication สำหรับแบ็กเอนด์ Laravel

## 📋 ขั้นตอนการตั้งค่า

### ขั้นตอนที่ 1: ติดตั้ง Laravel Sanctum

Sanctum ใช้สำหรับการพิสูจน์ตัวตนแบบ Token-Based SPA:

```bash
php artisan install:api
```

หรือติดตั้งด้วยตนเอง:

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### ขั้นตอนที่ 2: ตั้งค่า User Model

ตรวจสอบว่า User model มีคุณสมบัติที่ถูกต้อง (`app/Models/User.php`):

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

### ขั้นตอนที่ 3: ตั้งค่าเส้นทาง API

API routes ได้ตั้งค่าไว้แล้วอยู่ใน `routes/api.php`

endpoints:
- **POST** `/api/auth/login` - เข้าสู่ระบบ
- **POST** `/api/auth/register` - ลงทะเบียน
- **POST** `/api/auth/logout` - ออกจากระบบ (ต้องการ auth)
- **GET** `/api/auth/me` - ได้รับข้อมูลผู้ใช้ปัจจุบัน (ต้องการ auth)
- **POST** `/api/auth/refresh` - รีเฟรชโทเค็น (ต้องการ auth)

### ขั้นตอนที่ 4: ตั้งค่า CORS

ตัวแปร environment `.env`:

```
FRONTEND_URL=http://localhost:3000
```

ไฟล์ `config/cors.php`:

```php
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
'allowed_origins_patterns' => [],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,
```

### ขั้นตอนที่ 5: เรียกใช้ Migration ฐานข้อมูล

```bash
php artisan migrate
```

## 🔧 API Endpoints

### 1. Login

**Request:**
```bash
POST /api/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123",
  "remember": true
}
```

**Response (200 OK):**
```json
{
  "message": "เข้าสู่ระบบสำเร็จ",
  "token": "1|abcdefg...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com"
  }
}
```

**Response (401 Unauthorized):**
```json
{
  "message": "ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง"
}
```

### 2. Register

**Request:**
```bash
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**
```json
{
  "message": "สมัครสมาชิกสำเร็จ",
  "token": "1|abcdefg...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com"
  }
}
```

### 3. Logout

**Request:**
```bash
POST /api/auth/logout
Authorization: Bearer 1|abcdefg...
```

**Response (200 OK):**
```json
{
  "message": "ออกจากระบบสำเร็จ"
}
```

### 4. Get Current User

**Request:**
```bash
GET /api/auth/me
Authorization: Bearer 1|abcdefg...
```

**Response (200 OK):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "email_verified_at": null,
    "created_at": "2026-02-15T10:00:00.000000Z",
    "updated_at": "2026-02-15T10:00:00.000000Z"
  }
}
```

### 5. Refresh Token

**Request:**
```bash
POST /api/auth/refresh
Authorization: Bearer 1|abcdefg...
```

**Response (200 OK):**
```json
{
  "message": "โทเค็นรีเฟรชสำเร็จ",
  "token": "2|newabc...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com"
  }
}
```

## 🧪 ทดสอบ API

### ใช้ Postman

1. ใหม่ Request POST ไปยัง `http://localhost:8000/api/auth/login`
2. ตั้งค่า Headers: `Content-Type: application/json`
3. ตั้งค่า Body:
```json
{
  "email": "user@example.com",
  "password": "password123",
  "remember": true
}
```

### ใช้ cURL

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123","remember":true}'
```

## 🔐 ปลอดภัยสูง สุด

### ตัวแปร Environment

ตรวจสอบไฟล์ `.env`:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=your_password

SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
SESSION_DOMAIN=localhost
```

### ตัวอักษรอักษรในการส่ง

- ใช้ HTTPS ในการ production
- จัดเก็บ token อย่างปลอดภัยบนไคลเอ็นต์
- ใช้ httpOnly cookies ถ้าเป็นไปได้
- หมดอายุโทเค็นอย่างเหมาะสม

## 📝 ไฟล์ที่แก้ไข/สร้าง

- ✅ `app/Http/Controllers/AuthApiController.php` - Auth controller ใหม่
- ✅ `routes/api.php` - Auth routes ที่อัพเดต
- ⏳ `config/cors.php` - CORS config (ตรวจสอบการตั้งค่า)
- ⏳ `config/sanctum.php` - Sanctum config (ตรวจสอบการตั้งค่า)

## ❓ แก้ไขปัญหา

### Token ไม่ใช้งาน

ตรวจสอบ:
- Sanctum ติดตั้งเรียบร้อย
- User model มี `HasApiTokens` trait
- API_PREFIX ในไฟล์ config/app.php ถูกต้อง
- SANCTUM_STATEFUL_DOMAINS ตั้งค่าถูกต้อง

### CORS Error

ตรวจสอบ:
- `config/cors.php` อนุญาต frontend domain
- FRONTEND_URL ตั้งค่าใน `.env`
- Headers `Authorization` อยู่ใน `allowed_headers`

### Migration Error

```bash
php artisan migrate:fresh --seed
```

## 🔄 ขั้นตอนต่อไป

1. ทดสอบ API ด้วย Postman
2. เชื่อมต่อกับ Nuxt frontend
3. เพิ่มการตรวจสอบและการจำกัดอัตรา
4. เพิ่มการรีเฟรชโทเค็นโดยอัตโนมัติ
5. เพิ่มบทบาท (roles) และสิทธิ์ (permissions)

สำหรับคำถาม เพิ่มเติม สามารถแจ้งให้ฉันทราบได้!
