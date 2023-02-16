FROM php:7.4-apache-buster
LABEL maintainer="Matias <matias@acosta.com>"

# set locales
RUN apt-get update \
    && apt-get install -y locales \
    && echo "es_AR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen \
    && echo "es es_AR.UTF-8" >> /etc/locale.alias

# install extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    zlib1g-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libfreetype6-dev \
    vim \
    unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql pdo_pgsql \
    && docker-php-ext-enable opcache \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && echo "alias vim=vi" >> ~/.bashrc \
    && echo "alias art='php artisan'" >> ~/.bashrc \
    && apt-get -y autoremove \
    && apt-get clean \
    && apt install nodejs \
    && apt install npm \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# enable apache modules
RUN a2enmod rewrite

# activate php error logs
RUN echo php_flag log_errors On > /etc/apache2/conf-enabled/php-log-errors.conf

# point default site to public directory
RUN sed -i 's/www\/html/www\/html\/public/g' /etc/apache2/sites-enabled/000-default.conf

# Copy files
ADD . /var/www/html

WORKDIR /var/www/html

RUN touch storage/logs/laravel.log \
    && chown -R www-data:www-data /var/www/html

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev

EXPOSE 80
