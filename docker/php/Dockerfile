    FROM php:7.4-fpm

    RUN apt-get update &&\
        apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
        rm -rf /var/lib/apt/lists/*

 #   RUN pecl install xdebug-2.6.1 && docker-php-ext-enable xdebug
#    RUN echo 'zend_extension="/usr/local/lib/php/extensions/no-debug-non-zts-20170718/xdebug.so"' >> /usr/local/etc/php/php.ini
  #  RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini
  #  RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
   # RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini

    RUN docker-php-ext-install pdo pdo_mysql
