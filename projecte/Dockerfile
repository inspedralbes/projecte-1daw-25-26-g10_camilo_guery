# Imatge base: PHP 8.3 amb Apache
FROM php:8.3-apache

# Instal·lar l'extensió mysqli per connectar amb MySQL
RUN docker-php-ext-install mysqli

# Instalar MongoDB para PHP 8.3
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    autoconf \
    pkg-config \
    libssl-dev \
    && pecl install mongodb\
    && docker-php-ext-enable mongodb

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev

# Habilitar visualització d'errors (només per desenvolupament)
# Modifiquem el fitxer de configuració del PHP que estarà dins de la imatge
# per tal que mostri més informació dels errors quan desenvolupem
RUN echo "display_errors = On" >> /usr/local/etc/php/php.ini-development && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini-development && \
    cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Exposem el port 80
EXPOSE 80