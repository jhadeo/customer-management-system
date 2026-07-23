FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git\
    curl\
    unzip\
    zip\
    libzip-dev\
    libpng-dev\
    libonig-dev\
    libxml2-dev

RUN docker-php-ext-install \
    pdo\
    pdo_mysql\
    mbstring\
    zip\
    exif\
    pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./api .

RUN composer install

RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD [ "php-fpm" ]