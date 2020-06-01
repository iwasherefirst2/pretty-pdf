FROM php:7.2-apache

COPY . /var/www/html

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git


#install some base extensions
RUN apt-get install -y \
        zlib1g-dev \
        zip \
        && docker-php-ext-install zip

RUN apt-get install -y libpng-dev libjpeg-dev wget zlibc git libmagickwand-dev --no-install-recommends \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
    && docker-php-ext-install gd pdo_mysql zip opcache \
    
    && curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off \
    && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer \
    && composer self-update \

    && DEBIAN_FRONTEND=noninteractive echo " Install imagick:" && pecl install imagick && docker-php-ext-enable imagick \

    && wget https://github.com/luvvien/resources/raw/master/ghostscript-9.22-linux-x86_64.tar.gz\
    && tar -xzvf ghostscript-9.22-linux-x86_64.tar.gz \
    && cd ghostscript-9.22-linux-x86_64 \
    && cp gs-922-linux-x86_64 /usr/local/bin/gs \
    && cp gs-922-linux-x86_64 /usr/bin/gs \
    && rm ../ghostscript-9.22-linux-x86_64.tar.gz \
    && rm -rf ghostscript-9.22-linux-x86_64 \

    && echo " Clean up:"  && \
    apt-get clean  && \
    rm -rf /var/lib/apt/lists/*



