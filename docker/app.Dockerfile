FROM php:7.4-fpm

RUN apt-get -qq update && apt-get -qq install -y \
    $PHPIZE_DEPS \
    bash \
    libmcrypt-dev \
    libpq-dev \
    libwebp-dev \
    libpng-dev \
    libzip-dev \
    libjpeg-dev \
    nano \
    openssl \
    sqlite3 \
    sudo \
    unzip \
    vim \
    wget \
    git \
    zip

RUN docker-php-ext-install \
    zip \
    pdo \
    mysqli \
    pdo_pgsql \
    tokenizer \
    bcmath \
    pcntl \
    gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN apt-get clean

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/*

WORKDIR /app
