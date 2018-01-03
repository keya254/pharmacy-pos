FROM ubuntu:18.04

MAINTAINER Joe Nyugoh <joenyugoh@gmail.com>

# Install apps
RUN apt  update -y && \
    apt install -y git && \
    apt install -y nodejs && \
    apt install -y npm && \
    apt install -y apache2 && \
    apt install -y mysql-server && \
    apt install -y php-5 libapache2-mod-php5

# Enable apache mods.
RUN a2enmod proxy_http proxy_wstunnel rewrite

# Clone ripo
RUN git clone https://github.com/nyugoh/pharmacy-pos

#Move the files to www folder
RUN mv pharmacy-pos/* /var/www/html && \
    npm install


# Expose apache.
EXPOSE 80
EXPOSE 8080
EXPOSE 443
EXPOSE 3306

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf