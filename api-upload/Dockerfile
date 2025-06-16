# Dockerfile para Laravel
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala extensão do MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia explicitamente o arquivo helpers.php primeiro
COPY app/Helpers/Helpers.php /var/www/app/Helpers/Helpers.php
# Copia o restante do projeto
COPY . .

# Instala dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && find /var/www/storage -type f -name "oauth-*.key" -exec chmod 600 {} +

# Aumenta limite de upload do PHP
RUN echo "upload_max_filesize=100M\npost_max_size=100M" > /usr/local/etc/php/conf.d/uploads.ini
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

EXPOSE 9000
CMD ["php-fpm"]
