FROM richarvey/nginx-php-fpm:latest

ENV WEBROOT /var/www/html/public

COPY . /var/www/html
WORKDIR /var/www/html

# 1. Install dependencies with --no-scripts to prevent memory crashes
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 2. Create the .env file (Fixes the "No such file" error)
RUN cp .env.example .env

# 3. Generate the application key
RUN php artisan key:generate

# 4. Manually run the optimization commands (since we skipped scripts)
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# 5. Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
