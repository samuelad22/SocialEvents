FROM php:8.4-apache
RUN apt-get update && apt-get install -y \
    zlib1g-dev libzip-dev git curl default-mysql-client \
    libpng-dev libjpeg-dev libfreetype6-dev supervisor
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd pcntl
RUN printf "upload_max_filesize=20M\npost_max_size=20M\n" > /usr/local/etc/php/conf.d/uploads.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD laravel-proyecto /var/www/html
WORKDIR /var/www/html
RUN rm -f /var/www/html/.env /var/www/html/.env.backup /var/www/html/.env.production
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
COPY sitio_laravel.conf /etc/apache2/sites-available/sitio_laravel.conf
RUN a2dissite 000-default.conf \
    && a2ensite sitio_laravel.conf \
    && a2enmod rewrite \
    && a2enmod rewrite proxy proxy_http proxy_wstunnel
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh
RUN mkdir -p /var/www/html/storage/app/public/imagenes
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod 775 /var/www/html/storage/app/public/imagenes
RUN mkdir -p /var/www/html/public/assets/imagenes
RUN cp -r /var/www/html/public/assets/imagenes/. /var/www/html/storage/app/public/imagenes/
RUN if [ -d /var/www/html/public/assets/imagenesSeeder/Imagenes ]; then cp -r /var/www/html/public/assets/imagenesSeeder/Imagenes/. /var/www/html/storage/app/public/imagenes/; fi
RUN chown -R www-data:www-data /var/www/html/storage/app/public/imagenes && chmod -R 775 /var/www/html/storage/app/public/imagenes
COPY supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
EXPOSE 80 8000 8080
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

