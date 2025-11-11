#!/bin/bash
set -e

# Attendre que PostgreSQL soit prêt
echo "Waiting for PostgreSQL..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  sleep 2
done

# Générer la clé si nécessaire
php artisan key:generate --force

# Lancer les migrations si besoin
php artisan migrate --force

# Lancer le serveur Laravel
php artisan serve --host=0.0.0.0 --port=8000
