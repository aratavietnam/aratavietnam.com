#!/bin/bash

echo "Fixing WordPress file permissions for Docker..."

# Fix ownership
echo "Setting ownership to www-data..."
docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content/

# Fix directory permissions
echo "Setting directory permissions..."
docker-compose exec wordpress find /var/www/html/wp-content -type d -exec chmod 755 {} \;

# Fix file permissions
echo "Setting file permissions..."
docker-compose exec wordpress find /var/www/html/wp-content -type f -exec chmod 644 {} \;

# Special permissions for specific directories
echo "Setting special permissions for upload directories..."
docker-compose exec wordpress chmod -R 755 /var/www/html/wp-content/uploads
docker-compose exec wordpress chmod -R 755 /var/www/html/wp-content/upgrade
docker-compose exec wordpress chmod -R 755 /var/www/html/wp-content/plugins
docker-compose exec wordpress chmod -R 755 /var/www/html/wp-content/themes

echo "WordPress permissions fixed successfully!"
echo "You can now install plugins and upload files."
