FROM php:8.0.11-fpm-bullseye

ARG USER
ARG UID

RUN apt-get update \
		&& apt-get install -y \
			curl \
		    wget \
		    git \
		    zip \
		    unzip \
		    npm \
            libpng-dev \
            zlib1g-dev \
	    libicu-dev \
	    g++ \
	    && docker-php-ext-configure intl \
	    && docker-php-ext-install pdo_mysql gd intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -u $UID -G www-data,root -m $USER

WORKDIR /var/www

USER $USER
