FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip

RUN docker-php-ext-install zip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set work directory
WORKDIR /app

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install

# Generate key (optional)
RUN php artisan key:generate || true

# Expose port
EXPOSE 10000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
