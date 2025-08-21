#!/bin/bash

echo "Fixing menu completely..."

# Start services
docker-compose up -d
sleep 10

# Delete all existing menus and start fresh
echo "Cleaning up all existing menus..."
docker-compose exec wp-cli wp db query "DELETE FROM wp_terms WHERE term_id IN (SELECT term_id FROM wp_term_taxonomy WHERE taxonomy = 'nav_menu')" --allow-root 2>/dev/null || true
docker-compose exec wp-cli wp db query "DELETE FROM wp_term_taxonomy WHERE taxonomy = 'nav_menu'" --allow-root 2>/dev/null || true
docker-compose exec wp-cli wp db query "DELETE FROM wp_posts WHERE post_type = 'nav_menu_item'" --allow-root 2>/dev/null || true

# Create a fresh main menu
echo "Creating fresh Main Menu..."
MENU_ID=$(docker-compose exec wp-cli wp menu create "Main Menu" --porcelain --allow-root)
echo "Created Main Menu with ID: $MENU_ID"

# Get page IDs
NEWS_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="tin-tuc" --field=ID --allow-root 2>/dev/null | head -1)
HOME_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="trang-chu" --field=ID --allow-root 2>/dev/null | head -1)
ABOUT_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="ve-arata" --field=ID --allow-root 2>/dev/null | head -1)
PRODUCTS_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="san-pham" --field=ID --allow-root 2>/dev/null | head -1)
CONTACT_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="lien-he" --field=ID --allow-root 2>/dev/null | head -1)

echo "Found page IDs:"
echo "- Home: $HOME_PAGE_ID"
echo "- Products: $PRODUCTS_PAGE_ID" 
echo "- About: $ABOUT_PAGE_ID"
echo "- News: $NEWS_PAGE_ID"
echo "- Contact: $CONTACT_PAGE_ID"

# Add menu items in order
POSITION=1

if [ ! -z "$HOME_PAGE_ID" ]; then
    echo "Adding Home to menu..."
    docker-compose exec wp-cli wp menu item add-post $MENU_ID $HOME_PAGE_ID \
        --title="Trang chủ" \
        --position=$POSITION \
        --allow-root
    POSITION=$((POSITION + 1))
fi

if [ ! -z "$PRODUCTS_PAGE_ID" ]; then
    echo "Adding Products to menu..."
    docker-compose exec wp-cli wp menu item add-post $MENU_ID $PRODUCTS_PAGE_ID \
        --title="Sản phẩm" \
        --position=$POSITION \
        --allow-root
    POSITION=$((POSITION + 1))
fi

if [ ! -z "$ABOUT_PAGE_ID" ]; then
    echo "Adding About to menu..."
    docker-compose exec wp-cli wp menu item add-post $MENU_ID $ABOUT_PAGE_ID \
        --title="Về Arata" \
        --position=$POSITION \
        --allow-root
    POSITION=$((POSITION + 1))
fi

if [ ! -z "$NEWS_PAGE_ID" ]; then
    echo "Adding News to menu..."
    docker-compose exec wp-cli wp menu item add-post $MENU_ID $NEWS_PAGE_ID \
        --title="Tin tức" \
        --position=$POSITION \
        --allow-root
    POSITION=$((POSITION + 1))
fi

if [ ! -z "$CONTACT_PAGE_ID" ]; then
    echo "Adding Contact to menu..."
    docker-compose exec wp-cli wp menu item add-post $MENU_ID $CONTACT_PAGE_ID \
        --title="Liên hệ" \
        --position=$POSITION \
        --allow-root
    POSITION=$((POSITION + 1))
fi

# Assign menu to primary location
echo "Assigning menu to primary location..."
docker-compose exec wp-cli wp menu location assign $MENU_ID primary --allow-root

# Verify menu locations are registered
echo "Checking registered menu locations..."
docker-compose exec wp-cli wp menu location list --allow-root

echo ""
echo "Final menu structure:"
docker-compose exec wp-cli wp menu item list $MENU_ID --fields=db_id,title,url,menu_order --allow-root 2>/dev/null || echo "Could not display menu items"

echo ""
echo "✅ Menu fixed completely!"
echo "Visit http://localhost:8000 to see the header menu"
