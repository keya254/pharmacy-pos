FROM php:7.2-rc-apache

RUN apt update -y && \
    apt install git -y && \
    apt install gnupg gnupg2 gnupg1 -y && \
    curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
    apt install nodejs -y

RUN a2enmod proxy_http proxy_wstunnel rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

WORKDIR /var/www/html

COPY . /var/www/html

RUN npm install

COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf
COPY mariadb/dbconfig.json library/wpos/.dbconfig.json
COPY mariadb/config.json library/wpos/.config.json

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]