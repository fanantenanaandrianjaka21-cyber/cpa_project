#!/bin/bash

# Configuration Render : Assurer que le port Render est défini.
# Render utilise la variable $PORT. Laravel utilise le port 8000 par défaut.
# On utilise $PORT s'il est défini, sinon 8000 (ce qui devrait être 8000 si $PORT n'est pas défini)
LISTEN_PORT=${PORT:-8000}

# 1. Effectuer les migrations de la base de données
# Assurez-vous d'utiliser l'option --force en environnement de production
php artisan migrate --force

# 2. Lancer l'application Laravel sur le port d'écoute de Render
# L'option --host 0.0.0.0 est essentielle pour écouter toutes les interfaces réseau
echo "Starting Laravel on 0.0.0.0:${LISTEN_PORT}"
exec php artisan serve --host 0.0.0.0 --port "${LISTEN_PORT}"
# #!/bin/bash
# set -e

# # Copier .env.example si .env n’existe pas
# if [ ! -f /var/www/html/.env ]; then
#     cp /var/www/html/.env.example /var/www/html/.env
# fi

# # Attendre la base de données PostgreSQL
# echo "⏳ Waiting for PostgreSQL..."
# until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" >/dev/null 2>&1; do
#   sleep 2
# done
# echo "✅ Database is ready!"

# # Générer la clé Laravel si nécessaire
# php artisan key:generate --force

# # Effectuer les migrations
# php artisan migrate --force

# # Mettre en cache la config/routes/views
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# # Lancer Laravel
# echo "🚀 Starting Laravel on port 8000..."
# php artisan serve --host=0.0.0.0 --port=8000
