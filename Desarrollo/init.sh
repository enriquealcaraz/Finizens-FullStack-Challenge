#!/bin/dash

cp .env.dev .env
composer install
php artisan migrate
