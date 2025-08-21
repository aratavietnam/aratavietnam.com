#!/bin/bash

echo "Setting up News page and menu structure..."

# First, let's check if the main news page exists and get its ID
NEWS_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --title="Tin tức" --field=ID --allow-root 2>/dev/null | head -1)

if [ -z "$NEWS_PAGE_ID" ]; then
    echo "Creating main News page..."
    NEWS_PAGE_ID=$(docker-compose exec wp-cli wp post create \
        --post_type=page \
        --post_title="Tin tức" \
        --post_content="<p>Cập nhật những tin tức mới nhất từ Arata Vietnam - từ các chương trình khuyến mãi hấp dẫn, cơ hội việc làm tại công ty đến những bài viết chia sẻ kiến thức về sản phẩm hóa mỹ phẩm Nhật Bản.</p>

<p>Chúng tôi cam kết mang đến cho khách hàng những thông tin chính xác, kịp thời và hữu ích nhất.</p>" \
        --post_status=publish \
        --post_name="tin-tuc" \
        --meta_input='{"_wp_page_template":"page-templates/news.php","arata_news_subtitle":"Cập nhật tin tức mới nhất từ Arata Vietnam","arata_news_intro":"Khám phá những tin tức, khuyến mãi và cơ hội nghề nghiệp tại Arata Vietnam"}' \
        --porcelain \
        --allow-root)
    echo "Created News page with ID: $NEWS_PAGE_ID"
else
    echo "News page already exists with ID: $NEWS_PAGE_ID"
    # Update the existing page to use correct template
    docker-compose exec wp-cli wp post meta update $NEWS_PAGE_ID _wp_page_template "page-templates/news.php" --allow-root
    docker-compose exec wp-cli wp post meta update $NEWS_PAGE_ID arata_news_subtitle "Cập nhật tin tức mới nhất từ Arata Vietnam" --allow-root
    docker-compose exec wp-cli wp post meta update $NEWS_PAGE_ID arata_news_intro "Khám phá những tin tức, khuyến mãi và cơ hội nghề nghiệp tại Arata Vietnam" --allow-root
    echo "Updated News page template and meta"
fi

# Get the main menu ID
MENU_ID=$(docker-compose exec wp-cli wp menu list --fields=term_id,name --format=csv --allow-root | grep "Main Menu" | cut -d',' -f1)

if [ -z "$MENU_ID" ]; then
    echo "Main Menu not found, creating it..."
    MENU_ID=$(docker-compose exec wp-cli wp menu create "Main Menu" --porcelain --allow-root)
    echo "Created Main Menu with ID: $MENU_ID"
    
    # Assign to primary location
    docker-compose exec wp-cli wp menu location assign $MENU_ID primary --allow-root
    echo "Assigned Main Menu to primary location"
fi

echo "Using Menu ID: $MENU_ID"

# Remove existing news menu items to avoid duplicates
echo "Cleaning up existing news menu items..."
docker-compose exec wp-cli wp db query "DELETE FROM wp_posts WHERE post_type='nav_menu_item' AND post_title LIKE '%tin tức%' OR post_title LIKE '%Tin tức%'" --allow-root 2>/dev/null || true

# Get existing menu items to maintain order
echo "Getting existing menu items..."
EXISTING_ITEMS=$(docker-compose exec wp-cli wp menu item list $MENU_ID --fields=db_id,title,menu_order --format=csv --allow-root 2>/dev/null | tail -n +2)

# Find the highest menu order
MAX_ORDER=0
if [ ! -z "$EXISTING_ITEMS" ]; then
    MAX_ORDER=$(echo "$EXISTING_ITEMS" | cut -d',' -f3 | sort -n | tail -1)
fi

# Calculate new menu order (after existing items)
NEWS_ORDER=$((MAX_ORDER + 1))

echo "Adding News page to menu at position $NEWS_ORDER..."

# Add the main News page to menu
NEWS_MENU_ITEM_ID=$(docker-compose exec wp-cli wp menu item add-post $MENU_ID $NEWS_PAGE_ID \
    --title="Tin tức" \
    --position=$NEWS_ORDER \
    --porcelain \
    --allow-root)

echo "Added News menu item with ID: $NEWS_MENU_ITEM_ID"

# Update menu item if needed
if [ ! -z "$NEWS_MENU_ITEM_ID" ]; then
    docker-compose exec wp-cli wp post update $NEWS_MENU_ITEM_ID \
        --post_title="Tin tức" \
        --menu_order=$NEWS_ORDER \
        --allow-root
    echo "Updated News menu item"
fi

# Set the correct URL for the news page
docker-compose exec wp-cli wp post update $NEWS_PAGE_ID --post_name="tin-tuc" --allow-root

echo "Menu structure setup completed!"
echo ""
echo "Current menu structure:"
docker-compose exec wp-cli wp menu item list $MENU_ID --fields=db_id,title,url,menu_order --allow-root 2>/dev/null || echo "Could not display menu items"

echo ""
echo "You can now visit: http://localhost:8000/tin-tuc"
