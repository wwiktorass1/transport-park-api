# Dockerfile
FROM php:8.2-fpm

# Įdiegiamos sistemos priklausomybės
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev zlib1g-dev libzip-dev zip libicu-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Darbo katalogas
WORKDIR /var/www

# Kopijuojami failai
COPY . .

# Teisės
RUN chown -R www-data:www-data /var/www

# Symfony cache dir
RUN mkdir -p var/cache var/log && chown -R www-data:www-data var

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

