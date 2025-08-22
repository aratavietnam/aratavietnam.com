#!/bin/bash

echo "Setting up Products menu and WooCommerce shop page..."

# Wait for WordPress to be ready
wp core is-installed --allow-root || { echo "WordPress not installed"; exit 1; }

# Create or update WooCommerce shop page with Vietnamese slug
echo "Setting up WooCommerce shop page..."

# Check if shop page exists
SHOP_PAGE_ID=$(wp post list --post_type=page --meta_key=_wp_page_template --meta_value=woocommerce --format=ids --allow-root)

if [ -z "$SHOP_PAGE_ID" ]; then
    # Create shop page if it doesn't exist
    SHOP_PAGE_ID=$(wp post create \
        --post_type=page \
        --post_title="Sản phẩm" \
        --post_name="san-pham" \
        --post_status=publish \
        --post_content="<p>Trang sản phẩm của Arata Vietnam.</p>" \
        --porcelain \
        --allow-root)
    
    echo "Created shop page with ID: $SHOP_PAGE_ID"
else
    # Update existing shop page
    wp post update $SHOP_PAGE_ID \
        --post_title="Sản phẩm" \
        --post_name="san-pham" \
        --allow-root
    
    echo "Updated existing shop page with ID: $SHOP_PAGE_ID"
fi

# Set WooCommerce shop page option
wp option update woocommerce_shop_page_id $SHOP_PAGE_ID --allow-root

# Get or create primary menu
MENU_ID=$(wp menu list --format=ids --allow-root | head -n1)

if [ -z "$MENU_ID" ]; then
    # Create primary menu if it doesn't exist
    MENU_ID=$(wp menu create "Primary Menu" --porcelain --allow-root)
    echo "Created primary menu with ID: $MENU_ID"
    
    # Set as primary menu location
    wp menu location assign $MENU_ID primary --allow-root
else
    echo "Using existing menu with ID: $MENU_ID"
fi

# Check if products menu item already exists
EXISTING_ITEM=$(wp menu item list $MENU_ID --format=csv --fields=object_id,title --allow-root | grep -i "sản phẩm\|san-pham" | head -n1)

if [ -z "$EXISTING_ITEM" ]; then
    # Add products menu item
    wp menu item add-post $MENU_ID $SHOP_PAGE_ID --allow-root
    echo "Added 'Sản phẩm' to menu"
else
    echo "Products menu item already exists"
fi

# Update menu item order (optional - place products after home)
HOME_ITEM_ID=$(wp menu item list $MENU_ID --format=csv --fields=db_id,title --allow-root | grep -i "trang chủ\|home" | cut -d',' -f1 | head -n1)
PRODUCTS_ITEM_ID=$(wp menu item list $MENU_ID --format=csv --fields=db_id,object_id --allow-root | grep "$SHOP_PAGE_ID" | cut -d',' -f1 | head -n1)

if [ ! -z "$HOME_ITEM_ID" ] && [ ! -z "$PRODUCTS_ITEM_ID" ]; then
    # Set products menu item order to be after home (order 2)
    wp menu item update $PRODUCTS_ITEM_ID --menu-item-position=2 --allow-root
    echo "Updated products menu item position"
fi

# Flush rewrite rules to ensure URLs work properly
wp rewrite flush --allow-root

echo "Products menu setup completed!"
echo "Shop page URL: http://localhost:8000/san-pham"
echo "Menu updated with 'Sản phẩm' link"
