#!/bin/bash
set -e

# Copier .env.example en .env si nécessaire
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Attendre que PostgreSQL soit prêt
echo "Waiting for PostgreSQL..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  sleep 2
done

# Générer la clé Laravel si nécessaire
php artisan key:generate --force

# Découvrir les packages Laravel (après la DB disponible)
php artisan package:discover --ansi

# Lancer les migrations
php artisan migrate --force

# Générer les caches Laravel (optionnel mais recommandé)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lancer le serveur Laravel
php artisan serve --host=0.0.0.0 --port=8000
