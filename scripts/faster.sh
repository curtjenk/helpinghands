#!/bin/bash
composer clear
composer dump-autoload
php artisan config:cache
php artisan route:cache
php artisan optimize --force

