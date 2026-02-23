FROM php:8.2-cli-alpine

# Install required system packages including FFmpeg for video transcoding
RUN apk add --no-cache curl git unzip bash mysql-client postgresql-dev icu-dev libzip-dev ffmpeg

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions required by Laravel and Filament
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql intl zip

# Copy custom PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

# Copy all files
COPY . .

# Install dependencies without running scripts
RUN composer install --ignore-platform-req=php --ignore-platform-req=ext --no-scripts

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
