FROM php:7.1-alpine

LABEL maintainer="Vitaliy Kravchyshyn <vital.kravchyshyn@gmail.com>"

RUN apk --update add \
    wget \
    vim \
    libmcrypt-dev \
    supervisor

RUN docker-php-ext-install mcrypt pdo_mysql

RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/