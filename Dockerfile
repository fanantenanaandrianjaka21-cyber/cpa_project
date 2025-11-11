# Étape 1 : Construire le code Laravel
FROM php:8.2-fpm as build

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code source
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Générer la clé Laravel (pendant le build)
RUN php artisan key:generate --force

# Étape 2 : Lancer le serveur PHP
FROM php:8.2-fpm

WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
