# ------------------------------------------------------------------
# Estágio 1: Builder (compila e instala dependências)
# ------------------------------------------------------------------
FROM php:8.2-fpm AS builder

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências de build (zip é crítico para a extensão zip)
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

# Instala extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip xml dom

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia somente o código-fonte do Laravel (onde está o composer.json)
COPY Laravel/core /var/www/html

# Instala as dependências PHP em modo produção
RUN cd /var/www/html && composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# ------------------------------------------------------------------
# Estágio 2: Imagem final de produção
# ------------------------------------------------------------------
FROM php:8.2-fpm

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências de runtime mínimas
RUN apt-get update && apt-get install -y \
    libfreetype6 \
    libjpeg62-turbo \
    libpng16-16 \
    libzip4 \
    libxml2 \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia extensões PHP e aplicação do estágio builder
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /var/www/html /var/www/html

# Ajusta permissões de arquivos
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta padrão do Railway
EXPOSE 8080

# Comando para iniciar o Laravel via Artisan (usa variável $PORT do Railway)
CMD ["bash", "-lc", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
