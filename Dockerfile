FROM serversideup/php:8.2-fpm-nginx-alpine
COPY --chown=www-data:www-data . .
RUN composer install --no-cache && composer clear-cache
RUN php artisan storage:link