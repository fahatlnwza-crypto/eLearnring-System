#!/bin/bash

# Install dependencies if vendor doesn't exist
if [ ! -d "vendor" ]; then
    composer install --no-interaction --no-dev
fi

# Generate key if not exists
if [ ! -f ".env" ] || ! grep -q "APP_KEY=" .env; then
    php artisan key:generate --force
fi

# Run the application
php artisan serve --host=0.0.0.0 --port=8000
