FROM php:8.2-apache
# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli
COPY . /var/www/html/