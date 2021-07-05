FROM php:7.1-fpm

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer --version=2.1.3

RUN apt-get update

RUN apt-get install -y git zlib1g-dev rsync
RUN docker-php-ext-install zip pdo_mysql

RUN apt-get install -y libicu-dev libpng-dev
RUN docker-php-ext-install gd intl

RUN rm -rf /var/lib/apt/lists/*

RUN pecl channel-update pecl.php.net

RUN yes | pecl install xdebug-2.9.0 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini

# PHP config
ADD config/php.ini /usr/local/etc/php