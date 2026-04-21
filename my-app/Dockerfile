FROM dunglas/frankenphp:php8.4-bookworm

# Install system dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring gd zip fileinfo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Install JS dependencies and build assets
COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# Laravel setup
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 8000

CMD php artisan migrate --force && php artisan storage:link --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
