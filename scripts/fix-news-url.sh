#!/bin/bash

echo "Fixing News page URL..."

# Get the current news page ID
NEWS_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --title="Tin tức" --field=ID --allow-root 2>/dev/null | head -1)

if [ ! -z "$NEWS_PAGE_ID" ]; then
    echo "Found News page with ID: $NEWS_PAGE_ID"
    
    # Check if there's already a page with slug 'tin-tuc'
    EXISTING_PAGE=$(docker-compose exec wp-cli wp post list --post_type=page --name="tin-tuc" --field=ID --allow-root 2>/dev/null | head -1)
    
    if [ ! -z "$EXISTING_PAGE" ] && [ "$EXISTING_PAGE" != "$NEWS_PAGE_ID" ]; then
        echo "Found existing page with slug 'tin-tuc' (ID: $EXISTING_PAGE), moving it to trash..."
        docker-compose exec wp-cli wp post delete $EXISTING_PAGE --force --allow-root
    fi
    
    # Update the news page slug
    echo "Updating News page slug to 'tin-tuc'..."
    docker-compose exec wp-cli wp post update $NEWS_PAGE_ID --post_name="tin-tuc" --allow-root
    
    # Update menu item URL
    MENU_ITEM_ID=$(docker-compose exec wp-cli wp db query "SELECT post_id FROM wp_postmeta WHERE meta_key='_menu_item_object_id' AND meta_value='$NEWS_PAGE_ID'" --skip-column-names --allow-root 2>/dev/null)
    
    if [ ! -z "$MENU_ITEM_ID" ]; then
        echo "Updating menu item URL..."
        docker-compose exec wp-cli wp post meta update $MENU_ITEM_ID _menu_item_url "http://localhost:8000/tin-tuc/" --allow-root
    fi
    
    # Flush rewrite rules
    echo "Flushing rewrite rules..."
    docker-compose exec wp-cli wp rewrite flush --allow-root
    
    echo "News page URL fixed!"
    echo "You can now visit: http://localhost:8000/tin-tuc/"
    
else
    echo "News page not found!"
fi
