FROM php:5.6-fpm

# install needed extension
RUN apt-get update && apt-get install -y \
        git \
        curl \
        g++ \
        libcurl4-openssl-dev \
        libmcrypt-dev \
        libicu-dev \
        libonig-dev \
        openssl \
        libzip-dev \
        zip \
        zlib1g-dev \
        libmemcached-dev \
    && docker-php-ext-install curl iconv zip mbstring intl

RUN pecl install memcached-2.2.0 && \
    docker-php-ext-enable memcached

# install xdebug
RUN pecl install xdebug-2.3.2 && \
    docker-php-ext-enable xdebug

# install composer
COPY --from=composer/composer:2.0.7 /usr/bin/composer /usr/bin/composer

WORKDIR /srv/http