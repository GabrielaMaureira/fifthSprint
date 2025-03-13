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

# Set working directory
WORKDIR /var/www

# Copy the rest of the project files
COPY . .

# Copy the entrypoint script from docker/entrypoint.sh & giving permissions
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Installing Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Giving permissions to storage
RUN chown -R www-data:www-data /var/www

# Expose 9000 to PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]