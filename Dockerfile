FROM php:7-fpm
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli