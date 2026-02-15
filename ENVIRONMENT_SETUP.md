# 📝 ตัวอย่าง Environment Configuration

## Frontend (.env.local or .env.development)

```env
# API Configuration
NUXT_PUBLIC_API_BASE_URL=http://localhost:8000
NUXT_PUBLIC_APP_NAME=elearning

# Frontend URL
NUXT_PUBLIC_FRONTEND_URL=http://localhost:3000

# Auth Configuration
NUXT_PUBLIC_AUTH_ENABLED=true
NUXT_PUBLIC_TOKEN_STORAGE=localStorage

# Feature Flags
NUXT_PUBLIC_DISABLE_REMEMBER_ME=false
```

## Backend (.env)

```env
# Application
APP_NAME=elearning
APP_ENV=local
APP_KEY=base64:your_generated_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elearning_db
DB_USERNAME=root
DB_PASSWORD=

# Cache
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Mail (for future use)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Authentication
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
SANCTUM_GUARD=sanctum

# Frontend
FRONTEND_URL=http://localhost:3000

# CORS
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:3000
```

## Docker Environment (.env.docker)

```env
# Backend
APP_NAME=elearning
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

# Database in Docker
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=elearning
DB_USERNAME=elearning
DB_PASSWORD=elearning_password

# Redis (if using Docker Compose)
CACHE_DRIVER=redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Session
SESSION_DRIVER=cookie

# CORS for Docker
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://host.docker.internal:3000
FRONTEND_URL=http://localhost:3000

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:3000,host.docker.internal:3000
```

## Installation Steps

### Frontend

```bash
# Navigate to frontend directory
cd elearning-frontend

# Create .env.local
cp .env.example .env.local

# Edit .env.local with above values

# Install dependencies
npm install

# Run development server
npm run dev
```

### Backend

```bash
# Navigate to backend directory
cd elearning-backend

# Create .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Install dependencies
composer install

# Run migrations
php artisan migrate

# Create test user (optional)
php artisan tinker
# In tinker:
# User::create(['name' => 'Test User', 'email' => 'test@example.com', 'password' => Hash::make('password')])
# exit

# Run server
php artisan serve
```

## การ Generate Key

```bash
# Laravel
php artisan key:generate

# Or add manually to .env
APP_KEY=base64:asdfasdfasdfasdfasdfasdfasdfasdf=
```

## Quick Start Commands

```bash
# Terminal 1: Backend
cd elearning-backend
php artisan serve --host=0.0.0.0 --port=8000

# Terminal 2: Frontend
cd elearning-frontend
npm run dev
```

ตอนนี้คุณสามารถเข้าถึง:
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000
- Login page: http://localhost:3000/login
