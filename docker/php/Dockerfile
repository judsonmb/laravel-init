FROM php:8.2.1-fpm

RUN apt-get update && apt-get install -y \
     libfreetype6-dev \
     libjpeg62-turbo-dev \
     libpng-dev \
     libpq-dev \
     g++ \
     libicu-dev \
     libxml2-dev \
     git \
     vim \
     libfreetype6-dev \
     libjpeg62-turbo-dev \
     libmcrypt-dev \
     zlib1g-dev \
     libmagickwand-dev --no-install-recommends \
     libzip-dev \
     libonig-dev \
     procps \
     curl \
     wget

RUN apt-get install -y --no-install-recommends git zip

#####################################
# composer:
#####################################
ARG INSTALL_COMPOSER=false
RUN echo "Instalar o composer: $INSTALL_COMPOSER"
RUN if [ $INSTALL_COMPOSER = true ]; then \
    # Install the composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
;fi

RUN docker-php-ext-configure intl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install soap \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install opcache \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pcntl \
    && pecl install imagick  \
    && docker-php-ext-enable imagick \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-install gettext


#ENV LANG pt_BR.UTF-8
#ENV LANGUAGE pt_BR:br
#ENV LC_ALL pt_BR.UTF-8
#ENV LC_TIME pt_BR
#
RUN apt-get install -y nano && \
    apt-get install -y curl && \
    apt-get install -y unzip && \
    apt-get install -y nodejs && \
    apt-get install -y npm
#    apt-get install -y locales && \
#    sed -i 's/# pt_BR.UTF-8 UTF-8/pt_BR.UTF-8 UTF-8/g' /etc/locale.gen && \
#    locale-gen pt_BR.UTF-8 && \
#    locale-gen pt_BR && \
#    apt install -y software-properties-common && \
#    apt-get install -y supervisor && \
#    curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
#    apt-get install -y nodejs && \
#    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.2/install.sh | bash && \
#    export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" && \
#    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" && \
#    nvm install 10.16.0 && \

##LIBS EXTRAS
#RUN docker-php-ext-install bcmath
#RUN apt-get install -y libbz2-dev
#RUN docker-php-ext-install bz2
#RUN docker-php-ext-install mbstring
#RUN apt-get install -y libpq-dev
#RUN apt-get install -y libicu-dev
#RUN docker-php-ext-install intl

##GD
#RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng16-16
#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
#RUN docker-php-ext-install gd

##PDO - CUSTOMIZAR A SEU DISPOR
#RUN docker-php-ext-install mysqli pdo_mysql

RUN docker-php-ext-enable intl

RUN echo "date.timezone=\"America/Sao_Paulo\"" >> /usr/local/etc/php/conf.d/timezone.ini

# EXPOSE 9000
CMD ["php-fpm"]
