<?php
/**
 * Singular Template - Override for single posts
 * This will be used when show_on_front is set to 'posts'
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="relative bg-black text-white">
        <div class="container mx-auto px-4 py-20 sm:py-32">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl sm:text-6xl font-bold mb-6 leading-tight">
                    <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                </h1>
                <p class="text-xl sm:text-2xl mb-8 text-gray-300 leading-relaxed">
                    <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#posts" class="inline-flex items-center px-8 py-4 bg-white text-black font-semibold hover:bg-gray-100 transition-all duration-300 rounded-lg no-underline">
                        Khám phá ngay
                    </a>
                    <a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>" class="inline-flex items-center px-8 py-4 border border-white text-white hover:bg-white hover:text-black transition-all duration-300 rounded-lg no-underline">
                        Quản trị
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Posts Section -->
    <section id="posts" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-black mb-4">Bài viết nổi bật</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Khám phá những bài viết mới nhất và thú vị nhất từ chúng tôi</p>
            </div>

            <?php
            $featured_query = new WP_Query([
                'posts_per_page' => 4,
                'ignore_sticky_posts' => true,
                'no_found_rows' => true,
                'suppress_filters' => true,
            ]);
            ?>

            <?php if ( $featured_query->have_posts() ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
                        <article class="group bg-white border border-gray-200 hover:border-gray-400 transition-all duration-300 rounded-xl overflow-hidden">
                            <div class="relative overflow-hidden">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium_large', [ 'class' => 'w-full h-48 object-cover' ] ); ?>
                                <?php else : ?>
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Không có ảnh</span>
                                    </div>
                                <?php endif; ?>

                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-white text-black text-xs font-medium rounded-full border border-gray-200">
                                        Bài viết
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-black mb-3 group-hover:text-gray-600 transition-colors duration-300">
                                    <a href="<?php the_permalink(); ?>" class="no-underline hover:underline"><?php the_title(); ?></a>
                                </h3>

                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ?: 'Khám phá bài viết thú vị này ngay bây giờ!' ) ); ?>
                                </p>

                                <div class="flex items-center justify-between">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-sm text-gray-500">
                                        <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
                                    </time>

                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-black hover:text-gray-600 font-medium text-sm group-hover:translate-x-1 transition-all duration-300 no-underline">
                                        Đọc tiếp
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <!-- View All Posts Button -->
                <div class="text-center mt-12">
                    <a href="<?php echo esc_url( home_url( '/?post_type=post' ) ); ?>" class="inline-flex items-center px-8 py-4 bg-black text-white font-semibold hover:bg-gray-800 transition-all duration-300 rounded-lg no-underline">
                        Xem tất cả bài viết
                    </a>
                </div>
            <?php else : ?>
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Không có bài viết</span>
                    </div>
                    <h3 class="text-xl font-semibold text-black mb-2">Chưa có bài viết nào</h3>
                    <p class="text-gray-600">Hãy tạo bài viết đầu tiên để bắt đầu!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200">
                        <span class="text-black text-lg font-bold"><?php echo wp_count_posts()->publish; ?>+</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2"><?php echo wp_count_posts()->publish; ?>+</h3>
                    <p class="text-gray-600">Bài viết chất lượng</p>
                </div>

                <div class="p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200">
                        <span class="text-black text-lg font-bold">100%</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2">100%</h3>
                    <p class="text-gray-600">Nội dung gốc</p>
                </div>

                <div class="p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200">
                        <span class="text-black text-lg font-bold">24/7</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2">24/7</h3>
                    <p class="text-gray-600">Luôn sẵn sàng</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-black text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6">Sẵn sàng bắt đầu?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Khám phá thế giới nội dung đa dạng và thú vị ngay hôm nay</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url( home_url( '/?post_type=post' ) ); ?>" class="inline-flex items-center px-8 py-4 bg-white text-black font-semibold hover:bg-gray-100 transition-all duration-300 rounded-lg no-underline">
                    Khám phá ngay
                </a>
                <a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>" class="inline-flex items-center px-8 py-4 border border-white text-white hover:bg-white hover:text-black transition-all duration-300 rounded-lg no-underline">
                    Quản trị website
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
