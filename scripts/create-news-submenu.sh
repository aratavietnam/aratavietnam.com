#!/bin/bash

echo "Creating News submenu with 3 child pages..."

# Start services
docker-compose up -d
sleep 10

# Create Promotions page
echo "Creating Promotions page..."
PROMOTIONS_PAGE_ID=$(docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Khuyến mãi" \
    --post_content="<p>Khám phá các chương trình khuyến mãi hấp dẫn từ Arata Vietnam. Chúng tôi thường xuyên có những ưu đãi đặc biệt dành cho khách hàng yêu thích sản phẩm hóa mỹ phẩm Nhật Bản chất lượng cao.</p>

<p>Đăng ký nhận thông báo để không bỏ lỡ bất kỳ chương trình khuyến mãi nào!</p>" \
    --post_status=publish \
    --post_name="khuyen-mai" \
    --meta_input='{"_wp_page_template":"page-templates/promotions.php","arata_news_subtitle":"Ưu đãi đặc biệt từ Arata Vietnam","arata_news_intro":"Nhận ngay những ưu đãi hấp dẫn cho sản phẩm hóa mỹ phẩm Nhật Bản"}' \
    --porcelain \
    --allow-root)

echo "Created Promotions page with ID: $PROMOTIONS_PAGE_ID"

# Create Careers page
echo "Creating Careers page..."
CAREERS_PAGE_ID=$(docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Tuyển dụng" \
    --post_content="<p>Gia nhập đội ngũ Arata Vietnam - nơi bạn có thể phát triển sự nghiệp trong lĩnh vực hóa mỹ phẩm hàng đầu. Chúng tôi luôn tìm kiếm những tài năng để cùng xây dựng thương hiệu mạnh mẽ tại thị trường Việt Nam.</p>

<p>Tại Arata Vietnam, bạn sẽ được làm việc trong môi trường chuyên nghiệp, năng động và có nhiều cơ hội phát triển.</p>" \
    --post_status=publish \
    --post_name="tuyen-dung" \
    --meta_input='{"_wp_page_template":"page-templates/careers.php","arata_news_subtitle":"Cơ hội nghề nghiệp tại Arata Vietnam","arata_news_intro":"Khám phá các vị trí tuyển dụng và gia nhập đội ngũ chuyên nghiệp"}' \
    --porcelain \
    --allow-root)

echo "Created Careers page with ID: $CAREERS_PAGE_ID"

# Create Blog page
echo "Creating Blog page..."
BLOG_PAGE_ID=$(docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Blog" \
    --post_content="<p>Khám phá những bài viết chuyên sâu về hóa mỹ phẩm, xu hướng làm đẹp và những câu chuyện thú vị từ Arata Vietnam. Chúng tôi chia sẻ kiến thức và kinh nghiệm để giúp bạn chăm sóc bản thân tốt hơn.</p>

<p>Từ hướng dẫn sử dụng sản phẩm đến những xu hướng làm đẹp mới nhất từ Nhật Bản.</p>" \
    --post_status=publish \
    --post_name="blog" \
    --meta_input='{"_wp_page_template":"page-templates/blog.php","arata_news_subtitle":"Chia sẻ kiến thức và kinh nghiệm","arata_news_intro":"Khám phá thế giới hóa mỹ phẩm Nhật Bản qua những bài viết chuyên sâu"}' \
    --porcelain \
    --allow-root)

echo "Created Blog page with ID: $BLOG_PAGE_ID"

# Get the main news page ID and menu ID
NEWS_PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --name="tin-tuc" --field=ID --allow-root 2>/dev/null | head -1)
MENU_ID=34

echo "News page ID: $NEWS_PAGE_ID"
echo "Menu ID: $MENU_ID"

# Add submenu items to the News menu item
if [ ! -z "$NEWS_PAGE_ID" ] && [ ! -z "$PROMOTIONS_PAGE_ID" ] && [ ! -z "$CAREERS_PAGE_ID" ] && [ ! -z "$BLOG_PAGE_ID" ]; then
    
    # Get the News menu item ID
    NEWS_MENU_ITEM_ID=$(docker-compose exec wp-cli wp db query "SELECT post_id FROM wp_postmeta WHERE meta_key='_menu_item_object_id' AND meta_value='$NEWS_PAGE_ID'" --skip-column-names --allow-root 2>/dev/null)
    
    echo "News menu item ID: $NEWS_MENU_ITEM_ID"
    
    if [ ! -z "$NEWS_MENU_ITEM_ID" ]; then
        echo "Adding submenu items..."
        
        # Add Promotions as submenu
        docker-compose exec wp-cli wp menu item add-post $MENU_ID $PROMOTIONS_PAGE_ID \
            --title="Khuyến mãi" \
            --parent-id=$NEWS_MENU_ITEM_ID \
            --allow-root
        
        # Add Careers as submenu
        docker-compose exec wp-cli wp menu item add-post $MENU_ID $CAREERS_PAGE_ID \
            --title="Tuyển dụng" \
            --parent-id=$NEWS_MENU_ITEM_ID \
            --allow-root
        
        # Add Blog as submenu
        docker-compose exec wp-cli wp menu item add-post $MENU_ID $BLOG_PAGE_ID \
            --title="Blog" \
            --parent-id=$NEWS_MENU_ITEM_ID \
            --allow-root
        
        echo "Added submenu items successfully"
    else
        echo "Could not find News menu item ID"
    fi
else
    echo "Missing page IDs"
fi

echo ""
echo "Final menu structure:"
docker-compose exec wp-cli wp menu item list $MENU_ID --fields=db_id,title,url,menu_order,parent --allow-root 2>/dev/null || echo "Could not display menu items"

echo ""
echo "✅ News submenu created successfully!"
echo "Pages created:"
echo "- Khuyến mãi: http://localhost:8000/khuyen-mai/"
echo "- Tuyển dụng: http://localhost:8000/tuyen-dung/"
echo "- Blog: http://localhost:8000/blog/"
echo ""
echo "Next: Create individual page templates for each submenu item"
