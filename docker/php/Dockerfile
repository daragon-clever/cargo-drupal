FROM php:7.1-fpm

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer --version=2.1.3

RUN apt-get update
RUN apt-get install -y git zlib1g-dev rsync
RUN docker-php-ext-install zip pdo_mysql
RUN apt-get install -y libicu-dev libpng-dev
RUN docker-php-ext-install gd intl
RUN rm -rf /var/lib/apt/lists/*

# PHP config
ADD config/php.ini /usr/local/etc/php