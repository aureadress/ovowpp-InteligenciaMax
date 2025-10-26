# ---------- Estágio 1: Builder (Construtor) ----------
FROM php:8.3-fpm AS builder

WORKDIR /var/www/html

# Instala dependências do sistema necessárias para as extensões PHP
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libgmp-dev \
    nginx \
    supervisor \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configura GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instala extensões PHP
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gd \
    && docker-php-ext-install gmp \
    && docker-php-ext-install zip \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install xml \
    && docker-php-ext-install dom \
    && docker-php-ext-install exif \
    && docker-php-ext-install pcntl

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia apenas os arquivos composer.json e composer.lock
COPY Laravel/core/composer.json Laravel/core/composer.lock ./core/

# Instala dependências PHP
WORKDIR /var/www/html/core
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Copia toda a aplicação Laravel
WORKDIR /var/www/html
COPY Laravel/ .

# Cria diretórios de storage e cache
RUN mkdir -p core/storage/logs core/storage/framework/sessions core/storage/framework/views core/storage/framework/cache core/bootstrap/cache

# ---------- Estágio 2: Runtime (Produção) ----------
FROM php:8.3-fpm
WORKDIR /var/www/html

# Instala bibliotecas mínimas + Nginx + Supervisor
RUN apt-get update && apt-get install -y \
    libfreetype6 \
    libjpeg62-turbo \
    libpng16-16 \
    libzip-dev \
    libxml2 \
    libgmp10 \
    nginx \
    supervisor \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia extensões PHP do builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copia aplicação
COPY --from=builder /var/www/html /var/www/html

# Corrige permissões
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/core/storage /var/www/html/core/bootstrap/cache 2>/dev/null || true

# Configuração do Nginx - CORRIGIDO PARA APONTAR PARA /core/public
RUN echo 'server { \n\
    listen 8080; \n\
    root /var/www/html/core/public; \n\
    index index.php; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Configuração do Supervisor
RUN echo '[supervisord] \n\
nodaemon=true \n\
user=root \n\
[program:php-fpm] \n\
command=php-fpm \n\
autostart=true \n\
autorestart=true \n\
stdout_logfile=/dev/stdout \n\
stdout_logfile_maxbytes=0 \n\
stderr_logfile=/dev/stderr \n\
stderr_logfile_maxbytes=0 \n\
[program:nginx] \n\
command=nginx -g "daemon off;" \n\
autostart=true \n\
autorestart=true \n\
stdout_logfile=/dev/stdout \n\
stdout_logfile_maxbytes=0 \n\
stderr_logfile=/dev/stderr \n\
stderr_logfile_maxbytes=0' > /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

# Script de inicialização
RUN echo '#!/bin/bash\n\
cd /var/www/html/core\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan migrate --force\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]
