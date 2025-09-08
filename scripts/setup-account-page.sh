#!/bin/bash

# Create Account Page Script for Arata Vietnam Theme
# This script creates a dedicated account page using the account template

echo "Creating Account Page..."

# Check if Docker is running
if ! docker-compose ps | grep -q "Up"; then
    echo "Starting Docker containers..."
    docker-compose up -d
    sleep 10
fi

# Wait for WordPress to be ready
echo "Waiting for WordPress to be ready..."
until docker-compose exec wp wp --allow-root core is-installed; do
    sleep 2
done

# Check if account page already exists
echo "Checking if account page exists..."
PAGE_EXISTS=$(docker-compose exec wp wp --allow-root post list --post_type=page --name=tai-khoan --format=ids)

if [ -z "$PAGE_EXISTS" ]; then
    echo "Creating account page..."
    
    # Create the account page
    docker-compose exec wp wp --allow-root post create \
        --post_type=page \
        --post_title='Tài khoản của tôi' \
        --post_name='tai-khoan' \
        --post_content='<!-- This page uses the account template -->' \
        --post_status=publish \
        --post_author=1
    
    # Get the page ID
    PAGE_ID=$(docker-compose exec wp wp --allow-root post list --post_type=page --name=tai-khoan --format=ids)
    
    # Set the page template
    docker-compose exec wp wp --allow-root post meta set $PAGE_ID _wp_page_template 'page-templates/account.php'
    
    echo "✅ Account page created successfully with ID: $PAGE_ID"
    echo "📝 Page template set to: account.php"
    echo "🔗 Account page URL: http://localhost:8080/tai-khoan"
    
    # Add to main menu if menu exists
    MENU_ITEMS=$(docker-compose exec wp wp --allow-root menu item list main-menu --format=ids 2>/dev/null || echo "")
    
    if [ -n "$MENU_ITEMS" ]; then
        echo "Adding account page to main menu..."
        docker-compose exec wp wp --allow-root menu item add-post main-menu $PAGE_ID --title="Tài khoản"
        echo "✅ Account page added to main menu"
    fi
    
else
    echo "ℹ️  Account page already exists with ID: $PAGE_EXISTS"
    
    # Ensure the correct template is set
    docker-compose exec wp wp --allow-root post meta set $PAGE_EXISTS _wp_page_template 'page-templates/account.php'
    echo "📝 Page template updated to: account.php"
fi

echo ""
echo "🎉 Account page setup complete!"
echo "📍 You can access the account page at: http://localhost:8080/tai-khoan"
echo ""
echo "📋 Next steps:"
echo "1. Run 'npm run build' in the theme directory to build the assets"
echo "2. Update the hashed filenames in functions.php if needed"
echo "3. Test the account page functionality"