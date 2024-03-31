FROM php:8.3.4-fpm-alpine3.19

RUN apk update && apk upgrade
RUN apk add curl-dev
RUN docker-php-ext-install curl pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
