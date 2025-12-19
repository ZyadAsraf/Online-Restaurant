FROM php:8.2-apache

# Install PHP extensions needed by the app
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        zip \
        unzip \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY . /var/www/html

# Ensure proper permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP port
EXPOSE 80

# Default command provided by base image starts Apache

# Notes:
# - The application connects to MySQL using constants in Config/Constant.php.
#   If running MySQL in another container or host, update those constants
#   (e.g., set LOCALHOST to the DB service name or IP) or refactor to read env vars.
