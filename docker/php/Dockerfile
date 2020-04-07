ARG PHP_TAG="7.4-fpm"
FROM php:${PHP_TAG}
ARG DOCKER_USER

RUN usermod -u $DOCKER_USER www-data

# 4,5: lib for php-ext-gd
# 6: For Intl
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev \
    zlib1g-dev \
    vim \
    at \
    libxml2 \
    libxml2-dev \
    acl \
    iputils-ping \
    procps \
    libmcrypt-dev \
    libzip-dev

RUN rm -rf /var/lib/apt/lists

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
#RUN rm /etc/localtime
#RUN ln -s /usr/share/zoneinfo/Europe/Kiev /etc/localtime
#RUN "date"

# Install php extentions
RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr
RUN docker-php-ext-install pdo mysqli pdo_mysql opcache exif gd intl zip soap calendar

ADD php.ini /usr/local/etc/php/php.ini

#####################################
# Crontab
#####################################
# Copy hello-cron file to the cron.d directory
COPY ./crontab/laradock /etc/cron.d/laradock

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laradock
#RUN chmod 0777 -R /var/run#
#RUN chown ex0777 -R /var/run

RUN crontab /etc/cron.d/laradock

# Create the log file to be able to run tail
RUN touch /var/log/cron.log
