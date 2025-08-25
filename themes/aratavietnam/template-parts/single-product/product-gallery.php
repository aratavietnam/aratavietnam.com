<?php
/**
 * Single Product Image Slider using Swiper.js and PhotoSwipe
 *
 * @package ArataVietnam
 */

global $product;

if (!$product) {
    return;
}

$main_image_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids();
$image_ids = array_merge([$main_image_id], $gallery_image_ids);
$image_ids = array_filter(array_unique($image_ids));

?>
<div class="product-gallery-slider relative bg-white rounded-lg shadow-sm overflow-hidden">
    <?php if (!empty($image_ids)) : ?>
        <!-- Main Slider -->
        <div class="swiper main-product-swiper mb-4 relative group">
            <div class="swiper-wrapper">
                <?php foreach ($image_ids as $index => $image_id) :
                    $full_src = wp_get_attachment_image_src($image_id, 'full');
                    $main_src = wp_get_attachment_image_src($image_id, 'woocommerce_single');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $product->get_name();
                ?>
                    <div class="swiper-slide aspect-square">
                        <a href="<?php echo esc_url($full_src[0]); ?>"
                           data-pswp-width="<?php echo esc_attr($full_src[1]); ?>"
                           data-pswp-height="<?php echo esc_attr($full_src[2]); ?>"
                           class="block w-full h-full cursor-zoom-in relative group/image">
                            <img src="<?php echo esc_url($main_src[0]); ?>"
                                 alt="<?php echo esc_attr($alt_text); ?>"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover/image:scale-105"
                                 loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">

                            <!-- Zoom Icon Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover/image:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                <div class="bg-white bg-opacity-90 rounded-full p-2 opacity-0 group-hover/image:opacity-100 transition-opacity duration-300">
                                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Hidden caption for PhotoSwipe -->
                            <div class="hidden-caption-content hidden">
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-white mb-2"><?php echo esc_html($product->get_name()); ?></h3>
                                    <?php if ($alt_text && $alt_text !== $product->get_name()) : ?>
                                        <p class="text-sm text-gray-300"><?php echo esc_html($alt_text); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Navigation Arrows -->
            <?php if (count($image_ids) > 1) : ?>
                <div class="swiper-button-next !text-primary !w-10 !h-10 !mt-0 !top-1/2 !right-2 !bg-white !rounded-full !shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 after:!text-lg after:!font-bold"></div>
                <div class="swiper-button-prev !text-primary !w-10 !h-10 !mt-0 !top-1/2 !left-2 !bg-white !rounded-full !shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 after:!text-lg after:!font-bold"></div>
            <?php endif; ?>

            <!-- Slide Counter -->
            <?php if (count($image_ids) > 1) : ?>
                <div class="absolute bottom-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                    <span class="current-slide">1</span> / <span class="total-slides"><?php echo count($image_ids); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Thumbnails Slider -->
        <?php if (count($image_ids) > 1) : ?>
        <div class="swiper thumbs-product-swiper px-2">
            <div class="swiper-wrapper">
                <?php foreach ($image_ids as $image_id) :
                    $thumb_src = wp_get_attachment_image_src($image_id, 'woocommerce_gallery_thumbnail');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $product->get_name();
                ?>
                    <div class="swiper-slide !w-16 !h-16 md:!w-20 md:!h-20 rounded-lg border-2 border-transparent cursor-pointer overflow-hidden transition-all duration-300 hover:border-primary hover:border-opacity-50">
                        <img src="<?php echo esc_url($thumb_src[0]); ?>"
                             alt="<?php echo esc_attr($alt_text); ?>"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    <?php else : ?>
        <!-- Placeholder Image -->
        <div class="aspect-square bg-gray-100 flex items-center justify-center rounded-lg">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-gray-400 text-sm">Chưa có hình ảnh</span>
            </div>
        </div>
    <?php endif; ?>
</div>
