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
        <div class="swiper main-product-swiper mb-2 relative">
            <div class="swiper-wrapper">
                <?php foreach ($image_ids as $image_id) :
                    $full_src = wp_get_attachment_image_src($image_id, 'full');
                    $main_src = wp_get_attachment_image_src($image_id, 'woocommerce_single');
                ?>
                    <div class="swiper-slide aspect-square">
                        <a href="<?php echo esc_url($full_src[0]); ?>" data-pswp-width="<?php echo esc_attr($full_src[1]); ?>" data-pswp-height="<?php echo esc_attr($full_src[2]); ?>" class="block w-full h-full cursor-zoom-in">
                            <img src="<?php echo esc_url($main_src[0]); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)); ?>" class="w-full h-full object-cover">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next text-primary"></div>
            <div class="swiper-button-prev text-primary"></div>
        </div>

        <!-- Thumbnails Slider -->
        <div class="swiper thumbs-product-swiper px-4 pb-4">
            <div class="swiper-wrapper">
                <?php foreach ($image_ids as $image_id) :
                    $thumb_src = wp_get_attachment_image_src($image_id, 'woocommerce_gallery_thumbnail');
                ?>
                    <div class="swiper-slide aspect-square rounded-lg border-2 border-transparent cursor-pointer overflow-hidden">
                        <img src="<?php echo esc_url($thumb_src[0]); ?>" alt="" class="w-full h-full object-cover">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <!-- Placeholder Image -->
        <div class="aspect-square bg-gray-100 flex items-center justify-center rounded-lg">
            <span class="text-gray-400">Chưa có hình ảnh</span>
        </div>
    <?php endif; ?>
</div>
