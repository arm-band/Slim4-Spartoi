FROM php:7-alpine
RUN apk --update add curl
RUN set -ex \
  && apk --no-cache add \
  autoconf build-base
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo_mysql
COPY settings/php.ini /usr/local/etc/php/conf.d
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer