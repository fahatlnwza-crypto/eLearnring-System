# Laravel Backend API

This is a Laravel backend project for building a RESTful API.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL or other supported database

## Installation

1. Install PHP dependencies:
```bash
composer install
```

2. Install Node dependencies:
```bash
npm install
```

3. Generate application key:
```bash
php artisan key:generate
```

4. Configure your database in `.env` file

5. Run migrations:
```bash
php artisan migrate
```

## Running the Application

Start the development server:
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

- `GET /` - Welcome message
- `GET /api/health` - Health check endpoint
- `GET /api/user` - Get authenticated user (requires token)

## Project Structure

```
├── app/
│   ├── Http/Controllers/    # Request handlers
│   └── Models/              # Eloquent models
├── config/                  # Configuration files
├── database/
│   └── migrations/          # Database migrations
├── routes/
│   ├── api.php             # API routes
│   └── web.php             # Web routes
├── storage/                 # Application storage
└── public/                  # Web root
```

## Development

To build assets for development:
```bash
npm run dev
```

To build for production:
```bash
npm run build
```

## License

MIT License
