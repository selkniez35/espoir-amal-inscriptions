FROM php:8.4-cli

# =========================
# SYSTEM DEPENDENCIES
# =========================
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libicu-dev libzip-dev \
    nodejs npm

# =========================
# PHP EXTENSIONS (CRUCIAL)
# =========================
RUN docker-php-ext-install pdo pdo_mysql intl zip

# =========================
# COMPOSER
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# =========================
# COPY CODE
# =========================
COPY . .

# =========================
# ENV PROD FORCE (IMPORTANT)
# =========================
ENV APP_ENV=prod
ENV APP_DEBUG=0

# =========================
# INSTALL PHP DEPENDENCIES
# =========================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# =========================
# FRONT ASSETS
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
# RUN SERVER
# =========================
CMD ["sh", "-c", "APP_ENV=prod APP_DEBUG=0 php -S 0.0.0.0:10000 -t public"]
