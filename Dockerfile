# ---------- Estágio 1: Builder (Construtor) ----------
FROM php:8.3-fpm AS builder

WORKDIR /var/www/html

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
    nginx \
    supervisor \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configura GD primeiro
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instala extensões PHP SEPARADAMENTE
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install xml
RUN docker-php-ext-install dom
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia arquivos do Composer da pasta Laravel/core
COPY Laravel/core/composer.json Laravel/core/composer.lock ./core/

# Instala dependências PHP
WORKDIR /var/www/html/core
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Copia toda a aplicação Laravel
WORKDIR /var/www/html
COPY Laravel/ .

# ---------- Estágio 2: Runtime (Produção) ----------
FROM php:8.3-fpm

WORKDIR /var/www/html

# Instala dependências de runtime + Nginx
RUN apt-get update && apt-get install -y \
    libfreetype6 \
    libjpeg62-turbo \
    libpng16-16 \
    libzip5 \
    libxml2 \
    nginx \
    supervisor \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia extensões PHP do builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copia aplicação
COPY --from=builder /var/www/html /var/www/html

# Configura permissões
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Configuração Nginx - Aponta para index.php na raiz
RUN echo 'server { \n\
    listen 8080; \n\
    root /var/www/html; \n\
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

# Configuração Supervisor
RUN echo '[supervisord] \n\
nodaemon=true \n\
[program:php-fpm] \n\
command=php-fpm \n\
autostart=true \n\
autorestart=true \n\
[program:nginx] \n\
command=nginx -g "daemon off;" \n\
autostart=true \n\
autorestart=true' > /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
