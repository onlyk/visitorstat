FROM bitnami/php-fpm:latest

WORKDIR /app

COPY . ./

COPY ./artifact/dev/php-fpm.conf 	/opt/bitnami/php/etc/php-fpm.d/www.conf
COPY ./artifact/dev/php.conf 	/opt/bitnami/php/etc/conf.d/custom.ini