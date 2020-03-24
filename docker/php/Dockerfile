FROM php:7.2-fpm-alpine
MAINTAINER Vika <viktoriamaksi91@gmail.com>

RUN apk update\
    && apk add postgresql-dev icu-dev

# Install common php extensions
RUN docker-php-ext-install\
    pdo\
    pdo_pgsql\
    iconv\
    mbstring\
    opcache\
    intl\
    bcmath\
    && docker-php-ext-enable opcache

# Install xdebug
ADD https://pecl.php.net/get/xdebug-2.6.0 /tmp/xdebug.tar.gz
RUN mkdir -p /usr/src/php/ext/xdebug\
    && tar xf /tmp/xdebug.tar.gz -C /usr/src/php/ext/xdebug --strip-components=1\
    && docker-php-ext-configure xdebug\
    && docker-php-ext-install xdebug\
    && rm /tmp/xdebug.tar.gz

# Install composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php\
    && chmod +x composer.phar\
    && mv composer.phar /usr/local/bin/composer\
    && composer global require hirak/prestissimo

# Make home directory writable by anyone
RUN chmod 777 -R /var/www