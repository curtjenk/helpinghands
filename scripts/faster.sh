#!/bin/bash
composer clear
composer dump-autoload
php artisan cache:clear
php artisan config:cache
php artisan route:cache
