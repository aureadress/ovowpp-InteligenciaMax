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

# Instala extensões PHP (incluindo gmp)
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install xml \
    && docker-php-ext-install dom \
    && docker-php-ext-install exif \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install gmp

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia toda a aplicação Laravel PRIMEIRO
COPY Laravel/ .

# Navega para o diretório core
WORKDIR /var/www/html/core

# Cria arquivo .env com TODAS as variáveis necessárias
RUN if [ ! -f .env ]; then \
        echo "APP_NAME=OvowppMax" > .env && \
        echo "APP_ENV=production" >> .env && \
        echo "APP_KEY=" >> .env && \
        echo "APP_DEBUG=false" >> .env && \
        echo "APP_URL=https://inteligenciamax.com.br" >> .env && \
        echo "" >> .env && \
        echo "LOG_CHANNEL=stack" >> .env && \
        echo "LOG_DEPRECATIONS_CHANNEL=null" >> .env && \
        echo "LOG_LEVEL=error" >> .env && \
        echo "" >> .env && \
        echo "DB_CONNECTION=mysql" >> .env && \
        echo "DB_HOST=\${DB_HOST}" >> .env && \
        echo "DB_PORT=\${DB_PORT}" >> .env && \
        echo "DB_DATABASE=\${DB_DATABASE}" >> .env && \
        echo "DB_USERNAME=\${DB_USERNAME}" >> .env && \
        echo "DB_PASSWORD=\${DB_PASSWORD}" >> .env && \
        echo "" >> .env && \
        echo "BROADCAST_DRIVER=log" >> .env && \
        echo "CACHE_DRIVER=file" >> .env && \
        echo "FILESYSTEM_DISK=local" >> .env && \
        echo "QUEUE_CONNECTION=sync" >> .env && \
        echo "SESSION_DRIVER=file" >> .env && \
        echo "SESSION_LIFETIME=120" >> .env && \
        echo "" >> .env && \
        echo "MEMCACHED_HOST=127.0.0.1" >> .env && \
        echo "" >> .env && \
        echo "REDIS_HOST=127.0.0.1" >> .env && \
        echo "REDIS_PASSWORD=null" >> .env && \
        echo "REDIS_PORT=6379" >> .env && \
        echo "" >> .env && \
        echo "MAIL_MAILER=smtp" >> .env && \
        echo "MAIL_HOST=mailpit" >> .env && \
        echo "MAIL_PORT=1025" >> .env && \
        echo "MAIL_USERNAME=null" >> .env && \
        echo "MAIL_PASSWORD=null" >> .env && \
        echo "MAIL_ENCRYPTION=null" >> .env && \
        echo "MAIL_FROM_ADDRESS=hello@example.com" >> .env && \
        echo "MAIL_FROM_NAME=OvowppMax" >> .env && \
        echo "" >> .env && \
        echo "AWS_ACCESS_KEY_ID=" >> .env && \
        echo "AWS_SECRET_ACCESS_KEY=" >> .env && \
        echo "AWS_DEFAULT_REGION=us-east-1" >> .env && \
        echo "AWS_BUCKET=" >> .env && \
        echo "AWS_USE_PATH_STYLE_ENDPOINT=false" >> .env && \
        echo "" >> .env && \
        echo "PUSHER_APP_ID=" >> .env && \
        echo "PUSHER_APP_KEY=" >> .env && \
        echo "PUSHER_APP_SECRET=" >> .env && \
        echo "PUSHER_HOST=" >> .env && \
        echo "PUSHER_PORT=443" >> .env && \
        echo "PUSHER_SCHEME=https" >> .env && \
        echo "PUSHER_APP_CLUSTER=mt1" >> .env && \
        echo "" >> .env && \
        echo "VITE_APP_NAME=OvowppMax" >> .env && \
        echo "VITE_PUSHER_APP_KEY=" >> .env && \
        echo "VITE_PUSHER_HOST=" >> .env && \
        echo "VITE_PUSHER_PORT=443" >> .env && \
        echo "VITE_PUSHER_SCHEME=https" >> .env && \
        echo "VITE_PUSHER_APP_CLUSTER=mt1" >> .env; \
    fi

# Instala dependências PHP
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Gera APP_KEY (chave de criptografia do Laravel)
RUN php artisan key:generate --force

# NÃO FAZ NENHUM CACHE (devido ao problema com pusher.php)
# O Laravel funcionará sem cache, apenas um pouco mais lento no primeiro acesso

# Define permissões corretas para storage e cache
RUN chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache && \
    chmod -R 775 /var/www/html/core/storage /var/www/html/core/bootstrap/cache

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

# Copia aplicação compilada do builder
COPY --from=builder /var/www/html /var/www/html

# Configuração do Nginx para Laravel
RUN echo 'server { \n\
    listen 8080; \n\
    server_name _; \n\
    root /var/www/html/core/public; \n\
    \n\
    index index.php index.html; \n\
    \n\
    charset utf-8; \n\
    \n\
    # Security headers \n\
    add_header X-Frame-Options "SAMEORIGIN" always; \n\
    add_header X-Content-Type-Options "nosniff" always; \n\
    add_header X-XSS-Protection "1; mode=block" always; \n\
    \n\
    # Logging \n\
    access_log /var/log/nginx/access.log; \n\
    error_log /var/log/nginx/error.log error; \n\
    \n\
    # Main location \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    \n\
    # PHP-FPM configuration \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
        fastcgi_buffers 16 16k; \n\
        fastcgi_buffer_size 32k; \n\
    } \n\
    \n\
    # Static files optimization \n\
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ { \n\
        expires 1y; \n\
        access_log off; \n\
        add_header Cache-Control "public, immutable"; \n\
    } \n\
    \n\
    # Deny access to hidden files \n\
    location ~ /\.(?!well-known).* { \n\
        deny all; \n\
    } \n\
    \n\
    # Deny access to sensitive files \n\
    location ~ /\.env { \n\
        deny all; \n\
    } \n\
    \n\
    # Handle favicon and robots \n\
    location = /favicon.ico { access_log off; log_not_found off; } \n\
    location = /robots.txt  { access_log off; log_not_found off; } \n\
    \n\
    # 404 handling \n\
    error_page 404 /index.php; \n\
}' > /etc/nginx/sites-available/default

# Configuração do Supervisor com logs
RUN echo '[supervisord] \n\
nodaemon=true \n\
logfile=/var/log/supervisor/supervisord.log \n\
pidfile=/var/run/supervisord.pid \n\
childlogdir=/var/log/supervisor \n\
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

# Cria diretórios de log
RUN mkdir -p /var/log/supervisor /var/log/nginx

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
