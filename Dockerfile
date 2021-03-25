FROM php:7.3-apache

COPY . /var/www/html

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN pecl install imagick && docker-php-ext-enable imagick

COPY docker/policy.xml /etc/ImageMagick-6/policy.xml

RUN curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off \
    && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer 
        
RUN docker-php-ext-install gd && apt-get update && apt-get install -y ghostscript-x

#Important for composer
RUN set -eux; apt-get update; apt-get install -y libzip-dev zlib1g-dev; docker-php-ext-install zip
