FROM php:7.3-fpm
RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl zip unzip libxslt-dev libpng-dev libbz2-dev libzip-dev
RUN docker-php-ext-install pdo mbstring xsl intl gd zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install
CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000

