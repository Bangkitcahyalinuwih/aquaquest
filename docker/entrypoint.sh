#!/bin/sh
# Dijalankan setiap kontainer app mulai. Menyiapkan aplikasi lalu menyerahkan proses ke Apache.
set -e

if [ "$1" = "apache2-foreground" ]; then
    cd /var/www/html

    if [ -z "$APP_KEY" ]; then
        echo "[entrypoint] ERROR: APP_KEY belum diisi di .env.docker (lihat PANDUAN-DOCKER.md)." >&2
        exit 1
    fi

    mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views \
             storage/logs storage/app/public
    php artisan storage:link --force >/dev/null 2>&1 || true

    if [ "${AUTO_MIGRATE:-true}" = "true" ]; then
        echo "[entrypoint] menjalankan migrasi database..."
        tries=0
        until php artisan migrate --force; do
            tries=$((tries + 1))
            if [ "$tries" -ge 10 ]; then
                echo "[entrypoint] ERROR: migrasi gagal setelah 10 percobaan." >&2
                exit 1
            fi
            echo "[entrypoint] database belum siap, ulangi dalam 3 detik ($tries/10)..."
            sleep 3
        done
    fi

    if [ "${AUTO_SEED:-false}" = "true" ]; then
        if php /usr/local/bin/seed-check.php; then
            echo "[entrypoint] data sudah ada, seeder dilewati."
        else
            echo "[entrypoint] database kosong, menjalankan seeder..."
            php artisan db:seed --force
        fi
    fi

    php artisan config:cache
    php artisan view:cache
    php artisan route:cache || echo "[entrypoint] route:cache dilewati."

    # Seeder dan cache dibuat oleh root; Apache (www-data) harus dapat menulis unggahan baru.
    chown -R www-data:www-data storage bootstrap/cache
fi

exec "$@"
