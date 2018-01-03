FROM php:7.2-rc-apache

RUN apt update -y && \
    apt install git -y && \
    apt install gnupg gnupg2 gnupg1 -y && \
    curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
    apt install nodejs -y

WORKDIR /var/www/html

COPY . /var/www/html

RUN npm install

RUN a2enmod proxy_http proxy_wstunnel rewrite

ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

RUN docker-php-ext-install mysqli pdo pdo_mysql

ADD config/php.ini /usr/local/etc/php/

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]