web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:work --queue=collection-points --sleep=3 --tries=3