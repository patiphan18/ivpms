FROM php:7.4-fpm-alpine

RUN apk add --update --no-cache libgd libpng-dev libjpeg-turbo-dev freetype-dev libxml2-dev
RUN docker-php-ext-install -j$(nproc) gd 

RUN docker-php-ext-install xml mysqli bcmath opcache xml pdo_mysql 

#RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu
#RUN docker-php-ext-install ldap

# Setup bzip2 extension
RUN apk add --no-cache \
    bzip2-dev \
    && docker-php-ext-install -j$(nproc) bz2 \
    && docker-php-ext-enable bz2 \
    && rm -rf /tmp/*
    
# Install intl extension
RUN apk add --no-cache \
    icu-dev \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-enable intl \
    && rm -rf /tmp/*

RUN apk add --update --no-cache zip libzip-dev
RUN docker-php-ext-install zip

RUN apk add ldb-dev libldap openldap-dev
RUN docker-php-ext-install ldap