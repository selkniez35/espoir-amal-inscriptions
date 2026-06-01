FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libicu-dev libzip-dev \
    nodejs npm

RUN docker-php-ext-install pdo pdo_mysql intl zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_MEMORY_LIMIT=-1

RUN composer config platform.php 8.4.0

# INSTALL ONLY (NO SYMFONY COMMANDS HERE)
RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install
RUN npm run build

RUN rm -rf var/cache/*

RUN mkdir -p var && chmod -R 777 var

EXPOSE 10000

CMD ["sh", "-c", "APP_ENV=prod APP_DEBUG=0 php -S 0.0.0.0:10000 -t public"]
