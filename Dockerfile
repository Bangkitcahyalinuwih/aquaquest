# syntax=docker/dockerfile:1.7
# AquaQuest: Laravel 12 + Apache + PHP 8.3. Build bertahap (multi-stage) agar image akhir kecil dan bersih.

############################################
# Tahap 1: dependensi PHP (tanpa paket dev)
############################################
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-scripts --no-autoloader \
    --prefer-dist --no-interaction --ignore-platform-reqs

############################################
# Tahap 2: build aset frontend (Vite + Tailwind)
############################################
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
# vendor dibutuhkan Tailwind untuk memindai view paginasi bawaan Laravel
COPY --from=vendor /app/vendor ./vendor
RUN npm run build

############################################
# Tahap 3: image runtime
############################################
FROM php:8.4-apache AS app

COPY --from=ghcr.io/mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql gd intl zip bcmath exif opcache \
    && a2enmod rewrite headers \
    && printf 'ServerTokens Prod\nServerSignature Off\n' > /etc/apache2/conf-available/security-extra.conf \
    && a2enconf security-extra

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php.ini "$PHP_INI_DIR/conf.d/zz-aquaquest.ini"
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY --from=vendor /app/vendor ./vendor
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN rm -f bootstrap/cache/*.php \
    && composer dump-autoload --optimize --no-dev --no-interaction --ignore-platform-reqs \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views \
                storage/logs storage/app/public bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
COPY docker/seed-check.php /usr/local/bin/seed-check.php
# Jaga-jaga bila berkas disunting di Windows (CRLF) sehingga skrip gagal dijalankan di Linux
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint && chmod +x /usr/local/bin/entrypoint

EXPOSE 80
HEALTHCHECK --interval=30s --timeout=5s --start-period=60s --retries=3 \
    CMD curl -fsS http://localhost/up || exit 1

ENTRYPOINT ["entrypoint"]
CMD ["apache2-foreground"]  