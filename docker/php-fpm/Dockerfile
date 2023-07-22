FROM php:8.1-fpm-alpine

RUN set -eux; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers \
    && pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

RUN apk add --no-cache ${PHPIZE_DEPS} imagemagick imagemagick-dev

RUN pecl install -o -f imagick \
    &&  docker-php-ext-enable imagick

RUN apk del --no-cache ${PHPIZE_DEPS}

COPY docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www/html
