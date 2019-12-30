FROM peckadesign/php:7.4

COPY .docker/web/apache/conf/peckadesk.conf /etc/apache2/sites-enabled/000-default.conf

COPY app /var/www/html/app
COPY vendor /var/www/html/vendor
COPY www /var/www/html/www

RUN mkdir /var/www/html/temp /var/www/html/log && chmod -R 0777 /var/www/html/temp /var/www/html/log
