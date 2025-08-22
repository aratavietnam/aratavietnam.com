<?php
/**
 * The Template for displaying product archives, including the main shop page.
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero section
$hero_title = 'Sản phẩm';
$hero_subtitle = 'Khám phá các dòng sản phẩm chất lượng từ Arata Nhật Bản';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
	<!-- Product Categories Section -->
	<section class="py-12 bg-blue-50">
		<div class="container mx-auto px-4">
			<div class="text-center mb-8">
				<h2 class="text-3xl md:text-4xl font-bold text-orange-500 mb-4">BỘ SẢN PHẨM</h2>
				<p class="text-gray-600 max-w-2xl mx-auto">Khám phá 8 bộ sản phẩm chất lượng cao từ Arata Nhật Bản</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
				<?php
				// Get product categories
				$product_categories = get_terms(array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'parent' => 0,
					'number' => 8
				));

				if (!empty($product_categories) && !is_wp_error($product_categories)) :
					foreach ($product_categories as $category) :
						$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
						$image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src();
				?>
					<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
						<div class="aspect-square overflow-hidden">
							<img src="<?php echo esc_url($image_url); ?>"
								 alt="<?php echo esc_attr($category->name); ?>"
								 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
						</div>
						<div class="p-4">
							<h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo esc_html($category->name); ?></h3>
							<p class="text-sm text-gray-600 mb-3"><?php echo esc_html($category->description); ?></p>
							<a href="<?php echo esc_url(get_term_link($category)); ?>"
							   class="inline-flex items-center text-orange-500 hover:text-orange-600 font-medium">
								Xem sản phẩm
								<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
								</svg>
							</a>
						</div>
					</div>
				<?php
					endforeach;
				else :
				?>
					<div class="col-span-full text-center py-8">
						<p class="text-gray-500">Chưa có danh mục sản phẩm nào.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Featured Products Section -->
	<section class="py-12 bg-blue-600">
		<div class="container mx-auto px-4">
			<div class="text-center mb-8">
				<h2 class="text-3xl md:text-4xl font-bold text-orange-500 mb-4">SẢN PHẨM NỔI BẬT</h2>
				<p class="text-white max-w-2xl mx-auto">Những sản phẩm được yêu thích nhất từ Arata</p>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
				<?php
				// Get featured products (4x2 grid = 8 products)
				$featured_args = array(
					'post_type' => 'product',
					'posts_per_page' => 8,
					'meta_query' => array(
						array(
							'key' => '_featured',
							'value' => 'yes'
						)
					)
				);
				$featured_products = new WP_Query($featured_args);

				if ($featured_products->have_posts()) :
					while ($featured_products->have_posts()) : $featured_products->the_post();
						global $product;
				?>
					<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
						<div class="aspect-square overflow-hidden relative">
							<?php if ($product->is_on_sale()) : ?>
								<span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded z-10">Sale</span>
							<?php endif; ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('woocommerce_thumbnail', array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300')); ?>
							</a>
						</div>
						<div class="p-4">
							<h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
								<a href="<?php the_permalink(); ?>" class="hover:text-orange-500"><?php the_title(); ?></a>
							</h3>
							<div class="flex items-center justify-between">
								<div class="text-orange-500 font-bold">
									<?php echo $product->get_price_html(); ?>
								</div>
								<button class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
									Thêm vào giỏ
								</button>
							</div>
						</div>
					</div>
				<?php
					endwhile;
					wp_reset_postdata();
				else :
				?>
					<div class="col-span-full text-center py-8">
						<p class="text-white">Chưa có sản phẩm nổi bật nào.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- All Products Section -->
	<section class="py-12 bg-white">
		<div class="container mx-auto px-4">
			<div class="text-center mb-8">
				<h2 class="text-3xl md:text-4xl font-bold text-orange-500 mb-4">TẤT CẢ SẢN PHẨM</h2>
				<p class="text-gray-600 max-w-2xl mx-auto">Toàn bộ sản phẩm chất lượng cao từ Arata Nhật Bản</p>
			</div>

			<!-- Product Filter -->
			<div class="flex flex-wrap justify-center gap-4 mb-8">
				<button class="filter-btn active bg-orange-500 text-white px-4 py-2 rounded-full hover:bg-orange-600 transition-colors" data-filter="*">
					Tất cả
				</button>
				<?php
				if (!empty($product_categories) && !is_wp_error($product_categories)) :
					foreach (array_slice($product_categories, 0, 5) as $category) :
				?>
					<button class="filter-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-orange-500 hover:text-white transition-colors"
							data-filter=".cat-<?php echo esc_attr($category->slug); ?>">
						<?php echo esc_html($category->name); ?>
					</button>
				<?php
					endforeach;
				endif;
				?>
			</div>

			<!-- Products Grid -->
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="products-grid">
				<?php
				// Get all products with pagination
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$products_args = array(
					'post_type' => 'product',
					'posts_per_page' => 20,
					'paged' => $paged,
					'post_status' => 'publish'
				);
				$products_query = new WP_Query($products_args);

				if ($products_query->have_posts()) :
					while ($products_query->have_posts()) : $products_query->the_post();
						global $product;

						// Get product categories for filtering
						$product_cats = wp_get_post_terms(get_the_ID(), 'product_cat');
						$cat_classes = '';
						if (!empty($product_cats)) {
							foreach ($product_cats as $cat) {
								$cat_classes .= ' cat-' . $cat->slug;
							}
						}
				?>
					<div class="product-item<?php echo esc_attr($cat_classes); ?> bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
						<div class="aspect-square overflow-hidden relative group">
							<?php if ($product->is_on_sale()) : ?>
								<span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded z-10">
									<?php echo esc_html__('Sale', 'aratavietnam'); ?>
								</span>
							<?php endif; ?>

							<?php if (!$product->is_in_stock()) : ?>
								<span class="absolute top-2 right-2 bg-gray-500 text-white text-xs px-2 py-1 rounded z-10">
									<?php echo esc_html__('Hết hàng', 'aratavietnam'); ?>
								</span>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>">
								<?php
								if (has_post_thumbnail()) {
									the_post_thumbnail('woocommerce_thumbnail', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300'));
								} else {
									echo '<img src="' . wc_placeholder_img_src() . '" alt="' . esc_attr(get_the_title()) . '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">';
								}
								?>
							</a>

							<!-- Quick view overlay -->
							<div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
								<a href="<?php the_permalink(); ?>" class="bg-white text-gray-900 px-4 py-2 rounded hover:bg-gray-100 transition-colors">
									<?php echo esc_html__('Xem chi tiết', 'aratavietnam'); ?>
								</a>
							</div>
						</div>

						<div class="p-4">
							<h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2 h-10">
								<a href="<?php the_permalink(); ?>" class="hover:text-orange-500 transition-colors">
									<?php the_title(); ?>
								</a>
							</h3>

							<div class="flex items-center justify-between mb-2">
								<div class="text-orange-500 font-bold text-sm">
									<?php echo $product->get_price_html(); ?>
								</div>

								<?php if ($product->get_average_rating()) : ?>
									<div class="flex items-center text-xs text-gray-500">
										<span class="text-yellow-400">★</span>
										<span class="ml-1"><?php echo esc_html($product->get_average_rating()); ?></span>
									</div>
								<?php endif; ?>
							</div>

							<?php if ($product->is_in_stock()) : ?>
								<button class="w-full bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded text-sm transition-colors duration-200 add-to-cart-btn"
										data-product-id="<?php echo esc_attr($product->get_id()); ?>">
									<?php echo esc_html__('Thêm vào giỏ', 'aratavietnam'); ?>
								</button>
							<?php else : ?>
								<button class="w-full bg-gray-400 text-white px-3 py-2 rounded text-sm cursor-not-allowed" disabled>
									<?php echo esc_html__('Hết hàng', 'aratavietnam'); ?>
								</button>
							<?php endif; ?>
						</div>
					</div>
				<?php
					endwhile;
				else :
				?>
					<div class="col-span-full text-center py-12">
						<div class="max-w-md mx-auto">
							<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
							</svg>
							<h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo esc_html__('Chưa có sản phẩm', 'aratavietnam'); ?></h3>
							<p class="text-gray-500"><?php echo esc_html__('Hiện tại chưa có sản phẩm nào trong cửa hàng.', 'aratavietnam'); ?></p>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- Pagination -->
			<?php if ($products_query->max_num_pages > 1) : ?>
				<div class="mt-12 flex justify-center">
					<div class="flex items-center space-x-2">
						<?php
						echo paginate_links(array(
							'total' => $products_query->max_num_pages,
							'current' => $paged,
							'format' => '?paged=%#%',
							'show_all' => false,
							'end_size' => 1,
							'mid_size' => 2,
							'prev_next' => true,
							'prev_text' => '← Trước',
							'next_text' => 'Sau →',
							'type' => 'plain',
							'add_args' => false,
							'add_fragment' => '',
							'before_page_number' => '',
							'after_page_number' => ''
						));
						?>
					</div>
				</div>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>
		</div>
	</section>
</main>

<style>
.line-clamp-2 {
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}

.product-item {
	transition: all 0.3s ease;
}

.product-item.hide {
	opacity: 0;
	transform: scale(0.8);
	pointer-events: none;
}

.filter-btn.active {
	background-color: #f97316;
	color: white;
}

.pagination a, .pagination span {
	display: inline-block;
	padding: 8px 12px;
	margin: 0 4px;
	text-decoration: none;
	border: 1px solid #e5e7eb;
	border-radius: 6px;
	color: #374151;
	transition: all 0.2s;
}

.pagination a:hover {
	background-color: #f97316;
	color: white;
	border-color: #f97316;
}

.pagination .current {
	background-color: #f97316;
	color: white;
	border-color: #f97316;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Product filter functionality
	const filterButtons = document.querySelectorAll('.filter-btn');
	const productItems = document.querySelectorAll('.product-item');

	filterButtons.forEach(button => {
		button.addEventListener('click', function() {
			const filter = this.getAttribute('data-filter');

			// Update active button
			filterButtons.forEach(btn => btn.classList.remove('active', 'bg-orange-500', 'text-white'));
			filterButtons.forEach(btn => btn.classList.add('bg-gray-200', 'text-gray-700'));

			this.classList.remove('bg-gray-200', 'text-gray-700');
			this.classList.add('active', 'bg-orange-500', 'text-white');

			// Filter products
			productItems.forEach(item => {
				if (filter === '*' || item.classList.contains(filter.substring(1))) {
					item.classList.remove('hide');
				} else {
					item.classList.add('hide');
				}
			});
		});
	});

	// Add to cart functionality
	const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

	addToCartButtons.forEach(button => {
		button.addEventListener('click', function(e) {
			e.preventDefault();

			const productId = this.getAttribute('data-product-id');
			const originalText = this.textContent;

			// Show loading state
			this.disabled = true;
			this.textContent = 'Đang thêm...';
			this.classList.add('opacity-75');

			// AJAX add to cart
			fetch(wc_add_to_cart_params.ajax_url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: new URLSearchParams({
					'action': 'woocommerce_add_to_cart',
					'product_id': productId,
					'quantity': 1
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					this.textContent = 'Đã thêm ✓';
					this.classList.add('bg-green-500');
					this.classList.remove('bg-orange-500');

					// Update cart count if exists
					const cartCount = document.querySelector('.cart-count');
					if (cartCount && data.cart_count) {
						cartCount.textContent = data.cart_count;
					}

					// Reset button after 2 seconds
					setTimeout(() => {
						this.textContent = originalText;
						this.classList.remove('bg-green-500');
						this.classList.add('bg-orange-500');
						this.disabled = false;
						this.classList.remove('opacity-75');
					}, 2000);
				} else {
					this.textContent = 'Lỗi';
					this.classList.add('bg-red-500');
					this.classList.remove('bg-orange-500');

					setTimeout(() => {
						this.textContent = originalText;
						this.classList.remove('bg-red-500');
						this.classList.add('bg-orange-500');
						this.disabled = false;
						this.classList.remove('opacity-75');
					}, 2000);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				this.textContent = originalText;
				this.disabled = false;
				this.classList.remove('opacity-75');
			});
		});
	});

	// Smooth scroll for category links
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			e.preventDefault();
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				target.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
			}
		});
	});

	// Lazy loading for images
	if ('IntersectionObserver' in window) {
		const imageObserver = new IntersectionObserver((entries, observer) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					const img = entry.target;
					img.src = img.dataset.src;
					img.classList.remove('lazy');
					imageObserver.unobserve(img);
				}
			});
		});

		document.querySelectorAll('img[data-src]').forEach(img => {
			imageObserver.observe(img);
		});
	}
});
</script>
