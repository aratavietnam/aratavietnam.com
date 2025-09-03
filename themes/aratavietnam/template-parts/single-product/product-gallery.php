<?php
/**
 * Single Product Image Gallery with Lightbox
 *
 * @package ArataVietnam
 */

global $product;

if (!$product) {
    return;
}

$main_image_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids();
$image_ids = [];

if ($main_image_id) {
    $image_ids[] = $main_image_id;
}

if (!empty($gallery_image_ids)) {
    $image_ids = array_merge($image_ids, $gallery_image_ids);
}

$image_ids = array_filter(array_unique($image_ids));

?>
<div class="product-gallery-simple relative bg-white rounded-lg shadow-sm overflow-hidden">
    <?php if (!empty($image_ids)) : ?>
        
        <!-- Main Image Display -->
        <div class="main-image-container relative group">
            <div id="current-image" class="aspect-square relative">
                <?php 
                $first_image_id = $image_ids[0];
                $main_src = wp_get_attachment_image_src($first_image_id, 'large');
                $alt_text = get_post_meta($first_image_id, '_wp_attachment_image_alt', true) ?: $product->get_name();
                ?>
                <img id="main-product-image" 
                     src="<?php echo esc_url($main_src[0]); ?>" 
                     alt="<?php echo esc_attr($alt_text); ?>" 
                     class="w-full h-full object-cover cursor-pointer"
                     onclick="openGalleryLightbox(0)"
                     onerror="this.style.backgroundImage='url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xMiA4VjE2TTggMTJIMTYiIHN0cm9rZT0iIzlDQTNBRiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPHN2Zz4K)'; this.style.backgroundSize='60px 60px'; this.style.backgroundRepeat='no-repeat'; this.style.backgroundPosition='center'; this.style.backgroundColor='#f3f4f6'; this.src=''">
                
                <!-- View Gallery Button - Always visible on mobile, hover on desktop -->
                <div class="absolute top-4 right-4 z-10">
                    <button onclick="openGalleryLightbox(0)" class="view-gallery-btn bg-white bg-opacity-90 rounded-full p-3 shadow-lg cursor-pointer transition-opacity duration-300 w-12 h-12 flex items-center justify-center">
                        <span data-icon="eye" data-size="20" class="text-gray-700"></span>
                    </button>
                </div>
            </div>

            <!-- Image Counter -->
            <?php if (count($image_ids) > 1) : ?>
                <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                    <span id="current-index">1</span> / <?php echo count($image_ids); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Thumbnail Gallery -->
        <?php if (count($image_ids) > 1) : ?>
        <div class="thumbnails-container mt-4 px-2">
            <div class="flex gap-2 overflow-x-auto pb-4">
                <?php foreach ($image_ids as $index => $image_id) :
                    $thumb_src = wp_get_attachment_image_src($image_id, 'woocommerce_gallery_thumbnail');
                    $large_src = wp_get_attachment_image_src($image_id, 'large');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $product->get_name();
                ?>
                    <?php if ($thumb_src && $thumb_src[0] && $large_src && $large_src[0]) : ?>
                    <div class="thumbnail-item flex-shrink-0 w-16 h-16 md:w-20 md:h-20 rounded-lg border-2 cursor-pointer overflow-hidden transition-all duration-300 <?php echo $index === 0 ? 'border-primary' : 'border-gray-200 hover:border-primary'; ?>" 
                         onclick="changeMainImage(<?php echo $index; ?>, '<?php echo esc_url($large_src[0]); ?>', '<?php echo esc_attr($alt_text); ?>')">
                        <img src="<?php echo esc_url($thumb_src[0]); ?>" 
                             alt="<?php echo esc_attr($alt_text); ?>" 
                             class="w-full h-full object-cover transition-transform duration-200 hover:scale-110">
                    </div>
                    <?php else : ?>
                    <div class="thumbnail-item flex-shrink-0 w-16 h-16 md:w-20 md:h-20 rounded-lg border-2 border-gray-200 overflow-hidden bg-gray-100 flex items-center justify-center">
                        <span data-icon="package" data-size="20" class="text-gray-400"></span>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Hidden Gallery Data for Lightbox -->
        <div id="gallery-data" class="hidden">
            <?php foreach ($image_ids as $index => $image_id) :
                $full_src = wp_get_attachment_image_src($image_id, 'full');
                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $product->get_name();
            ?>
                <div data-src="<?php echo esc_url($full_src[0]); ?>" 
                     data-width="<?php echo esc_attr($full_src[1]); ?>" 
                     data-height="<?php echo esc_attr($full_src[2]); ?>" 
                     data-alt="<?php echo esc_attr($alt_text); ?>"></div>
            <?php endforeach; ?>
        </div>

    <?php else : ?>
        <!-- Placeholder Image -->
        <div class="aspect-square bg-gray-100 flex items-center justify-center rounded-lg">
            <div class="text-center">
                <span data-icon="package" data-size="64" class="text-gray-300 mb-4"></span>
                <span class="text-gray-400 text-sm">Chưa có hình ảnh</span>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery data
    const galleryItems = [];
    const galleryDataElements = document.querySelectorAll('#gallery-data > div');
    
    galleryDataElements.forEach(item => {
        galleryItems.push({
            src: item.getAttribute('data-src'),
            width: parseInt(item.getAttribute('data-width')),
            height: parseInt(item.getAttribute('data-height')),
            alt: item.getAttribute('data-alt')
        });
    });

    let currentImageIndex = 0;

    // Change main image function
    window.changeMainImage = function(index, src, alt) {
        const mainImage = document.getElementById('main-product-image');
        const currentIndex = document.getElementById('current-index');
        
        currentImageIndex = index;
        
        if (mainImage) {
            mainImage.src = src;
            mainImage.alt = alt;
        }
        
        if (currentIndex) {
            currentIndex.textContent = index + 1;
        }

        // Update thumbnail borders
        document.querySelectorAll('.thumbnail-item').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.remove('border-gray-200');
                thumb.classList.add('border-primary');
            } else {
                thumb.classList.remove('border-primary');
                thumb.classList.add('border-gray-200');
            }
        });
    };

    // Simple lightbox implementation
    window.openGalleryLightbox = function(startIndex = null) {
        if (galleryItems.length === 0) return;
        
        const indexToShow = startIndex !== null ? startIndex : currentImageIndex;
        
        // Create lightbox
        const lightbox = document.createElement('div');
        lightbox.id = 'custom-lightbox';
        lightbox.className = 'fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center';
        lightbox.style.zIndex = '9999';
        lightbox.innerHTML = `
            <div class="absolute top-4 right-4 z-10">
                <button id="close-lightbox" class="text-white text-3xl hover:text-gray-300">&times;</button>
            </div>
            <div class="absolute top-4 left-4 z-10">
                <button id="zoom-toggle" class="bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg hover:bg-opacity-70 transition-all duration-200 flex items-center">
                    <span data-icon="search" data-size="16" class="mr-2"></span>
                    <span id="zoom-text" class="font-semibold">+</span>
                </button>
            </div>
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 ${galleryItems.length > 1 ? '' : 'hidden'}">
                <button id="prev-image" class="text-white text-4xl hover:text-gray-300">&lsaquo;</button>
            </div>
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 ${galleryItems.length > 1 ? '' : 'hidden'}">
                <button id="next-image" class="text-white text-4xl hover:text-gray-300">&rsaquo;</button>
            </div>
            <div id="lightbox-content" class="max-w-full max-h-full flex items-center justify-center overflow-hidden">
                <img id="lightbox-image" class="max-w-full max-h-full object-contain transition-transform duration-300 cursor-pointer" />
            </div>
            <div id="image-counter" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white bg-black bg-opacity-50 px-3 py-1 rounded-full z-10 ${galleryItems.length > 1 ? '' : 'hidden'}">
                <span id="lightbox-current">1</span> / ${galleryItems.length}
            </div>
        `;
        
        document.body.appendChild(lightbox);
        document.body.style.overflow = 'hidden';
        
        // Initialize icons in lightbox
        if (window.ArataIcons && typeof window.ArataIcons.init === 'function') {
            window.ArataIcons.init();
        }
        
        let currentLightboxIndex = indexToShow;
        let isZoomed = false;
        
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCurrent = document.getElementById('lightbox-current');
        
        function showImage(index) {
            if (index >= 0 && index < galleryItems.length) {
                currentLightboxIndex = index;
                lightboxImage.src = galleryItems[index].src;
                lightboxImage.alt = galleryItems[index].alt;
                if (lightboxCurrent) {
                    lightboxCurrent.textContent = index + 1;
                }
                isZoomed = false;
                lightboxImage.style.transform = 'scale(1)';
                const zoomText = document.getElementById('zoom-text');
                if (zoomText) zoomText.textContent = '+';
            }
        }
        
        showImage(currentLightboxIndex);
        
        // Navigation
        document.getElementById('prev-image').onclick = () => {
            const newIndex = currentLightboxIndex > 0 ? currentLightboxIndex - 1 : galleryItems.length - 1;
            showImage(newIndex);
        };
        
        document.getElementById('next-image').onclick = () => {
            const newIndex = currentLightboxIndex < galleryItems.length - 1 ? currentLightboxIndex + 1 : 0;
            showImage(newIndex);
        };
        
        // Zoom toggle function
        function toggleZoom() {
            const zoomText = document.getElementById('zoom-text');
            if (!isZoomed) {
                lightboxImage.style.transform = 'scale(2)';
                zoomText.textContent = '-';
                isZoomed = true;
            } else {
                lightboxImage.style.transform = 'scale(1)';
                zoomText.textContent = '+';
                isZoomed = false;
            }
        }
        
        // Image zoom - both click image and button
        lightboxImage.onclick = function(e) {
            e.stopPropagation();
            toggleZoom();
        };
        
        document.getElementById('zoom-toggle').onclick = function(e) {
            e.stopPropagation();
            toggleZoom();
        };
        
        // Close lightbox
        function closeLightbox() {
            document.body.removeChild(lightbox);
            document.body.style.overflow = '';
        }
        
        document.getElementById('close-lightbox').onclick = closeLightbox;
        lightbox.onclick = function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        };
        
        // Keyboard navigation
        document.addEventListener('keydown', function handleKeydown(e) {
            switch(e.key) {
                case 'Escape':
                    closeLightbox();
                    document.removeEventListener('keydown', handleKeydown);
                    break;
                case 'ArrowLeft':
                    document.getElementById('prev-image').click();
                    break;
                case 'ArrowRight':
                    document.getElementById('next-image').click();
                    break;
            }
        });
    };

    // Desktop hover behavior for view gallery button
    const isMobile = window.innerWidth < 640;
    const viewBtn = document.querySelector('.view-gallery-btn');
    const galleryContainer = document.querySelector('.main-image-container');
    
    if (viewBtn && galleryContainer && !isMobile) {
        // Hide button initially on desktop
        viewBtn.style.opacity = '0';
        
        // Show/hide on hover
        galleryContainer.addEventListener('mouseenter', () => {
            viewBtn.style.opacity = '1';
        });
        
        galleryContainer.addEventListener('mouseleave', () => {
            viewBtn.style.opacity = '0';
        });
    }

    // Initialize icons
    if (window.ArataIcons && typeof window.ArataIcons.init === 'function') {
        window.ArataIcons.init();
    }
});
</script>