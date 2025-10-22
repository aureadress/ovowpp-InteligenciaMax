# Use PHP 8.2 CLI Alpine (compatível com composer.json)
FROM php:8.2-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    bash \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    gmp-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    xml \
    zip \
    bcmath \
    gd \
    gmp

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy application files
COPY . .

# Create necessary directories
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Set permissions (777 for Railway environment)
RUN chmod -R 777 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# Make start script executable
RUN chmod +x start.sh

# Expose port
EXPOSE 8080

# Use our custom start script
CMD ["bash", "start.sh"]
