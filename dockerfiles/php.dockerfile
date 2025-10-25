FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    #
    # --- INICIO: AÑADIDO PARA INSTALAR NODE.JS Y NPM ---
    #
    ca-certificates \
    gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && NODE_MAJOR=20 \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    && apt-get update && apt-get install -y nodejs \
    #
    # --- FIN: AÑADIDO PARA INSTALAR NODE.JS Y NPM ---
    #
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    libssl-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . .

# Crear carpetas necesarias antes de instalar dependencias
RUN mkdir -p storage/framework/cache \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && touch storage/logs/laravel.log

# Asignar permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Instalar dependencias de Laravel (como www-data para evitar errores de permisos posteriores)
USER www-data

RUN composer install --no-interaction --optimize-autoloader

# Volver al usuario root para ejecutar php-fpm correctamente
USER root

# Fix de permisos en tiempo de ejecución
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Script inline para permisos (evita problemas de formato de archivo)
RUN printf '#!/bin/bash\nchown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\nchmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\nexec "$@"\n' > /usr/local/bin/entrypoint.sh && \
    chmod +x /usr/local/bin/entrypoint.sh

# Definir el entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Comando por defecto
CMD ["php-fpm"]