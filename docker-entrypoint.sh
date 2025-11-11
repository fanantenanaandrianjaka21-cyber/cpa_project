#!/bin/bash
set -e

# Copier .env.example si .env n’existe pas
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Attendre la base de données PostgreSQL
echo "⏳ Waiting for PostgreSQL..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" >/dev/null 2>&1; do
  sleep 2
done
echo "✅ Database is ready!"

# Générer la clé Laravel si nécessaire
php artisan key:generate --force

# Effectuer les migrations
php artisan migrate --force

# Mettre en cache la config/routes/views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lancer Laravel
echo "🚀 Starting Laravel on port 8000..."
php artisan serve --host=0.0.0.0 --port=8000
