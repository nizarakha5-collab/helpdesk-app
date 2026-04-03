FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip

RUN docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

# Laravel fixes
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan cache:clear

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
