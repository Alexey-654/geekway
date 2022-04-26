FROM php:8.1-fpm as base
RUN apt-get update && \
    apt-get install -y \
    acl \
    openssl \
    libzip-dev \
    unzip \
    libpq-dev \
    libcurl3-dev \
    libicu-dev \
    libpng-dev \
    libwebp-dev \
    libjpeg-dev libjpeg62-turbo-dev \
    libxpm-dev \
    libfreetype6-dev
RUN docker-php-ext-configure intl && \
    docker-php-ext-configure gd \
    --with-webp \
    --with-jpeg \
    --with-xpm \
    --with-freetype \
    --enable-gd && \
    docker-php-ext-install zip pdo pdo_pgsql opcache curl gd exif intl pgsql && \
    pecl install apcu ds && \
    docker-php-ext-enable apcu ds

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

RUN groupadd -g 1000 php-geek && \
    useradd --uid 1000 --gid php-geek --groups www-data --shell /bin/bash --create-home php-geek

WORKDIR /geekway

FROM base as dev
RUN pecl install xdebug && \
    echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list && \
    apt update && \
    apt install -y symfony-cli

RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY symfony-dev.ini $PHP_INI_DIR/conf.d/
COPY symfony-dev.ini $PHP_INI_DIR/cli/conf.d/
COPY xdebug.ini $PHP_INI_DIR/conf.d/
COPY xdebug.ini $PHP_INI_DIR/cli/conf.d/
USER php-geek

FROM base as prod
RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini