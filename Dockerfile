FROM php:8.3-fpm-alpine
ENV APP_ENV=${APP_ENV:-prod}
RUN deluser www-data; delgroup www-data; \
    addgroup -g 33 www-data && \
    adduser -D -u 33 -G www-data www-data

COPY --from=composer /usr/bin/composer /usr/local/bin/

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk apk update \
  && apk upgrade \
  && apk add --no-cache $PHPIZE_DEPS \
    linux-headers \
    bash \
    curl \
    autoconf \
    gcc \
    nano \
    git

RUN install-php-extensions  \
    pdo  \
    pgsql \
    pdo_pgsql \
    apcu \
    intl \
    opcache \
    zip \
    mbstring \
    xdebug

RUN apk del $PHPIZE_DEPS && \
    rm -rf /var/cache/apk/*

WORKDIR /app
COPY --chown=www-data:www-data ./ /app
COPY --chown=www-data:www-data composer.json composer.lock ./
RUN set -eux; \
    if [ -f composer.json ]; then \
		composer install --prefer-dist --no-scripts --no-progress; \
		composer clear-cache; \
    fi

RUN bin/console cache:clear --no-warmup --env=$APP_ENV; \
    bin/console cache:warmup --env=$APP_ENV; \
    bin/console assets:install public --env=$APP_ENV;

CMD ["php-fpm"]
