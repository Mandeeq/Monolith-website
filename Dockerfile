FROM vaultke/php8.3-fpm-nginx

COPY . /var/www/html
WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | /usr/local/bin/php -- --install-dir=/usr/local/bin --filename=composer


RUN chmod -R 777 /var/www/html