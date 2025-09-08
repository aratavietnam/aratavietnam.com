#!/bin/bash

# Build Verification Script for Arata Vietnam Theme
# This script verifies that all assets are properly built and accessible

set -e

THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../themes/aratavietnam" && pwd)"
DIST_DIR="$THEME_DIR/dist"
REQUIRED_ASSETS=("app" "notifications" "add-to-cart" "product-single")

echo "🔍 Verifying build assets for Arata Vietnam theme..."
echo "Theme directory: $THEME_DIR"
echo "Dist directory: $DIST_DIR"
echo ""

# Check if dist directory exists
if [ ! -d "$DIST_DIR" ]; then
    echo "❌ ERROR: dist directory not found!"
    echo "Please run 'npm run build' in the theme directory first."
    exit 1
fi

# Check for required assets
echo "📦 Checking required assets..."
missing_assets=()

for asset in "${REQUIRED_ASSETS[@]}"; do
    # Look for JS files
    js_file=$(find "$DIST_DIR" -name "${asset}-*.js" -type f | head -1)
    
    if [ -z "$js_file" ]; then
        missing_assets+=("${asset}.js")
        echo "  ❌ ${asset}.js - MISSING"
    else
        file_size=$(stat -f%z "$js_file" 2>/dev/null || stat -c%s "$js_file" 2>/dev/null || echo 0)
        echo "  ✅ ${asset}.js - Found ($(numfmt --to=iec --suffix=B $file_size 2>/dev/null || echo "${file_size} bytes"))"
    fi
done

# Check CSS assets
echo ""
echo "🎨 Checking CSS assets..."
css_assets=("app" "editor-style")

for asset in "${css_assets[@]}"; do
    css_file=$(find "$DIST_DIR" -name "${asset}-*.css" -type f | head -1)
    
    if [ -z "$css_file" ]; then
        missing_assets+=("${asset}.css")
        echo "  ❌ ${asset}.css - MISSING"
    else
        file_size=$(stat -f%z "$css_file" 2>/dev/null || stat -c%s "$css_file" 2>/dev/null || echo 0)
        echo "  ✅ ${asset}.css - Found ($(numfmt --to=iec --suffix=B $file_size 2>/dev/null || echo "${file_size} bytes"))"
    fi
done

# Check if any assets are missing
if [ ${#missing_assets[@]} -gt 0 ]; then
    echo ""
    echo "❌ ERROR: Missing required assets:"
    printf '  - %s\n' "${missing_assets[@]}"
    echo ""
    echo "Please run 'npm run build' in the theme directory to generate missing assets."
    exit 1
fi

# Test asset management function
echo ""
echo "🧪 Testing asset management function..."

# Create a temporary PHP script to test the function
cat > "$THEME_DIR/test-assets.php" << 'EOF'
<?php
require_once 'inc/asset-management.php';

// Test asset detection
$assets = aratavietnam_get_all_assets();
echo "Detected assets:\n";
foreach ($assets as $name => $file) {
    echo "  - $name: $file\n";
}

// Test specific asset detection
$required = ['app', 'notifications', 'add-to-cart', 'product-single'];
$all_found = true;

foreach ($required as $asset) {
    $file = aratavietnam_get_asset_hash($asset, 'js');
    if ($file) {
        echo "✅ $asset: $file\n";
    } else {
        echo "❌ $asset: NOT FOUND\n";
        $all_found = false;
    }
}

exit($all_found ? 0 : 1);
EOF

# Run the test
if php "$THEME_DIR/test-assets.php" > /dev/null 2>&1; then
    echo "✅ Asset management functions working correctly"
else
    echo "❌ Asset management functions failed"
    echo "Debug output:"
    php "$THEME_DIR/test-assets.php"
    rm -f "$THEME_DIR/test-assets.php"
    exit 1
fi

# Clean up test file
rm -f "$THEME_DIR/test-assets.php"

# Check Vite manifest (if it exists)
echo ""
echo "📋 Checking Vite manifest..."
if [ -f "$DIST_DIR/manifest.json" ]; then
    echo "✅ manifest.json found"
    # Check if all entries are in manifest
    echo "Manifest contents:"
    cat "$DIST_DIR/manifest.json" | python3 -m json.tool 2>/dev/null || cat "$DIST_DIR/manifest.json"
else
    echo "⚠️  manifest.json not found (not required for current setup)"
fi

# Summary
echo ""
echo "✅ Build verification completed successfully!"
echo ""
echo "Next steps:"
echo "1. Assets are properly built and accessible"
echo "2. Asset management functions are working"
echo "3. The theme will automatically load hashed assets"
echo ""
echo "To start development:"
echo "  cd themes/aratavietnam && npm run dev"
echo ""
echo "To build for production:"
echo "  cd themes/aratavietnam && npm run build"