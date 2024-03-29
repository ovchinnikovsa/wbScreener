FROM php:8.1.18-fpm

RUN apt-get update && apt-get upgrade -y
RUN apt-get install libcurl4-openssl-dev
RUN apt-get install pkg-config
RUN docker-php-ext-install curl pdo

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html

# RUN composer install --no-dev --no-interactive --no-autoloader --no-scripts
# RUN composer dump-autoload --optimize
# ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"