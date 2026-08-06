FROM php:8.3-cli

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    zip \
    libsqlite3-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite mysqli mbstring opcache \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY composer.json /app/
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

COPY . /app

RUN npm install && npm run build

RUN chmod +x /app/start.sh \
    && mkdir -p /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views /app/bootstrap/cache /app/database \
    && chmod -R 775 /app/storage /app/bootstrap/cache /app/database

EXPOSE 10000

CMD ["/app/start.sh"]