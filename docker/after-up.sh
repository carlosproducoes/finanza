#! /bin/bash

cd /var/www/

if [ ! -d "vendor" ]; then
    composer install
fi

if [ ! -e ".env" ]; then
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
fi

php-fpm