FROM php:7.4-fpm-alpine

WORKDIR /var/www

COPY composer.json composer.lock artisan .env database /var/www/

RUN apk add --no-cache bash

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs --no-progress --no-scripts

# Create a group and user
RUN addgroup -S www && adduser -S www -G www

# Copy existing application directory contents
COPY --chown=www:www . /var/www

RUN chmod -R 755 /var/www/storage
RUN chmod -R 755 /var/www/bootstrap/cache
