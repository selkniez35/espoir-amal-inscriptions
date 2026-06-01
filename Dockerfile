FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip libicu-dev libzip-dev nodejs npm

RUN docker-php-ext-install pdo pdo_mysql intl zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# INSTALL SAFE (IMPORTANT)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# FRONT
RUN npm install
RUN npm run build

RUN mkdir -p var

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
