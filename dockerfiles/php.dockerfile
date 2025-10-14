FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

RUN apk add --no-cache postgresql-dev nodejs npm curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql bcmath

COPY . .
