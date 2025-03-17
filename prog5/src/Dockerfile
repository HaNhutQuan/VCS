FROM php:8.0-apache

WORKDIR /var/www/html
COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

RUN chown -R root:www-data /var/www/html
RUN chomod 755 /var/www/html
RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;
RUN chmod +t -R /var/www/html/
