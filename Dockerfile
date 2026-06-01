FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip libicu-dev libzip-dev nodejs npm

# ✅ IMPORTANT : drivers DB
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql intl zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Composer sans crash env
RUN composer install --no-dev --no-interaction --no-scripts

# assets
RUN npm install && npm run build

# cache safe
RUN mkdir -p var && chmod -R 777 var

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
