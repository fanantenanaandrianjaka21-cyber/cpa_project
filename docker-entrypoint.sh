#!/bin/bash
set -e

# ------------------------------
# 1. Préparation de l'environnement
# ------------------------------
LISTEN_PORT=${PORT:-8000}

# Copier le .env si inexistant
if [ ! -f /var/www/html/.env ]; then
    echo "📋 Copie du fichier .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# ------------------------------
# 2. Attendre la base de données PostgreSQL
# ------------------------------
if [ -n "$DB_HOST" ]; then
    echo "⏳ Attente de PostgreSQL à $DB_HOST:$DB_PORT..."
    until pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" >/dev/null 2>&1; do
        sleep 2
    done
    echo "✅ PostgreSQL est prêt."
fi

# ------------------------------
# 3. Maintenance Laravel
# ------------------------------
echo "🧹 Nettoyage du cache Laravel..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

echo "🔑 Génération de la clé d’application..."
php artisan key:generate --force || true

echo "🗄️  Exécution des migrations..."
php artisan migrate --force || true

# ------------------------------
# 4. Mise en cache des optimisations
# ------------------------------
echo "⚡ Mise en cache de la configuration et des routes..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# ------------------------------
# 5. Démarrage du serveur
# ------------------------------
echo "🚀 Démarrage de Laravel sur 0.0.0.0:${LISTEN_PORT}"
exec php artisan serve --host=0.0.0.0 --port="${LISTEN_PORT}"
