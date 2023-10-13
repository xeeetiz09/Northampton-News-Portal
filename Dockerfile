FROM php:8.0-apache
RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get upgrade -y