FROM php:8.2.2-fpm

WORKDIR /var/www

RUN apt update && apt install -y \
    git \
    curl \

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql