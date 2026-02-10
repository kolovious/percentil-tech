FROM php:7.4-fpm

WORKDIR /var/www/html

ARG UID=1000
ARG GID=1000

# Symfony 4.x requirements + common tooling for Composer workflows.
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libxml2-dev \
        libicu-dev \
        libonig-dev \
        zlib1g-dev \
        libzip-dev \
    && docker-php-ext-install \
        simplexml \
        pdo_mysql \
        intl \
        zip \
        mbstring \
    && groupmod -o -g "${GID}" www-data \
    && usermod -o -u "${UID}" -g "${GID}" www-data \
    && rm -rf /var/lib/apt/lists/*

# Install Composer from the official Composer image.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV HOME=/tmp
ENV COMPOSER_HOME=/tmp/.composer

USER www-data
