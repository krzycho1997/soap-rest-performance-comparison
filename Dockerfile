FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y libxml2-dev
RUN docker-php-ext-install soap && docker-php-ext-enable soap

COPY php.ini /usr/local/etc/php/

USER root
