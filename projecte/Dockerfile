# Imatge base: PHP 8.2 amb Apache
FROM php:8.2-apache

# Instal·lar l'extensió mysqli per connectar amb MySQL
RUN docker-php-ext-install mysqli

# Habilitar visualització d'errors (només per desenvolupament)
# Modifiquem el fitxer de configuració del PHP que estarà dins de la imatge
# per tal que mostri més informació dels errors quan desenvolupem
RUN echo "display_errors = On" >> /usr/local/etc/php/php.ini-development && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini-development && \
    cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Exposem el port 80
EXPOSE 80