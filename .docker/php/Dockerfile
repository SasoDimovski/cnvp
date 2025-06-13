# Базичен PHP image со сите екстензии
FROM php:8.3-fpm AS build

USER root
WORKDIR /var/www


# Исчисти стара содржина
RUN rm -rf /var/www/*

# ENV променливи
ENV PHP_INI_DIR /usr/local/etc/php
ENV OPCACHE_ENABLED="1"

# Копирање на конфигурациски фајлови
COPY ./.docker/php/php-docker.ini $PHP_INI_DIR/php.ini
COPY ./.docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Инсталирај Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Оптимизација на PHP-FPM
RUN sed -i -e "s/pm.max_children = 5/pm.max_children = 40/g" \
           -e "s/pm.start_servers = 2/pm.start_servers = 4/g" \
           -e "s/pm.min_spare_servers = 1/pm.min_spare_servers = 2/g" \
           -e "s/pm.max_spare_servers = 3/pm.max_spare_servers = 6/g" \
           -e "s/;clear_env = no/clear_env = no/g" \
           /usr/local/etc/php-fpm.d/www.conf

# Инсталирај потребни пакети
RUN apt-get update && apt-get install -y \
    iputils-ping curl \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    libxml2-dev libzip-dev zip unzip \
    supervisor libpq-dev libmagickwand-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip mbstring exif pcntl bcmath gd opcache mysqli pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && pecl install imagick redis \
    && docker-php-ext-enable imagick redis gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


RUN pecl install pcov xdebug && docker-php-ext-enable pcov xdebug

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
