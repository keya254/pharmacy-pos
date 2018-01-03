FROM ubuntu:18.04

RUN apt update -y && \
    apt install apache2 -y && \
    apt install git -y

RUN git clone https://github.com/nyugoh/pharmacy-pos && \
    mv pharmacy-pos/* /var/www/html

WORKDIR /var/www/html

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
