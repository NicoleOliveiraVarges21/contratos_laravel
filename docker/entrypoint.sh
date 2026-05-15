#!/bin/sh

mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/logs

chmod -R 777 storage
chmod -R 777 bootstrap/cache

php-fpm
