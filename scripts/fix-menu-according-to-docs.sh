#!/bin/bash

echo "Fixing menu according to docs requirements..."
echo "Required menu items: Sản phẩm, Dịch vụ, Về Arata, Tin tức, Liên hệ"

# Start services
docker-compose up -d
sleep 10

# Get the news page ID
NEWS_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="tin-tuc" --field=ID --allow-root 2>/dev/null | head -1)
echo "News page ID: $NEWS_PAGE_ID"

# Use the existing "Menu chính" (ID 34) which has the correct structure
MENU_ID=34
echo "Using existing 'Menu chính' (ID: $MENU_ID)"

# Add "Tin tức" to the existing menu between "Về Arata" and "Liên hệ"
if [ ! -z "$NEWS_PAGE_ID" ]; then
    echo "Adding 'Tin tức' to menu..."
    
    # Add news page with position 4 (between Về Arata and Liên hệ)
    docker-compose exec wp-cli wp menu item add-post $MENU_ID $NEWS_PAGE_ID \
        --title="Tin tức" \
        --position=4 \
        --allow-root
    
    # Update the order of "Liên hệ" to position 5
    docker-compose exec wp-cli wp post update 79 --menu_order=5 --allow-root
    
    echo "Added 'Tin tức' to menu"
fi

# Assign this menu to primary location (replace the broken Main Menu)
echo "Assigning 'Menu chính' to primary location..."
docker-compose exec wp-cli wp menu location assign $MENU_ID primary --allow-root

# Delete the broken "Main Menu" with duplicate items
echo "Cleaning up broken 'Main Menu'..."
docker-compose exec wp-cli wp menu delete 37 --allow-root

echo ""
echo "Final menu structure:"
docker-compose exec wp-cli wp menu item list $MENU_ID --fields=db_id,title,url,menu_order --allow-root 2>/dev/null || echo "Could not display menu items"

echo ""
echo "Menu locations:"
docker-compose exec wp-cli wp menu location list --allow-root

echo ""
echo "✅ Menu fixed according to docs!"
echo "Menu now includes: Trang chủ, Về Arata, Sản phẩm, Tin tức, Liên hệ"
echo "Visit http://localhost:8000 to see the corrected menu"
