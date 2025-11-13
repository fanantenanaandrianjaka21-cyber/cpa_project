# --- ÉTAPE 1: Build de l'environnement PHP (FPM) ---
FROM php:8.3-fpm-alpine AS laravel_php

# Définition du répertoire de travail
WORKDIR /var/www/html

# Installation des dépendances système (y compris Nginx pour l'étape 2)
RUN apk add --no-cache \
    nginx \
    git \
    libzip-dev \
    libpng-dev \
    libpq \
    libpq-dev \
    oniguruma-dev \
    linux-headers \
    # Nettoyage
    && rm -rf /var/cache/apk/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd sockets

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copie de tout le code de l'application
COPY . .

# Définition des permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# --- ÉTAPE 2: Configuration et Démarrage Nginx ---
FROM laravel_php AS final_image

# Copie du fichier de configuration Nginx (doit être créé séparément)
# Créez un fichier 'nginx.conf' dans le même dossier que votre Dockerfile
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Remplacement de la commande CMD pour démarrer à la fois FPM et Nginx
# Nous utilisons 'supervisord' ou un script custom pour gérer les deux processus,
# mais pour une solution simple, nous démarrons les deux en arrière-plan.
# Nous allons utiliser 'supervisord' pour la robustesse.

# Installation de Supervisord (pour gérer FPM et Nginx)
RUN apk add --no-cache supervisor

# Copie du fichier de configuration de Supervisor (doit être créé séparément)
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Le port 80 est le port HTTP standard que Render et les navigateurs attendent.
EXPOSE 80

# La commande de démarrage exécute Supervisor, qui démarre Nginx et PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
