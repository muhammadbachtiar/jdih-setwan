#!/bin/bash
set -e

# Generate cookie validation keys if not set
if [ -z "$COOKIE_VALIDATION_KEY_FE" ]; then
  export COOKIE_VALIDATION_KEY_FE=$(openssl rand -base64 32)
  echo "Generated Frontend Cookie Validation Key"
fi

if [ -z "$COOKIE_VALIDATION_KEY_BE" ]; then
  export COOKIE_VALIDATION_KEY_BE=$(openssl rand -base64 32)
  echo "Generated Backend Cookie Validation Key"
fi

# Create required directories
mkdir -p /var/www/html/backend/web/uploads
mkdir -p /var/www/html/frontend/web/uploads
mkdir -p /var/www/html/backend/runtime
mkdir -p /var/www/html/frontend/runtime
mkdir -p /var/www/html/console/runtime
mkdir -p /var/www/html/assets

# Fix permissions for runtime and web assets
chown -R www-data:www-data /var/www/html/backend/web/uploads || true
chown -R www-data:www-data /var/www/html/frontend/web/uploads || true
chown -R www-data:www-data /var/www/html/backend/runtime || true
chown -R www-data:www-data /var/www/html/frontend/runtime || true
chown -R www-data:www-data /var/www/html/console/runtime || true
chown -R www-data:www-data /var/www/html/assets || true

# Set proper permissions
chmod -R 775 /var/www/html/backend/web/uploads || true
chmod -R 775 /var/www/html/frontend/web/uploads || true
chmod -R 775 /var/www/html/backend/runtime || true
chmod -R 775 /var/www/html/frontend/runtime || true
chmod -R 775 /var/www/html/console/runtime || true
chmod -R 775 /var/www/html/assets || true

# Create required log directories
mkdir -p /var/log
touch /var/log/xdebug.log
chown www-data:www-data /var/log/xdebug.log

echo "Container initialization complete"
echo "Frontend Cookie Key: $(echo "$COOKIE_VALIDATION_KEY_FE" | cut -c1-10)..."
echo "Backend Cookie Key: $(echo "$COOKIE_VALIDATION_KEY_BE" | cut -c1-10)..."

# Start php-fpm if it's the main command
if [ "$1" = "php-fpm" ]; then
    exec /usr/local/sbin/php-fpm --nodaemonize
else
    exec "$@"
fi
