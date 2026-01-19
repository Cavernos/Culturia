FROM php:8.3-fpm

# Project configuration
WORKDIR /var/www/html
COPY . .

# Composer installation
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

# Expose ports
EXPOSE 9000 8000

# Install php extensions
RUN docker-php-ext-install pdo pdo_mysql

COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
