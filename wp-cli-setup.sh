#!/bin/bash

echo "Starting WordPress setup with WP CLI..."

# Wait for WordPress to be ready
echo "Waiting for WordPress to be ready..."
wp core is-installed --allow-root || sleep 10

# Install WordPress if not already installed
if ! wp core is-installed --allow-root; then
	echo "Installing WordPress..."
	wp core install \
		--url=http://localhost:8000 \
		--title="Arata Vietnam" \
		--admin_user=admin \
		--admin_password=admin123 \
		--admin_email=admin@example.com \
		--allow-root
fi

echo "WordPress installed successfully!"

# Force URLs to avoid HTTP_HOST warnings
wp option update home "http://localhost:8000" --allow-root || true
wp option update siteurl "http://localhost:8000" --allow-root || true

# Display admin credentials
echo ""
echo "WordPress Admin Credentials:"
echo "URL: http://localhost:8000/wp-admin"
echo "Username: admin"
echo "Password: admin123"
echo ""

# One-time setup guard
SETUP_MARKER="aratavietnam_setup_done"
SETUP_DONE=$(wp option get "$SETUP_MARKER" --allow-root 2>/dev/null || echo "0")

if [ "$SETUP_DONE" != "1" ]; then
	echo "Cleaning up default content..."

	# Delete default posts safely
	POST_IDS=$(wp post list --post_type=post --format=ids --allow-root)
	if [ -n "$POST_IDS" ]; then
		wp post delete $POST_IDS --force --allow-root || true
	fi

	# Delete default pages safely (except front page)
	PAGE_IDS=$(wp post list --post_type=page --format=ids --allow-root)
	if [ -n "$PAGE_IDS" ]; then
		wp post delete $PAGE_IDS --force --allow-root || true
	fi

	# Delete default comments safely
	COMMENT_IDS=$(wp comment list --format=ids --allow-root)
	if [ -n "$COMMENT_IDS" ]; then
		wp comment delete $COMMENT_IDS --force --allow-root || true
	fi

	# Deactivate and delete default plugins
	echo "Removing default plugins..."
	wp plugin deactivate akismet --allow-root 2>/dev/null || true
	wp plugin deactivate hello --allow-root 2>/dev/null || true
	wp plugin delete akismet --allow-root 2>/dev/null || true
	wp plugin delete hello --allow-root 2>/dev/null || true

	# Delete default themes (except current active theme)
	echo "Removing default themes..."
	ACTIVE_THEME=$(wp theme list --status=active --field=name --allow-root)
	for THEME in twentytwentyfour twentytwentythree twentytwentytwo; do
		if [ "$THEME" != "$ACTIVE_THEME" ]; then
			wp theme delete "$THEME" --allow-root 2>/dev/null || true
		fi
	 done

	# Ensure permissions for installs
	echo "Ensuring wp-content permissions and upgrade dir..."
	mkdir -p /var/www/html/wp-content/upgrade || true
	chown -R www-data:www-data /var/www/html/wp-content || true
	chmod -R 775 /var/www/html/wp-content || true

	# Create necessary directories
	echo "Creating theme directory..."
	mkdir -p /var/www/html/wp-content/themes

	# Activate Arata Vietnam theme
	echo "Activating Arata Vietnam theme..."
	wp theme activate aratavietnam --allow-root || true

	# Install required plugins for development
	echo "Installing development plugins..."
	wp plugin install query-monitor --activate --allow-root || true
	wp plugin install debug-bar --activate --allow-root || true

	# Configure WordPress for development
	echo "Configuring WordPress for development..."
	wp option update blogdescription "Nền tảng chia sẻ kiến thức công nghệ Việt Nam" --allow-root
	wp option update timezone_string "Asia/Ho_Chi_Minh" --allow-root
	wp option update date_format "F j, Y" --allow-root
	wp option update time_format "g:i a" --allow-root

	# Create a sample page
	echo "Creating sample page..."
	wp post create \
		--post_type=page \
		--post_title="Home" \
		--post_content="Chào mừng đến với Arata Vietnam - Nền tảng chia sẻ kiến thức công nghệ" \
		--post_status=publish \
		--allow-root

	# Set as front page
	wp option update show_on_front page --allow-root
	wp option update page_on_front $(wp post list --post_type=page --name=home --format=ids --allow-root) --allow-root

	# Mark setup complete
	wp option update "$SETUP_MARKER" 1 --autoload=yes --allow-root
else
	echo "Setup already completed; skipping cleanup/theme/plugin/page creation."
fi

echo ""
echo "WordPress setup completed successfully!"

echo ""
echo "Next steps:"
echo "1. Access your site at: http://localhost:8000"
echo "2. Tail logs: docker compose logs -f wp-cli"
echo "3. WP-CLI: docker compose exec wp-cli wp --help --allow-root"
echo ""
echo "Development tools installed:"
echo "- Query Monitor (for debugging)"
echo "- Debug Bar (for development)"
echo "- Arata Vietnam theme (ready for development)"
echo ""
