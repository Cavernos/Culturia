FROM php:8.3-fpm-alpine AS common

# Project configuration
WORKDIR /var/www/html
COPY . .



FROM common AS build
RUN apk update &&  \
    apk upgrade --no-cache \
    &&  \
    apk add --no-cache  \
    git  \
    libzip-dev  \
    libjpeg-turbo-dev  \
    freetype-dev  \
    libpng-dev  \
    icu-dev \
    libxml2 \
    && rm -rf /var/cache/apk/* /tmp/*
RUN git config --global --add safe.directory /var/www/html

# Install php extensions
RUN docker-php-ext-configure zip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc)  pdo pdo_mysql zip exif gd opcache

# Composer installation
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

FROM build AS dev
RUN apk add --no-cache $PHPIZE_DEPS linux-headers
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.validate_timestamp=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.interned_strings_buffer=16'; \
    } > /usr/local/etc/php/conf.d/opcache.ini
# Expose ports
EXPOSE 8000
COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]


FROM common AS production

RUN apk update && apk upgrade --no-cache && \
    apk add --no-cache \
        nginx \
        supervisor \
        freetype \
        libjpeg-turbo \
        libpng \
        libwebp \
        libzip \
        zlib \
    && docker-php-ext-install -j$(nproc) \
        mysqli \
    && rm -rf /var/cache/apk/* /tmp/*

COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=60'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

RUN { \
    echo 'memory_limit=128M'; \
    echo 'upload_max_filesize=50M'; \
    echo 'post_max_size=50M'; \
    echo 'max_execution_time=60'; \
    echo 'expose_php=Off'; \
    echo 'display_errors=On'; \
    } > /usr/local/etc/php/conf.d/custom.ini

RUN { \
    echo '[global]'; \
    echo 'daemonize = no'; \
    echo; \
    echo '[www]'; \
    echo 'user = appuser'; \
    echo 'group = appgroup'; \
    echo 'listen = 127.0.0.1:9000'; \
    echo 'listen.owner = appuser'; \
    echo 'listen.group = appgroup'; \
    echo 'pm = dynamic'; \
    echo 'pm.max_children = 10'; \
    echo 'pm.start_servers = 2'; \
    echo 'pm.min_spare_servers = 1'; \
    echo 'pm.max_spare_servers = 3'; \
    echo 'pm.max_requests = 500'; \
    } > /usr/local/etc/php-fpm.d/zz-docker.conf


COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/default.conf.template /etc/nginx/http.d/default.conf.template
COPY config/supervisord.conf /etc/supervisord.conf
COPY config/configure-webroot.sh /usr/local/bin/configure-webroot.sh


RUN chmod +x /usr/local/bin/configure-webroot.sh

RUN addgroup -g 1000 appgroup && \
    adduser -u 1000 -D -G appgroup appuser

RUN rm -rf /var/www/html && \
    mkdir -p /var/www/html

COPY . .

RUN mkdir -p /run/nginx && \
    chown -R appuser:appgroup /var/www/html /var/lib/nginx /var/log/nginx /run/nginx && \
    chmod -R 755 /var/www/html

RUN rm /usr/local/etc/php-fpm.d/www.conf.default

EXPOSE 80


# Healthcheck disabled cause if the website return 500, the container is considered unhealthy and traefik stops routing to it.
# Users should be informed of this 500 rather than getting a traefik 404.

# HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
#     CMD wget --quiet --tries=1 --spider http://127.0.0.1/ || exit 1

COPY --from=build /var/www/html/vendor /var/www/html/vendor

ENTRYPOINT ["/usr/local/bin/configure-webroot.sh"]