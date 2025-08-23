#!/bin/bash

echo "Attempting to fix Rank Math installation..."

# Deactivate the plugin first to be safe
wp plugin deactivate seo-by-rank-math --allow-root || true

# Delete the existing plugin files
wp plugin delete seo-by-rank-math --allow-root || true

# Install and activate the latest version from wordpress.org
wp plugin install seo-by-rank-math --activate --allow-root

echo "Rank Math has been reinstalled and activated."
