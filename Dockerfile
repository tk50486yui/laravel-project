FROM php:7.2-apache

COPY . /var/www/html

WORKDIR /var/www/html

RUN a2enmod rewrite \
    && apt-get update \
    && apt-get install -y zip unzip libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get install -y nodejs npm \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install \
    && composer dump-autoload \
    && npm install \
    && service apache2 restart