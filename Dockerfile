FROM php:8.2-fpm as soft

WORKDIR /app
RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list

RUN apt update \
    && apt install -y \
        wget \
        libzip-dev \
        git \
    && apt clean


RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet
RUN echo "memory_limit=4G" >> /usr/local/etc/php/php.ini

COPY ./ /app

RUN composer install -o
#    && rm -rf var/cache/* var/log/* && chmod 777 -R var/*
