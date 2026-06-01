FROM php:8.4-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip curl zip libicu-dev libzip-dev nodejs npm

# Extensions PHP OBLIGATOIRES (MYSQL DRIVER)
RUN docker-php-ext-install pdo pdo_mysql intl zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Install assets
RUN npm install
RUN npm run build

# Symfony cache
RUN mkdir -p var && chmod -R 777 var

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
