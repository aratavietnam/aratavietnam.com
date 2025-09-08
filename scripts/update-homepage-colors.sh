#!/bin/bash

# Script to update homepage sections to use global colors

THEME_DIR="/Users/duchuynh/Desktop/temp2/aratavietnam.com/themes/aratavietnam"
SECTIONS_DIR="$THEME_DIR/template-parts/homepage"

# Files to update
declare -a files=(
    "all-products.php"
    "about-section.php"
    "partners-section.php"
)

# Color replacements
PRIMARY_OLD='oklch(0.55 0.16 254.65)'
SECONDARY_OLD='oklch(0.65 0.18 40.86)'
PRIMARY_NEW="<?php echo esc_attr(\$primary_color); ?>"
SECONDARY_NEW="<?php echo esc_attr(\$secondary_color); ?>"

# Update each file
for file in "${files[@]}"; do
    filepath="$SECTIONS_DIR/$file"
    if [[ -f "$filepath" ]]; then
        echo "Updating $file..."
        
        # Add color variables at the top after the opening PHP tag
        sed -i '' '/^\/\/ Get global colors$/,$d' "$filepath"
        sed -i '' '/^\/\/ Get global colors$/d' "$filepath"
        sed -i '' '/^\/\/ Get global colors/d' "$filepath"
        
        # Add the color variables
        sed -i '' '/^?>$/i\\
// Get global colors\
$primary_color = get_theme_mod('\''arata_primary_color'\'', '\''#0066A6'\'');\
$secondary_color = get_theme_mod('\''arata_secondary_color'\'', '\''#F55E25'\'');' "$filepath"
        
        # Replace color values
        sed -i '' "s/$PRIMARY_OLD/<?php echo esc_attr(\$primary_color); ?>/g" "$filepath"
        sed -i '' "s/$SECONDARY_OLD/<?php echo esc_attr(\$secondary_color); ?>/g" "$filepath"
        
        # Replace hardcoded color classes with inline styles
        sed -i '' 's/style="color: oklch(0.55 0.16 254.65);"/style="color: <?php echo esc_attr($primary_color); ?>;"/g' "$filepath"
        sed -i '' 's/style="color: oklch(0.65 0.18 40.86);"/style="color: <?php echo esc_attr($secondary_color); ?>;"/g' "$filepath"
        
        echo "Updated $file"
    else
        echo "File not found: $filepath"
    fi
done

echo "All homepage sections have been updated to use global colors!"