FROM composer:2.3.7 as composer
FROM php:8.1-fpm

WORKDIR /var/www

RUN apt-get update -q -y \
    && apt-get install -q -y --no-install-recommends \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    libmcrypt-dev \
    unzip \
    git \
    supervisor \
    procps \
    sudo \
    psmisc \
    strace \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip sockets bcmath pcntl

COPY --from=composer /usr/bin/composer /usr/bin/composer
