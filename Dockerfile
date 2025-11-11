# Étape 1 : Build
FROM php:8.2-fpm as build

# Installer dépendances système pour build
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev libpq-dev \
    pkg-config build-essential

# Configurer et installer extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code source Laravel
WORKDIR /var/www/html
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Générer la clé Laravel
RUN php artisan key:generate --force

# Étape 2 : Image finale
FROM php:8.2-fpm

# Installer runtime libs
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev libpq-dev \
    pkg-config

# Copier l’application depuis le build
WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
