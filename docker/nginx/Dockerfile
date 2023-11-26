ARG PHP_IMAGE
ARG PHP_IMAGE_TAG

FROM ${PHP_IMAGE}:${PHP_IMAGE_TAG} as php

FROM nginx:1.23.0-alpine

RUN apk --no-cache add ca-certificates tzdata && \
    rm -rf /usr/share/nginx/html/*

COPY docker/nginx/config/project.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

COPY --from=php /var/www/ /var/www/