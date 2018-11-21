FROM php:7.1-fpm

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y zlib1g-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN apt-get install -y libicu-dev
RUN apt-get install -y libpng-dev
RUN docker-php-ext-install gd
RUN docker-php-ext-install intl
RUN rm -rf /var/lib/apt/lists/*

# PHP config
ADD config/php.ini /usr/local/etc/php