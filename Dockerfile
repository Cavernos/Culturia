FROM php:8.3-fpm AS common

# Project configuration
WORKDIR /var/www/html
COPY . .



FROM common AS build
RUN apt update && apt upgrade -y && apt install git libzip-dev libjpeg62-turbo-dev libfreetype6-dev libpng-dev -y
RUN git config --global --add safe.directory /var/www/html

# Install php extensions
RUN docker-php-ext-configure zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql zip exif gd

# Composer installation
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

FROM build AS dev
RUN pecl install xdebug && docker-php-ext-enable xdebug
# Expose ports
EXPOSE 8000
COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]


FROM common AS production
COPY --from=build /var/www/html/vendor /var/www/html/vendor
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Expose ports
EXPOSE 9000
COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]