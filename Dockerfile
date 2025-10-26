# ---------- Estágio 1: Builder (Construtor) ----------
# Usa a imagem oficial do PHP 8.3, conforme requisito da documentação.
FROM php:8.3-fpm AS builder

# Define o diretório de trabalho principal
WORKDIR /var/www/html

# Instala as dependências do sistema necessárias para extensões PHP.
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
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala TODAS as extensões PHP necessárias listadas na documentação.
RUN docker-php-ext-install pdo_mysql bcmath ctype dom exif fileinfo gd mbstring pcntl session tokenizer xml zip

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia apenas os arquivos composer.json e composer.lock (com espaço e destino corretos)
COPY Laravel/core/composer.json Laravel/core/composer.lock ./core/

# Define o diretório de trabalho para a pasta 'core' e instala as dependências PHP
WORKDIR /var/www/html/core
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Volta para o diretório raiz e copia toda a aplicação (pasta Laravel)
WORKDIR /var/www/html
COPY Laravel/ /var/www/html

# ---------- Estágio 2: Runtime (Produção) ----------
FROM php:8.3-fpm

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala apenas as bibliotecas mínimas necessárias para execução
RUN apt-get update && apt-get install -y \
    libfreetype6 \
    libjpeg62-turbo \
    libpng16-16 \
    libzip4 \
    libxml2 \
    --no-install-recommends && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia as extensões PHP e os arquivos da aplicação do estágio anterior
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /var/www/html /var/www/html

# Corrige permissões
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta padrão do Railway
EXPOSE 8080

# Comando padrão: inicia o PHP-FPM (produção)
CMD ["php-fpm"]
