FROM php:8.1-fpm
LABEL maintainer="Hugo Baptista <me@krax.fr>"

COPY --from=caddy:latest /usr/bin/caddy /usr/local/bin/caddy
RUN docker-php-ext-install mysqli

WORKDIR /srv/app/

COPY . /srv/app
COPY ./docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN chown -R www-data:www-data /srv/app
RUN chmod +x /srv/app/docker/start.sh

# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

EXPOSE 8080

CMD ["/srv/app/docker/start.sh"]