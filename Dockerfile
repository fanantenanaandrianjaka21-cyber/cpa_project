FROM php:8.2-fpm

# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Installer dépendances PHP avec logs
RUN composer install --no-dev --optimize-autoloader --verbose

# Création des liens de stockage et permissions
RUN php artisan storage:link || true
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000
CMD ["php-fpm"]
