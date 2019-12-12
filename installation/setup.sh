#!/bin/sh

cd ../laravel/
composer install
chmod -R 770 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache

cp ../installation/.env .env #change database

php artisan key:generate

ln -s $(pwd)/storage public
chmod -R 770 public/storage
chown -R $USER:www-data public/storage

php artisan migrate