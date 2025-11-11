#!/bin/sh
set -e

# Attendre que la base de données soit prête
echo "Waiting for PostgreSQL..."
while ! pg_isready -h ${DB_HOST} -p ${DB_PORT} -U ${DB_USERNAME} >/dev/null 2>&1; do
  sleep 1
done

echo "Database ready! Starting Laravel..."

# Lancer PHP-FPM
php-fpm
