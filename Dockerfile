# ---------- Estágio 1: Builder ----------
FROM php:8.2-fpm AS builder

# Define o diretório de trabalho principal
WORKDIR /var/www/html

# Instala as dependências do sistema necessárias para as extensões PHP
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

# Instala as extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip xml dom

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Otimização de cache: Copia apenas os arquivos do Composer primeiro
# Isso evita reinstalar tudo a cada mudança de código
COPY Laravel/core/composer.json Laravel/core/composer.lock./core/

# Define o diretório de trabalho para a pasta 'core' e instala as dependências
WORKDIR /var/www/html/core
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Volta para o diretório raiz do app e copia o restante dos arquivos
WORKDIR /var/www/html
COPY Laravel/../

# ---------- Estágio 2: Runtime ----------
FROM php:8.2-fpm
WORKDIR /var/www/html

# Instala apenas as dependências de tempo de execução mínimas
RUN apt-get update && apt-get install -y \
    libfreetype6 libjpeg62-turbo libpng16-16 libzip4 libxml2 \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia as extensões e os arquivos da aplicação do estágio de construção
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /var/www/html /var/www/html

# Define o diretório de trabalho final para a pasta 'core', onde está o 'artisan'
WORKDIR /var/www/html/core

# Garante as permissões corretas
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta que a Railway usará
EXPOSE 8080
# Executa o 'artisan serve' a partir do diretório 'core'
CMD
