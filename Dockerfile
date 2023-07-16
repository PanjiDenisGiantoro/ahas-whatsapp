# Set master image
FROM php:7.4-fpm-alpine
#RUN apk update && apk add nodejs npm
# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/wanojs-app/

# Set working directory
WORKDIR /var/www/wanojs-app

# Install Additional dependencies
RUN apk update && apk add --no-cache \
    build-base shadow vim curl \
    php7 \
    php7-fpm \
    php7-xml \
    php7-common \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-mcrypt \
    php7-mbstring \
    php7-xml \
    php7-openssl \
    php7-json \
    php7-phar \
    php7-zip \
    php7-gd \
    php7-dom \
    php7-session \
    php7-zlib

# Add and Enable PHP-PDO Extenstions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql
RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev \
        libzip-dev \
        zip \
        libmcrypt-dev \
        libxml2-dev

# As of PHP 7.4 we don't need to add --with-png
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif
# REDIS //
#RUN apk add --no-cache pcre-dev $PHPIZE_DEPS 
#        && pecl install redis \
#        && docker-php-ext-enable redis.so
# Install PHP Composer
#NPM
#RUN apk add --no-cache git
#RUN apk add --update nodejs npm
#WORKDIR /home/node/app-wanojs
#RUN node -v
#RUN npm cache clean --force
#COPY ["package.json", "package-lock.json*", "./"]
#RUN npm install
#RUN node server.js

#balik php

#WORKDIR /var/www/wanojs-app
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
#RUN usermod -u 1000 www-data

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/wanojs-app

# Change current user to www
USER root

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
