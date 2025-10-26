# ---------- Estágio 1: Builder ----------
FROM php:8.2-fpm AS builder
WORKDIR /var/www/html

# libs de build (zip é crítico p/ ext-zip)
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip unzip git curl \
    libzip-dev libonig-dev libxml2-dev \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip xml dom

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copia apenas a pasta do app Laravel
COPY Laravel/ ./

# deps PHP (produção)
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# ---------- Estágio 2: Runtime ----------
FROM php:8.2-fpm
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libfreetype6 libjpeg62-turbo libpng16-16 libzip4 libxml2 \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# extensões e app do builder
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /var/www/html /var/www/html

# permissões
RUN chown -R www-data:www-data /var/www/html

# se preferir rodar com artisan serve (porta do Railway em $PORT)
EXPOSE 8080
CMD ["bash", "-lc", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
