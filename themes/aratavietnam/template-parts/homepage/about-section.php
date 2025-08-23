<?php
/**
 * Homepage About Arata Section
 */
?>

<!-- About Arata Section -->
<section class="py-16 bg-gradient-to-br from-secondary/10 to-primary/5">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Side: Company Images with Floating Effect -->
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Main large image -->
                    <div class="col-span-2 relative">
                        <div class="floating-image-1 bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-main.jpg" 
                                 alt="Arata Vietnam Office" 
                                 class="w-full h-48 object-cover rounded-lg" />
                        </div>
                    </div>
                    
                    <!-- Two smaller images -->
                    <div class="floating-image-2">
                        <div class="bg-white rounded-xl p-3 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-team.jpg" 
                                 alt="Đội ngũ chuyên nghiệp" 
                                 class="w-full h-32 object-cover rounded-lg" />
                        </div>
                    </div>
                    
                    <div class="floating-image-3">
                        <div class="bg-white rounded-xl p-3 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-products.jpg" 
                                 alt="Sản phẩm chất lượng" 
                                 class="w-full h-32 object-cover rounded-lg" />
                        </div>
                    </div>
                </div>

                <!-- Floating Product Images -->
                <div class="absolute -top-4 -right-4 floating-product-1 w-20 h-20 bg-white rounded-full p-2 shadow-lg">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product-sample-1.png" 
                         alt="Sản phẩm 1" 
                         class="w-full h-full object-contain" />
                </div>
                
                <div class="absolute top-1/2 -left-6 floating-product-2 w-16 h-16 bg-white rounded-full p-2 shadow-lg">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product-sample-2.png" 
                         alt="Sản phẩm 2" 
                         class="w-full h-full object-contain" />
                </div>
                
                <div class="absolute -bottom-6 left-1/3 floating-product-3 w-18 h-18 bg-white rounded-full p-2 shadow-lg">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product-sample-3.png" 
                         alt="Sản phẩm 3" 
                         class="w-full h-full object-contain" />
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-8 left-8 w-4 h-4 bg-primary rounded-full animate-pulse"></div>
                <div class="absolute bottom-12 right-12 w-6 h-6 bg-tertiary rounded-full animate-pulse delay-1000"></div>
                <div class="absolute top-1/3 right-8 w-3 h-3 bg-secondary rounded-full animate-pulse delay-500"></div>
            </div>

            <!-- Right Side: Content -->
            <div class="space-y-6">
                <!-- Section Header -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                        <span class="text-primary font-medium text-sm uppercase tracking-wider">Về chúng tôi</span>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        <span class="text-secondary">Về</span> 
                        <span class="text-primary">Arata</span>
                    </h2>
                </div>

                <!-- Company Description -->
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        <strong class="text-primary">Arata Việt Nam</strong> là công ty con của Tập đoàn Arata Nhật Bản, 
                        được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản 
                        cho thị trường Việt Nam.
                    </p>
                    
                    <p class="text-gray-600 mb-6">
                        Chúng tôi chuyên nhập khẩu trực tiếp các sản phẩm từ các thương hiệu uy tín tại Nhật Bản, 
                        đảm bảo tính chính hãng và chất lượng tốt nhất cho khách hàng.
                    </p>
                </div>

                <!-- Key Features -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                            <span data-icon="award" data-size="20" class="text-primary"></span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Chất lượng cao</h4>
                            <p class="text-sm text-gray-600">Sản phẩm chính hãng từ Nhật Bản</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center">
                            <span data-icon="users" data-size="20" class="text-secondary"></span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Đội ngũ chuyên nghiệp</h4>
                            <p class="text-sm text-gray-600">Kinh nghiệm nhiều năm</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-tertiary/10 rounded-full flex items-center justify-center">
                            <span data-icon="truck" data-size="20" class="text-tertiary"></span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Giao hàng toàn quốc</h4>
                            <p class="text-sm text-gray-600">Nhanh chóng và an toàn</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-success/10 rounded-full flex items-center justify-center">
                            <span data-icon="heart" data-size="20" class="text-success"></span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Dịch vụ tận tâm</h4>
                            <p class="text-sm text-gray-600">Hỗ trợ khách hàng 24/7</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-3 gap-6 py-6 border-t border-b border-gray-200">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary mb-1" data-count="1000">1000</div>
                        <p class="text-sm text-gray-600">+ Khách hàng</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-secondary mb-1" data-count="50">50</div>
                        <p class="text-sm text-gray-600">+ Sản phẩm</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-tertiary mb-1" data-count="5">5</div>
                        <p class="text-sm text-gray-600">+ Năm kinh nghiệm</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-4">
                    <a href="<?php echo home_url('/ve-arata-vietnam'); ?>" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-lg hover:from-primary-dark hover:to-secondary-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span data-icon="info" data-size="20" class="mr-2"></span>
                        Tìm hiểu thêm về Arata
                        <span data-icon="arrow-right" data-size="20" class="ml-2"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animated counters
    const counters = document.querySelectorAll('[data-count]');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current) + (counter.textContent.includes('+') ? '+' : '');
        }, 16);
    };
    
    // Intersection Observer for counters
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
});
</script>

<style>
/* Floating animations */
@keyframes float1 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(2deg); }
}

@keyframes float2 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-2deg); }
}

@keyframes float3 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-8px) rotate(1deg); }
}

@keyframes floatProduct1 {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-12px) scale(1.05); }
}

@keyframes floatProduct2 {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-8px) scale(1.03); }
}

@keyframes floatProduct3 {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-10px) scale(1.04); }
}

.floating-image-1 {
    animation: float1 4s ease-in-out infinite;
}

.floating-image-2 {
    animation: float2 5s ease-in-out infinite 0.5s;
}

.floating-image-3 {
    animation: float3 4.5s ease-in-out infinite 1s;
}

.floating-product-1 {
    animation: floatProduct1 3s ease-in-out infinite;
}

.floating-product-2 {
    animation: floatProduct2 3.5s ease-in-out infinite 0.8s;
}

.floating-product-3 {
    animation: floatProduct3 3.2s ease-in-out infinite 1.2s;
}
</style>
