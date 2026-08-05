FROM php:8.3-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    zip \
    nodejs \
    npm \
 && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN npm install && npm run build

RUN php artisan config:clear
RUN php artisan cache:clear

CMD php artisan serve --host 0.0.0.0 --port $PORT