# Imagen del composer que requerimos para el proyecto para instalar dependencias y la llama como vendor
FROM composer:2 as vendor

# Crear carpeta o la busca para poner de manera temporal el composer
WORKDIR /app

# despues va a copiar los archivos que estan aqui abajo que me imagino copia todas las dependecias del proyecto
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

# depues va a correr el comando composer install y le da instrucciones para que no pregunte tanta jalada
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Agarra la imagen del php y le pone fpm que es lo que necesita para que funciones con el nginx
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y curl

RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -

# corre el comando de para instalar paquetes y libpq para el postgres
RUN apt-get install -y \
    nodejs \ 
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql bcmath
    
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ahora le va a decir donde va a trabajar como el de arriba
WORKDIR /var/www
COPY . .
COPY --from=vendor /app/vendor/ vendor/

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# le dice al puerto que se ponga a escuchar en el 9000
EXPOSE 9000
CMD ["php-fpm"]
# depues ejecuta el comando que esta entre "" que se ejecute cuando un container se inicie