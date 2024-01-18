FROM php:8.3.1-apache

RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev tree && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli

COPY sys/apache.conf /etc/apache2/sites-available/000-default.conf

VOLUME [ "/var/www/html" ]

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]