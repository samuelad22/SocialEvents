#!/bin/sh
set -eu

cd /var/www/html

if [ -d /var/www/html/public/assets/imagenesSeeder/Imagenes ]; then
    cp -r /var/www/html/public/assets/imagenesSeeder/Imagenes/. /var/www/html/storage/app/public/imagenes/
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction
fi

/wait-for-it.sh "${DB_HOST:-bd}:${DB_PORT:-3306}" --timeout=60 --strict -- echo "Base de datos disponible"
php artisan migrate --force --no-interaction

if ! mysql -h"${DB_HOST:-bd}" -P"${DB_PORT:-3306}" -u"${DB_USERNAME:-streetconnect}" -p"${DB_PASSWORD:-root}" "${DB_DATABASE:-street_connect}" -Nse "SELECT 1 FROM users LIMIT 1" | grep -q 1; then
    php artisan db:seed --force --no-interaction
fi

php artisan storage:link --force || true
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf