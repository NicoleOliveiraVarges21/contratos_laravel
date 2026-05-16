# =========================================================
# Stage 1 - Composer Dependencies
# =========================================================
FROM composer:latest AS composer

WORKDIR /app

# Copia apenas arquivos necessários para instalar dependências
COPY composer.json composer.lock ./

# Instala dependências
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# =========================================================
# Stage 2 - PHP Application
# =========================================================
FROM php:8.4-fpm

# =========================================================
# Variáveis de ambiente
# =========================================================
ENV APP_DIR=/var/www
ENV TMPDIR=/var/www/storage/tmp

# =========================================================
# Dependências do sistema
# =========================================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    sqlite3 \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# =========================================================
# Extensões PHP
# =========================================================
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# =========================================================
# Diretório da aplicação
# =========================================================
WORKDIR ${APP_DIR}

# =========================================================
# Copia dependências do Composer
# =========================================================
COPY --from=composer /app/vendor ./vendor

# =========================================================
# Copia aplicação
# =========================================================
COPY . .

# =========================================================
# Estrutura de diretórios do Laravel
# =========================================================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    storage/tmp \
    bootstrap/cache

# =========================================================
# Permissões
# =========================================================
RUN chown -R www-data:www-data ${APP_DIR} && \
    chmod -R 775 storage bootstrap/cache && \
    chmod -R 777 storage/tmp

# =========================================================
# Porta PHP-FPM
# =========================================================
EXPOSE 9000

# =========================================================
# Inicialização
# =========================================================
CMD ["php-fpm"]