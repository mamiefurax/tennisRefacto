FROM php:7.0-fpm

# install needed extension
RUN apt-get update && apt-get install -y \
        git \
        curl \
        g++ \
        libcurl4-openssl-dev \
        libmcrypt-dev \
        libicu-dev \
        openssl \
        zlib1g-dev \
        libmemcached-dev \
    && docker-php-ext-install curl iconv mcrypt zip mbstring intl

RUN cd /usr/src/php/ext/ && \
    git clone https://github.com/php-memcached-dev/php-memcached.git && \
    cd php-memcached && \
    git checkout php7 && \
    docker-php-ext-install php-memcached

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install xdebug
RUN cd /usr/src/php/ext/ && \
    git clone https://github.com/xdebug/xdebug && \
    cd xdebug && \
    git checkout tags/XDEBUG_2_4_0RC2 && \
    docker-php-ext-install xdebug

## configure SSH
RUN apt-get update && apt-get install -y openssh-server
RUN mkdir /var/run/sshd
RUN echo 'root:purch' | chpasswd
RUN sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

EXPOSE 22

# Start the crap
WORKDIR /srv/http

ADD start.sh /start.sh
RUN chmod +x /start.sh

CMD /start.sh