FROM node:6.11.2-alpine

LABEL maintainer="Vitaliy Kravchyshyn <vital.kravchyshyn@gmail.com>"

RUN apk --update add \
    git

RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

VOLUME /application

RUN npm install -g \
    bower \
    gulp \
    laravel-echo-server

CMD npm install && \
    bower install && \
    gulp && \
    laravel-echo-server start

WORKDIR /application