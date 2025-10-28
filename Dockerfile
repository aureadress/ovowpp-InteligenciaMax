# ---------- Estágio 1: Builder (Construtor) ----------
FROM php:8.3-fpm AS builder


# Instala dependências do sistema
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
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configura GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instala extensões PHP
RUN docker-php-ext-install pdo_mysql bcmath gd zip mbstring xml dom exif pcntl gmp

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Instala dependências PHP
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Gera APP_KEY (agora vai funcionar)
RUN php artisan key:generate --force

# Otimiza para produção
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Define permissões
WORKDIR /var/www/html
RUN chown -R www-data:www-data core/storage core/bootstrap/cache && \
    chmod -R 775 core/storage core/bootstrap/cache

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

# Configuração PHP para NÃO mostrar erros em produção
RUN echo "display_errors = Off" > /usr/local/etc/php/conf.d/errors.ini && \
    echo "display_startup_errors = Off" >> /usr/local/etc/php/conf.d/errors.ini && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/errors.ini && \
    echo "error_log = /dev/stderr" >> /usr/local/etc/php/conf.d/errors.ini

# Copia extensões PHP do builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copia aplicação compilada do builder
COPY --from=builder /var/www/html /var/www/html

# Configuração do Nginx (com os aliases para /assets e /install)
RUN echo 'server { \n\
    listen 8080; \n\
    server_name _; \n\
    root /var/www/html/core/public; \n\
    index index.php; \n\
    charset utf-8; \n\
    \n\
    access_log /dev/stdout; \n\
    error_log /dev/stderr debug; \n\
    \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    \n\
    location /assets/ { \n\
        alias /var/www/html/assets/; \n\
        try_files $uri =404; \n\
    } \n\
    \n\
    location /install/ { \n\
        alias /var/www/html/install/; \n\
        try_files $uri $uri/ /install/index.php?$query_string; \n\
        \n\
        location ~ \.php$ { \n\
            fastcgi_pass 127.0.0.1:9000; \n\
            fastcgi_index index.php; \n\
            fastcgi_param SCRIPT_FILENAME $request_filename; \n\
            include fastcgi_params; \n\
        } \n\
    } \n\
    \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
    \n\
    location ~ /\.(?!well-known).* { \n\
        deny all; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Configuração do Supervisor
RUN echo '[supervisord] \n\
nodaemon=true \n\
logfile=/dev/null \n\
pidfile=/var/run/supervisord.pid \n\
\n\
[program:php-fpm] \n\
command=php-fpm \n\
autostart=true \n\
autorestart=true \n\
priority=5 \n\
stdout_logfile=/dev/stdout \n\
stdout_logfile_maxbytes=0 \n\
stderr_logfile=/dev/stderr \n\
stderr_logfile_maxbytes=0 \n\
\n\
[program:nginx] \n\
command=nginx -g "daemon off;" \n\
autostart=true \n\
autorestart=true \n\
priority=10 \n\
stdout_logfile=/dev/stdout \n\
stdout_logfile_maxbytes=0 \n\
stderr_logfile=/dev/stderr \n\
stderr_logfile_maxbytes=0' > /etc/supervisor/conf.d/supervisord.conf

# Define permissões finais
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

EXPOSE 8080

# Script de inicialização (SEM MIGRATIONS)
RUN echo '#!/bin/bash\n\
set -e\n\
echo "Iniciando supervisor..."\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]
