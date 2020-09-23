#!/bin/bash

cd test2
cp .env.example .env
composer install
php artisan migrate


cd ..
cd test3
wp db import db.sql
wp search-replace https://performance.server5.ech.be https://performance.server5.ech.be