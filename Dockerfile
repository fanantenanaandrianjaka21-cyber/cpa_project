# ----------------------------
# Étape unique : exécution Laravel sur Render
# ----------------------------
FROM php:8.2-fpm

# Installer les dépendances système et PHP nécessaires
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev pkg-config postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && docker-php-ext-enable pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le projet Laravel
WORKDIR /var/www/html
COPY . .

# Installer les dépendances PHP sans les dev et sans exécuter les scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Donner les bons droits (Render peut sinon bloquer les logs ou le cache)
RUN chmod -R 775 storage bootstrap/cache

# Copier le script d’entrée
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exposer le port Laravel
EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
