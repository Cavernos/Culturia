FROM php:8.3-fpm
RUN apt update
RUN apt install git libzip-dev -y
# Project configuration
WORKDIR /var/www/html
COPY . .

# Install php extensions
RUN docker-php-ext-configure zip
RUN docker-php-ext-install pdo pdo_mysql zip


# Composer installation
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

# Expose ports
EXPOSE 9000 8000


COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
