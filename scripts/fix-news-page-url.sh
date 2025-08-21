#!/bin/bash

echo "Fixing News page URL and menu..."

# Start Docker services if not running
docker-compose up -d

# Wait for services to be ready
sleep 10

# Get the working news page (tin-tuc-2)
WORKING_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="tin-tuc-2" --field=ID --allow-root 2>/dev/null | head -1)

# Get the empty news page (tin-tuc)
EMPTY_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="tin-tuc" --field=ID --allow-root 2>/dev/null | head -1)

echo "Working page ID (tin-tuc-2): $WORKING_PAGE_ID"
echo "Empty page ID (tin-tuc): $EMPTY_PAGE_ID"

# Delete the empty tin-tuc page if it exists
if [ ! -z "$EMPTY_PAGE_ID" ]; then
    echo "Deleting empty tin-tuc page (ID: $EMPTY_PAGE_ID)..."
    docker-compose exec wp-cli wp post delete $EMPTY_PAGE_ID --force --allow-root
    echo "Deleted empty page"
fi

# Change the working page slug from tin-tuc-2 to tin-tuc
if [ ! -z "$WORKING_PAGE_ID" ]; then
    echo "Changing slug of working page to 'tin-tuc'..."
    docker-compose exec wp-cli wp post update $WORKING_PAGE_ID --post_name="tin-tuc" --allow-root
    echo "Updated page slug"
    
    # Flush rewrite rules
    echo "Flushing rewrite rules..."
    docker-compose exec wp-cli wp rewrite flush --allow-root
fi

# Fix menu - get main menu ID
MENU_ID=$(docker-compose exec wp-cli wp menu list --fields=term_id,name --format=csv --allow-root 2>/dev/null | grep "Main Menu" | cut -d',' -f1)

if [ ! -z "$MENU_ID" ]; then
    echo "Found Main Menu ID: $MENU_ID"
    
    # Remove any existing news menu items
    echo "Cleaning up existing news menu items..."
    docker-compose exec wp-cli wp db query "DELETE FROM wp_posts WHERE post_type='nav_menu_item' AND (post_title LIKE '%tin tức%' OR post_title LIKE '%Tin tức%')" --allow-root 2>/dev/null || true
    
    # Add the news page to menu
    if [ ! -z "$WORKING_PAGE_ID" ]; then
        echo "Adding News page to menu..."
        NEWS_MENU_ITEM_ID=$(docker-compose exec wp-cli wp menu item add-post $MENU_ID $WORKING_PAGE_ID \
            --title="Tin tức" \
            --position=5 \
            --porcelain \
            --allow-root 2>/dev/null)
        
        if [ ! -z "$NEWS_MENU_ITEM_ID" ]; then
            echo "Added News menu item with ID: $NEWS_MENU_ITEM_ID"
        fi
    fi
    
    # Assign menu to primary location if not already assigned
    echo "Assigning menu to primary location..."
    docker-compose exec wp-cli wp menu location assign $MENU_ID primary --allow-root
    
else
    echo "Main Menu not found, creating new menu..."
    
    # Create main menu
    MENU_ID=$(docker-compose exec wp-cli wp menu create "Main Menu" --porcelain --allow-root)
    echo "Created Main Menu with ID: $MENU_ID"
    
    # Assign to primary location
    docker-compose exec wp-cli wp menu location assign $MENU_ID primary --allow-root
    
    # Add basic menu items
    if [ ! -z "$WORKING_PAGE_ID" ]; then
        docker-compose exec wp-cli wp menu item add-post $MENU_ID $WORKING_PAGE_ID \
            --title="Tin tức" \
            --allow-root
    fi
    
    # Add other basic pages
    HOME_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="trang-chu" --field=ID --allow-root 2>/dev/null | head -1)
    if [ ! -z "$HOME_ID" ]; then
        docker-compose exec wp-cli wp menu item add-post $MENU_ID $HOME_ID \
            --title="Trang chủ" \
            --position=1 \
            --allow-root
    fi
fi

echo ""
echo "Current menu structure:"
docker-compose exec wp-cli wp menu item list $MENU_ID --fields=db_id,title,url --allow-root 2>/dev/null || echo "Could not display menu items"

echo ""
echo "✅ Fixed! You can now visit: http://localhost:8000/tin-tuc/"
echo "The working news page is now available at the correct URL."
