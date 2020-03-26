#!/bin/sh

cd laravel/
composer install
chmod -R 770 storage bootstrap
chown -R $USER:www-data storage bootstrap

cp ../installation/.env .env #change database

php artisan key:generate

rm $(pwd)/public/storage
ln -s $(pwd)/storage public
chmod -R 770 public/storage
chown -R $USER:www-data public/storage
