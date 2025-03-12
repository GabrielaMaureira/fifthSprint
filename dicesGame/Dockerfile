# Use an official PHP image with necessary extensions
FROM php:8.2-fpm

# Installing system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
WORKDIR /var/www
COPY . .

# Copy the entrypoint script from docker/entrypoint.sh
COPY docker/entrypoint.sh /entrypoint.sh

# Grant execution permissions to the script
RUN chmod +x /entrypoint.sh

# Installing Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Giving permissions to storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose 9000 to PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
