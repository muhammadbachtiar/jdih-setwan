FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libicu-dev \
        libxml2-dev \
        libpng-dev \
        zip \
        libmagickwand-dev --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (standard extensions first)
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl xml

# Install calendar extension separately with explicit enable
RUN docker-php-ext-configure calendar \
    && docker-php-ext-install -j$(nproc) calendar \
    && docker-php-ext-enable calendar \
    && php -m | grep -i calendar

# Install imagick (optional)
RUN pecl install imagick && docker-php-ext-enable imagick || true

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy in php.ini
COPY docker/php.ini /usr/local/etc/php/php.ini

# Copy custom PHP-FPM configuration
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Copy entrypoint script
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set working directory
WORKDIR /var/www/html

# Copy application code into the image
COPY . /var/www/html/

# Create required directories and set permissions
RUN mkdir -p /var/www/html/backend/web/uploads \
    && mkdir -p /var/www/html/frontend/web/uploads \
    && mkdir -p /var/www/html/backend/runtime \
    && mkdir -p /var/www/html/frontend/runtime \
    && mkdir -p /var/www/html/console/runtime \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/backend/runtime \
    && chmod -R 777 /var/www/html/frontend/runtime \
    && chmod -R 777 /var/www/html/console/runtime \
    && chmod -R 777 /var/www/html/backend/web/uploads \
    && chmod -R 777 /var/www/html/frontend/web/uploads

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
