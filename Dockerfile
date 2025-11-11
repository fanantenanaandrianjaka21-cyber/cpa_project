# --- Étape 1 : Build (Composer)
FROM php:8.2-fpm AS build

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier les fichiers de l'application
WORKDIR /var/www/html
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Copier l'environnement de production
RUN cp .env.example .env

# Générer la clé Laravel (Render te permettra de la remplacer via variables d’environnement)
RUN php artisan key:generate

# --- Étape 2 : Production avec Nginx + PHP-FPM
FROM nginx:stable-alpine

# Installer PHP-FPM et extensions
RUN apk add --no-cache php82 php82-fpm php82-pdo_pgsql php82-mbstring php82-zip php82-bcmath php82-opcache

# Copier la configuration de Nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Copier les fichiers de Laravel du build précédent
COPY --from=build /var/www/html /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Donner les bonnes permissions
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port par défaut
EXPOSE 80

# Commande de démarrage
CMD ["nginx", "-g", "daemon off;"]
