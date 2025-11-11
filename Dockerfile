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
# Étape 1 : Build Laravel + Front-end
# ----------------------------
FROM php:8.2-fpm AS build

# Installer dépendances système, PHP et Node
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev pkg-config nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && docker-php-ext-enable pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code source
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Laravel sans exécuter les scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier le code source Laravel
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Installer les dépendances front-end
RUN npm install

# Compiler les assets pour production
RUN npm run production

# ----------------------------
# Étape 2 : Image finale
# ----------------------------
FROM php:8.2-fpm

# Installer extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev zip unzip pkg-config \
    postgresql-client \
# Installer extensions PHP nécessaires et client PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zlib1g-dev zip unzip pkg-config postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && docker-php-ext-enable pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copier le build Laravel
WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

# Ajouter un script d'entrée pour attendre la DB
# Copier le build Laravel (PHP + assets front-end)
WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

# Copier le script d’entrée
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exposer le port
EXPOSE 8000

# Utiliser le script d'entrée
# Script d'entrée
ENTRYPOINT ["docker-entrypoint.sh"]
