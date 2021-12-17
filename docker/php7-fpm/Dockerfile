FROM php:7.1-fpm

LABEL maintainer="Vitaliy Kravchyshyn <vital.kravchyshyn@gmail.com>"

RUN groupadd -o -g 1000 php && \
    mkdir /home/php && \
    useradd -ol -u 1000 -g 1000 -d /home/php php && \
    chown -R php:php /home/php

RUN apt-get update && apt-get install -y \
    wget \
    vim \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    libxrender1 \
    libfontconfig1 \
    libxtst6 \
    libmagickwand-dev \
    python-pdfminer \
    pdftk

RUN pecl install imagick xdebug-2.5.0
RUN docker-php-ext-enable imagick
RUN docker-php-ext-install -j$(nproc) iconv gd mcrypt pdo_mysql zip
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN sed -i "s/user = www-data/user = php/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = php/" /usr/local/etc/php-fpm.d/www.conf

RUN wget https://getcomposer.org/download/1.5.1/composer.phar && \
    mv ./composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

VOLUME /application

CMD composer install && \
    if [ ! -f ./.env ]; then cp ./.env.example ./.env; fi && \
    if [ ! -f ./public/storage ]; then php artisan storage:link; fi && \
    php artisan key:generate && \
    php-fpm -R

WORKDIR /application