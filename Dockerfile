# Utilisation d'une image PHP FPM comme base
FROM php:8.3-fpm-alpine

# Définition du répertoire de travail
WORKDIR /var/www/html

# Installation des dépendances système et des extensions PHP (pdo_pgsql est essentiel)
RUN apk add --no-cache git libzip-dev libpng-dev libpq \
    && docker-php-ext-configure gd --with-png \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd sockets

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copie des fichiers de l'application
COPY . .

# Définition des permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Render injecte généralement le port, mais EXPOSE est une bonne pratique
EXPOSE 8000 

# Commande de démarrage (si vous n'utilisez pas php artisan serve dans render.yaml, utilisez php-fpm ici)
# MAIS : Étant donné que votre render.yaml utilise 'php artisan serve', 
# cette ligne n'est pas strictement nécessaire pour Render dans ce cas, 
# mais laissons-la pour une image réutilisable.
CMD ["php-fpm"]
