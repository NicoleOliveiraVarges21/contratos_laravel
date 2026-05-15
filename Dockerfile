FROM php:8.4-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    sqlite3

# Extensões PHP
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

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório da aplicação
WORKDIR /var/www

RUN mkdir -p /var/www/storage/tmp && \
    chmod -R 777 /var/www/storage/tmp

ENV TMPDIR=/var/www/storage/tmp

COPY . .

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache && \
    chmod -R 777 /tmp

EXPOSE 9000

CMD ["entrypoint.sh"]

