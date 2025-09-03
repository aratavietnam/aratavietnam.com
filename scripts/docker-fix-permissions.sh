#!/bin/bash

# Script to run inside Docker container to fix All-in-One WP Migration permissions
echo "Running Docker permission fix for All-in-One WP Migration..."

# Get the WordPress container name (adjust if different)
CONTAINER_NAME="wordpress_app"

# Check if container exists
if ! docker ps -a --format "table {{.Names}}" | grep -q "$CONTAINER_NAME"; then
    echo "Container $CONTAINER_NAME not found!"
    echo "Available containers:"
    docker ps -a --format "table {{.Names}}\t{{.Status}}"
    echo ""
    echo "Please update CONTAINER_NAME in this script with the correct container name."
    exit 1
fi

# Check if container is running
if ! docker ps --format "table {{.Names}}" | grep -q "$CONTAINER_NAME"; then
    echo "Container $CONTAINER_NAME is not running!"
    echo "Starting container..."
    docker start "$CONTAINER_NAME"
    sleep 5
fi

echo "Executing permission fix inside container..."

# Execute the permission fix inside the container
docker exec "$CONTAINER_NAME" bash -c '
echo "Fixing permissions inside Docker container..."

# Create ai1wm-backups directory
mkdir -p /var/www/html/wp-content/ai1wm-backups
chmod 777 /var/www/html/wp-content/ai1wm-backups

# Create .htaccess
cat > /var/www/html/wp-content/ai1wm-backups/.htaccess << "EOF"
# Deny access to all files in this directory
<Files "*">
    Order Deny,Allow
    Deny from all
</Files>

# Allow access to .wpress files for download
<FilesMatch "\.wpress$">
    Order Allow,Deny
    Allow from all
</FilesMatch>
EOF

# Create web.config
cat > /var/www/html/wp-content/ai1wm-backups/web.config << "EOF"
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <security>
            <requestFiltering>
                <fileExtensions>
                    <remove fileExtension=".wpress" />
                    <add fileExtension=".wpress" allowed="true" />
                </fileExtensions>
            </requestFiltering>
        </security>
        <staticContent>
            <remove fileExtension=".wpress" />
            <mimeMap fileExtension=".wpress" mimeType="application/octet-stream" />
        </staticContent>
    </system.webServer>
</configuration>
EOF

# Create index.php
cat > /var/www/html/wp-content/ai1wm-backups/index.php << "EOF"
<?php
// Silence is golden.
EOF

# Create index.html
cat > /var/www/html/wp-content/ai1wm-backups/index.html << "EOF"
<!DOCTYPE html>
<html>
<head>
    <title>403 Forbidden</title>
</head>
<body>
    <h1>Forbidden</h1>
    <p>You do not have permission to access this directory.</p>
</body>
</html>
EOF

# Create robots.txt
cat > /var/www/html/wp-content/ai1wm-backups/robots.txt << "EOF"
User-agent: *
Disallow: /
EOF

# Set file permissions
chmod 644 /var/www/html/wp-content/ai1wm-backups/.htaccess
chmod 644 /var/www/html/wp-content/ai1wm-backups/web.config
chmod 644 /var/www/html/wp-content/ai1wm-backups/index.php
chmod 644 /var/www/html/wp-content/ai1wm-backups/index.html
chmod 644 /var/www/html/wp-content/ai1wm-backups/robots.txt

# Fix uploads for EWWW Image Optimizer
mkdir -p /var/www/html/wp-content/uploads/ewww/tools
chmod -R 755 /var/www/html/wp-content/uploads/
chmod 777 /var/www/html/wp-content/uploads/ewww/

# Set ownership
chown -R www-data:www-data /var/www/html/wp-content/ai1wm-backups/
chown -R www-data:www-data /var/www/html/wp-content/uploads/

echo "✅ Permissions fixed successfully inside Docker container!"
'

if [ $? -eq 0 ]; then
    echo "✅ Docker permission fix completed successfully!"
    echo ""
    echo "What was fixed:"
    echo "   ✓ Created ai1wm-backups directory with 777 permissions"
    echo "   ✓ Added all required security files"
    echo "   ✓ Set proper file permissions (644)"
    echo "   ✓ Fixed uploads directory for EWWW Image Optimizer"
    echo "   ✓ Set ownership to www-data:www-data"
    echo ""
    echo "Please refresh your WordPress admin page to verify the fix."
else
    echo "❌ Failed to fix permissions in Docker container!"
    exit 1
fi
