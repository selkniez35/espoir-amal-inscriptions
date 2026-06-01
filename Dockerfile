FROM php:8.4-cli

# =========================
# SYSTEM DEPENDENCIES
# =========================
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libicu-dev libzip-dev \
    nodejs npm

# =========================
# PHP EXTENSIONS (IMPORTANT)
# =========================
RUN docker-php-ext-install pdo pdo_mysql intl zip

# =========================
# COMPOSER
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# =========================
# COPY PROJECT
# =========================
COPY . .

# =========================
# FORCE PROD ENV (CRITICAL FOR SYMFONY)
# =========================
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_MEMORY_LIMIT=-1

# IMPORTANT: avoid PHP version mismatch issues
RUN composer config platform.php 8.4.0

# =========================
# INSTALL PHP DEPENDENCIES
# =========================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts -vvv

# =========================
# FRONTEND BUILD
# =========================
RUN npm install
RUN npm run build

# =========================
# SYMFONY CACHE CLEAN
# =========================
RUN rm -rf var/cache/*
RUN php bin/console cache:clear --env=prod --no-warmup || true
RUN php bin/console cache:warmup --env=prod || true

# =========================
# PERMISSIONS
# =========================
RUN mkdir -p var && chmod -R 777 var

EXPOSE 10000

# =========================
# START SERVER (RENDER SAFE)
# =========================
CMD ["sh", "-c", "APP_ENV=prod APP_DEBUG=0 php -S 0.0.0.0:10000 -t public"]
