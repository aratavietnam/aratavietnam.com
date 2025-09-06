<?php
/**
 * Job Posting Archive Template - Based on home.php blog structure
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-white">
    <!-- Compact Hero Section -->
    <section class="relative bg-gradient-to-br from-primary via-secondary to-tertiary text-white">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative container mx-auto px-4 py-12 sm:py-16">
            <div class="text-center">
                <!-- Elegant brand indicator -->
                <div class="inline-flex items-center mb-4">
                    <div class="w-6 h-0.5 bg-white/60 rounded-full mr-3"></div>
                    <span class="text-white/80 font-medium text-xs uppercase tracking-widest">Arata Vietnam</span>
                    <div class="w-6 h-0.5 bg-white/60 rounded-full ml-3"></div>
                </div>

                <!-- Compact title -->
                <h1 class="text-3xl sm:text-5xl font-bold mb-4 leading-tight">
                    Tuyển dụng
                </h1>

                <!-- Smaller description -->
                <p class="text-lg sm:text-xl mb-6 text-white/90 leading-relaxed max-w-2xl mx-auto">
                    Khám phá các cơ hội việc làm tuyệt vời và gia nhập đội ngũ chuyên nghiệp của Arata Vietnam
                </p>

                <!-- Compact buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="#jobs" class="inline-flex items-center px-6 py-3 bg-white text-primary font-semibold hover:bg-gray-100 transition-all duration-300 rounded-lg no-underline text-sm">
                        Khám phá ngay
                    </a>
                    <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>" class="inline-flex items-center px-6 py-3 border border-white/30 text-white hover:bg-white hover:text-primary transition-all duration-300 rounded-lg no-underline text-sm">
                        Liên hệ
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section id="jobs" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-black mb-4">Cơ hội việc làm</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Khám phá những vị trí tuyển dụng hấp dẫn và thú vị nhất tại Arata Vietnam</p>
            </div>

            <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php while ( have_posts() ) : the_post(); ?>
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
                                        Tuyển dụng
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-black mb-3 group-hover:text-gray-600 transition-colors duration-300">
                                    <a href="<?php the_permalink(); ?>" class="no-underline hover:underline"><?php the_title(); ?></a>
                                </h3>

                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ?: 'Khám phá cơ hội việc làm thú vị này ngay bây giờ!' ) ); ?>
                                </p>

                                <div class="flex items-center justify-between">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-sm text-gray-500">
                                        <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
                                    </time>

                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-black hover:text-gray-600 font-medium text-sm group-hover:translate-x-1 transition-all duration-300 no-underline">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => '<span class="mr-2">&laquo;</span> Trang trước',
                        'next_text' => 'Trang sau <span class="ml-2">&raquo;</span>',
                        'screen_reader_text' => ' ',
                        'before_page_number' => '<span class="inline-flex items-center justify-center w-10 h-10">',
                        'after_page_number'  => '</span>',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Không có việc làm</span>
                    </div>
                    <h3 class="text-xl font-semibold text-black mb-2">Chưa có vị trí tuyển dụng nào</h3>
                    <p class="text-gray-600">Hãy quay lại sau để xem các cơ hội việc làm mới nhất!</p>
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
                        <span class="text-black text-lg font-bold"><?php echo wp_count_posts('job_posting')->publish; ?>+</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2"><?php echo wp_count_posts('job_posting')->publish; ?>+</h3>
                    <p class="text-gray-600">Vị trí tuyển dụng</p>
                </div>

                <div class="p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200">
                        <span class="text-black text-lg font-bold">100%</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2">100%</h3>
                    <p class="text-gray-600">Môi trường chuyên nghiệp</p>
                </div>

                <div class="p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200">
                        <span class="text-black text-lg font-bold">24/7</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-2">24/7</h3>
                    <p class="text-gray-600">Hỗ trợ ứng viên</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-black text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6">Sẵn sàng gia nhập đội ngũ?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Khám phá cơ hội nghề nghiệp tuyệt vời và phát triển cùng Arata Vietnam</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>" class="inline-flex items-center px-8 py-4 bg-white text-black font-semibold hover:bg-gray-100 transition-all duration-300 rounded-lg no-underline">
                    Ứng tuyển ngay
                </a>
                <a href="<?php echo esc_url( home_url( '/gioi-thieu' ) ); ?>" class="inline-flex items-center px-8 py-4 border border-white text-white hover:bg-white hover:text-black transition-all duration-300 rounded-lg no-underline">
                    Tìm hiểu về chúng tôi
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>