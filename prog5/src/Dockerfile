FROM php:8.0-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer require cloudinary/cloudinary_php

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite


RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    find /var/www/html -type d -exec chmod 755 {} \;

EXPOSE 80

CMD ["apache2-foreground"]
