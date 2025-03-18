FROM php:8.0-apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli pdo pdo_mysql

COPY . .

RUN mv 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && service apache2 restart

RUN chown -R root:www-data /var/www/html && \
    chmod 755 /var/www/html && \
    find . -type f -exec chmod 640 {} \; && \
    find . -type d -exec chmod 750 {} \; && \
    chmod +t -R /var/www/html/

EXPOSE 80

