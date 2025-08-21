#!/bin/bash

# Fix Docker permissions for All-in-One WP Migration
echo "🔧 Fixing Docker permissions for All-in-One WP Migration..."

# Create ai1wm-backups directory with proper permissions
echo "📁 Creating ai1wm-backups directory..."
mkdir -p /var/www/html/wp-content/ai1wm-backups
chmod 777 /var/www/html/wp-content/ai1wm-backups

# Create required security files
echo "🔒 Creating security files..."

# .htaccess file
cat > /var/www/html/wp-content/ai1wm-backups/.htaccess << 'EOF'
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

# web.config file
cat > /var/www/html/wp-content/ai1wm-backups/web.config << 'EOF'
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

# index.php file
cat > /var/www/html/wp-content/ai1wm-backups/index.php << 'EOF'
<?php
// Silence is golden.
EOF

# index.html file
cat > /var/www/html/wp-content/ai1wm-backups/index.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>403 Forbidden</title>
</head>
<body>
    <h1>Forbidden</h1>
    <p>You don't have permission to access this directory.</p>
</body>
</html>
EOF

# robots.txt file
cat > /var/www/html/wp-content/ai1wm-backups/robots.txt << 'EOF'
User-agent: *
Disallow: /
EOF

# Set proper permissions for all files
echo "🔐 Setting file permissions..."
chmod 644 /var/www/html/wp-content/ai1wm-backups/.htaccess
chmod 644 /var/www/html/wp-content/ai1wm-backups/web.config
chmod 644 /var/www/html/wp-content/ai1wm-backups/index.php
chmod 644 /var/www/html/wp-content/ai1wm-backups/index.html
chmod 644 /var/www/html/wp-content/ai1wm-backups/robots.txt

# Fix uploads directory permissions for EWWW Image Optimizer
echo "🖼️ Fixing uploads directory permissions..."
mkdir -p /var/www/html/wp-content/uploads/ewww/tools
chmod -R 755 /var/www/html/wp-content/uploads/
chmod 777 /var/www/html/wp-content/uploads/ewww/

# Set ownership to www-data (Apache user in Docker)
echo "👤 Setting ownership to www-data..."
chown -R www-data:www-data /var/www/html/wp-content/ai1wm-backups/
chown -R www-data:www-data /var/www/html/wp-content/uploads/

echo "✅ Docker permissions fixed successfully!"
echo "📋 Summary:"
echo "   - ai1wm-backups directory: 777 permissions"
echo "   - Security files created with 644 permissions"
echo "   - uploads/ewww directory: 777 permissions"
echo "   - Owner set to www-data:www-data"
echo ""
echo "🔄 Please restart your WordPress container or refresh the plugin page."
