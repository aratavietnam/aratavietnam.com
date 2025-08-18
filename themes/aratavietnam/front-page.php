<?php
/**
 * Front Page Template - Minimal Black & White Design
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="relative bg-brand-gradient text-white">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="container mx-auto px-4 py-20 sm:py-32 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-tertiary rounded-full mr-2"></span>
                    Nền tảng công nghệ Việt Nam
                </div>
                <h1 class="text-4xl sm:text-6xl font-bold mb-6 leading-tight">
                    <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                </h1>
                <p class="text-xl sm:text-2xl mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
                    <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#posts" class="btn-primary bg-white text-primary hover:bg-gray-100 hover:text-primary-dark !no-underline">
                        <span class="mr-2">🚀</span>
                        Khám phá ngay
                    </a>
                    <a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>" class="inline-flex items-center px-8 py-4 border-2 border-white/30 text-white hover:bg-white/10 backdrop-blur-sm transition-all duration-300 rounded-lg no-underline font-semibold">
                        <span class="mr-2">⚙️</span>
                        Quản trị
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent"></div>
    </section>

    <!-- Featured Posts Section -->
    <section id="posts" class="py-20 bg-light">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium mb-4">
                    <span class="mr-2">📚</span>
                    Nội dung chất lượng
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-dark mb-4">Bài viết nổi bật</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Khám phá những bài viết mới nhất và thú vị nhất về công nghệ từ chúng tôi</p>
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
                        <article class="group bg-white border border-gray-200 hover:border-primary/20 hover:shadow-lg transition-all duration-300 rounded-xl overflow-hidden">
                            <div class="relative overflow-hidden">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium_large', [ 'class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300' ] ); ?>
                                <?php else : ?>
                                    <div class="w-full h-48 bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                                        <div class="text-center">
                                            <span class="text-4xl mb-2 block">📄</span>
                                            <span class="text-gray-500 text-sm">Bài viết</span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="badge-primary text-xs">
                                        📝 Bài viết
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-primary transition-colors duration-300">
                                    <a href="<?php the_permalink(); ?>" class="no-underline hover:underline"><?php the_title(); ?></a>
                                </h3>

                                <p class="text-gray-600 mb-4 leading-relaxed line-clamp-3">
                                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ?: 'Khám phá bài viết thú vị này về công nghệ và phát triển phần mềm!' ) ); ?>
                                </p>

                                <div class="flex items-center justify-between">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-sm text-gray-500 flex items-center">
                                        <span class="mr-1">📅</span>
                                        <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
                                    </time>

                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm group-hover:translate-x-1 transition-all duration-300 no-underline">
                                        Đọc tiếp
                                        <span class="ml-1">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <!-- View All Posts Button -->
                <div class="text-center mt-12">
                    <a href="<?php echo esc_url( home_url( '/?post_type=post' ) ); ?>" class="btn-secondary !no-underline">
                        <span class="mr-2">📖</span>
                        Xem tất cả bài viết
                    </a>
                </div>
            <?php else : ?>
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center">
                        <span class="text-4xl">📝</span>
                    </div>
                    <h3 class="text-xl font-semibold text-dark mb-2">Chưa có bài viết nào</h3>
                    <p class="text-gray-600 mb-4">Hãy tạo bài viết đầu tiên để bắt đầu chia sẻ kiến thức!</p>
                    <a href="<?php echo esc_url( home_url( '/wp-admin/post-new.php' ) ); ?>" class="btn-primary !no-underline">
                        <span class="mr-2">✍️</span>
                        Tạo bài viết đầu tiên
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-dark mb-4">Tại sao chọn Arata Vietnam?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Nền tảng chia sẻ kiến thức công nghệ hàng đầu Việt Nam</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 group hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-primary to-primary-light rounded-full flex items-center justify-center text-white text-2xl shadow-lg">
                        📚
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-2"><?php echo wp_count_posts()->publish; ?>+</h3>
                    <p class="text-gray-600">Bài viết chất lượng cao</p>
                </div>

                <div class="p-6 group hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-secondary to-secondary-light rounded-full flex items-center justify-center text-white text-2xl shadow-lg">
                        ✨
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-2">100%</h3>
                    <p class="text-gray-600">Nội dung gốc và độc quyền</p>
                </div>

                <div class="p-6 group hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-tertiary to-tertiary-light rounded-full flex items-center justify-center text-dark text-2xl shadow-lg">
                        🚀
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-2">24/7</h3>
                    <p class="text-gray-600">Luôn cập nhật xu hướng mới</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-brand-gradient-reverse text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <!-- Decorative elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-tertiary/20 rounded-full blur-2xl"></div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6">
                <span class="mr-2">🎯</span>
                Bắt đầu hành trình học tập
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold mb-6">Sẵn sàng khám phá công nghệ?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">Tham gia cộng đồng developer Việt Nam và cập nhật những xu hướng công nghệ mới nhất</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url( home_url( '/?post_type=post' ) ); ?>" class="btn-primary bg-white text-primary hover:bg-gray-100 hover:text-primary-dark !no-underline">
                    <span class="mr-2">🚀</span>
                    Khám phá ngay
                </a>
                <a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>" class="inline-flex items-center px-8 py-4 border-2 border-white/30 text-white hover:bg-white/10 backdrop-blur-sm transition-all duration-300 rounded-lg no-underline font-semibold">
                    <span class="mr-2">⚙️</span>
                    Quản trị website
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
