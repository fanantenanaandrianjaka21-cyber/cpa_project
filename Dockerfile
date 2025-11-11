# Étape 1 : Construire le code Laravel
FROM php:8.2-fpm as build

# Installer dépendances système pour build
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev zlib1g-dev pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code source
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Générer la clé Laravel
RUN php artisan key:generate --force

# Étape 2 : Image finale
FROM php:8.2-fpm

# Installer dépendances système pour extensions
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zlib1g-dev pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# Copier l’application depuis l’étape build
WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
