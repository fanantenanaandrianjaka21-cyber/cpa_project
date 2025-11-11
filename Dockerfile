# ----------------------------
# Étape 1 : Build Laravel
# ----------------------------
FROM php:8.2-fpm AS build

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && docker-php-ext-enable pdo_pgsql

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code source
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Laravel sans exécuter les scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# ----------------------------
# Étape 2 : Image finale
# ----------------------------
FROM php:8.2-fpm

# Installer extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev zip unzip pkg-config \
    postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && docker-php-ext-enable pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copier le build Laravel
WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

# Ajouter un script d'entrée pour attendre la DB
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exposer le port
EXPOSE 8000

# Utiliser le script d'entrée
ENTRYPOINT ["docker-entrypoint.sh"]
