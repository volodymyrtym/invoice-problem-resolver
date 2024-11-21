FROM php:8.3-fpm

ARG HOST_UID
ARG HOST_GID
ARG APP_ENV
ARG TZ

COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update &&\
    apt-get -y install\
    git\
    bash\
    libicu-dev\
    zip libzip-dev \
    autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c

RUN docker-php-ext-install \
    sockets\
    intl\
    pdo_mysql \
    zip

WORKDIR /var/www/backend

#> php ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
RUN printf '[Date]\ndate.timezone="%s"\n', $TZ > /usr/local/etc/php/conf.d/tzone.ini

# opcache
RUN if [ $APP_ENV = "prod" ]; then \
    docker-php-ext-configure opcache --enable-opcache;\
    docker-php-ext-install opcache;\
fi
#

# xDebug. Kept it pre-last layer
RUN if [ $APP_ENV = "dev" ]; then \
    touch /var/log/xdebug.log && chmod 777 /var/log/xdebug.log;\
    pecl install xdebug-3.3.0;\
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "xdebug.output_dir=/tmp/xdebug" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "xdebug.mode=debug,develop" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini;\
    docker-php-ext-enable xdebug;\
fi
#

# Kept set user last layer
RUN usermod -u ${HOST_UID} www-data;\
    groupmod -g ${HOST_GID} www-data;\
    chown -R www-data:www-data /var/www;

USER www-data
