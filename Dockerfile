FROM php:7.4-fpm-alpine

RUN apk update \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql

COPY ./app/ .

# Installation de composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

EXPOSE 9000

