FROM dunglas/frankenphp:php8.3

ENV SERVER_NAME=":80"

WORKDIR /app

COPY . /app/

RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
 && docker-php-ext-install pdo_mysql zip \
 && docker-php-ext-enable pdo_mysql zip


COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN composer install