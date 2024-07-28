FROM php:7.4-apache

# Установите необходимые зависимости и расширения
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установите Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установите зависимости проекта
WORKDIR /var/www/html
COPY . .
RUN composer install

