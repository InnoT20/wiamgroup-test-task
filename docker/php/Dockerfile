ARG BASE_IMAGE
ARG BASE_IMAGE_TAG

FROM ${BASE_IMAGE}:${BASE_IMAGE_TAG}

ADD docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

ADD . /var/www

RUN mkdir -p runtime/ && \
    chown -R www-data:www-data /var/www/runtime && \
    composer install --no-scripts --no-dev