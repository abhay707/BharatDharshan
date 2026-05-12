# ============================================================
# Stage 1 — Node.js: Build frontend assets (Vite + TailwindCSS)
# ============================================================
FROM node:22-alpine AS node-builder

WORKDIR /app

# Copy only what's needed for npm install & build
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

# Copy source needed by Vite
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run build

# ============================================================
# Stage 2 — Composer: Install PHP dependencies (no dev)
# ============================================================
FROM composer:2.8 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./

# Install production PHP deps without running scripts yet
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# ============================================================
# Stage 3 — Final production image
# ============================================================
FROM php:8.3-fpm-alpine AS production

# ── System packages ────────────────────────────────────────
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    unzip \
    libpng-dev \
    libwebp-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    mysql-client \
    postgresql-client \
    libpq-dev \
    tzdata

# ── PHP extensions ──────────────────────────────────────────
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
 && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# ── PHP INI tweaks (production) ─────────────────────────────
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/php-overrides.ini /usr/local/etc/php/conf.d/overrides.ini

# ── Nginx config ────────────────────────────────────────────
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# ── Supervisor config (nginx + php-fpm) ────────────────────
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ── Application ──────────────────────────────────────────────
WORKDIR /var/www/html

# Copy vendor from composer stage
COPY --from=composer-builder /app/vendor ./vendor

# Copy compiled assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Copy the rest of the application source
COPY . .

# Remove local .env so Render injects its own env vars
RUN rm -f .env

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html/storage \
 && chmod -R 755 /var/www/html/bootstrap/cache

# ── Optimise Laravel for production ─────────────────────────
# (APP_KEY and other env vars will be supplied by Render at runtime)
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
