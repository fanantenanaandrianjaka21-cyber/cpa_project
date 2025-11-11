# Dockerfile pour Laravel/PHP-FPM

# Utiliser une image PHP FPM comme base
FROM php:8.3-fpm-alpine

# Définition du répertoire de travail
WORKDIR /var/www/html

# ----------------- BLOC À CORRIGER -----------------
# Installation des dépendances système (AJOUT de libpq-dev)
RUN apk add --no-cache git libzip-dev libpng-dev libpq libpq-dev \
    # Installez toutes les extensions requises
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd sockets

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copie de tout le code de l'application
COPY . .

# Définition des permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port par défaut pour PHP-FPM
EXPOSE 9000

# Commande de démarrage (PHP-FPM)
CMD ["php-fpm"]
