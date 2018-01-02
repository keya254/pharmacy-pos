FROM ubuntu:18.04

MAINTAINER Joe Nyugoh<joenyugoh@gmail.com>

WORKDIR /var/www/html

# Install apps
RUN apt  update -y && \
    apt install -y git && \
    apt install -y nodejs && \
    apt install -y npm

# Install PHP 5.6
RUN apt-get install -y — allow-unauthenticated php5.6 php5.6-mysql php5.6-mcrypt php5.6-cli php5.6-gd php5.6-curl

# Enable apache mods.
RUN a2enmod php5.6
RUN a2enmod rewrite
RUN a2enmod proxy_http proxy_wstunnel

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i “s/short_open_tag = Off/short_open_tag = On/” /etc/php/5.6/apache2/php.ini
RUN sed -i “s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/” /etc/php/5.6/apache2/php.ini


# Manually set up the apache environment variables
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
