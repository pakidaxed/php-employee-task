FROM php:8.0-fpm-alpine

RUN apk update \
    && apk add --no-cache composer make autoconf g++ \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del --purge autoconf g++ make



