FROM php:8.2-apache

# Install necessary extensions
RUN apt-get update && \
    apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev zip unzip git && \
    docker-php-ext-install curl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html/

# Copy application files
COPY . /var/www/html/

# Install PHP dependencies
RUN composer install --ignore-platform-req=ext-mongodb

# Enable MongoDB extension if not already enabled
RUN if ! php -m | grep -q 'mongodb'; then \
    pecl install mongodb && \
    docker-php-ext-enable mongodb; \
    fi

# Change ownership of application files
RUN chown -R www-data:www-data /var/www/html/
