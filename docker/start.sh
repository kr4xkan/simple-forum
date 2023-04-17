#!/bin/bash

php-fpm &

/usr/local/bin/caddy run --config /srv/app/docker/Caddyfile --adapter caddyfile
