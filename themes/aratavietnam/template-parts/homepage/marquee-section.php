<?php
/**
 * Homepage Marquee Section - Running Text
 */

// Get homepage ID and marquee text setting
$front_page_id = get_option('page_on_front');
$marquee_text = get_post_meta($front_page_id, '_marquee_text', true);

// Default text if not set
if (empty($marquee_text)) {
    $marquee_text = 'ARATA - NHÀ PHÂN PHỐI HÓA MỸ PHẨM HÀNG ĐẦU NHẬT BẢN';
}
?>

<!-- Marquee Section -->
<section class="marquee-section bg-white py-8 overflow-hidden">
    <div class="marquee-container">
        <div class="marquee-content">
            <span class="marquee-text"><?php echo esc_html($marquee_text); ?></span>
            <span class="marquee-text"><?php echo esc_html($marquee_text); ?></span>
            <span class="marquee-text"><?php echo esc_html($marquee_text); ?></span>
            <span class="marquee-text"><?php echo esc_html($marquee_text); ?></span>
        </div>
    </div>
</section>

<style>
.marquee-section {
    position: relative;
    background: white;
    border-bottom: 0.5px solid #e74c3c;
}

.marquee-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
}

.marquee-content {
    display: inline-flex;
    animation: marqueeMove 60s linear infinite;
    will-change: transform;
    transform: translateX(50vw);
}

.marquee-text {
    display: inline-block;
    font-size: 6rem;
    font-weight: 900;
    color: #333333;
    letter-spacing: 0.15em;
    margin-right: 6rem;
    font-family: 'Bahnschrift', 'Arial Black', sans-serif;
    text-transform: uppercase;
    white-space: nowrap;
}

/* Animation chạy từ giữa ra */
@keyframes marqueeMove {
    0% {
        transform: translateX(50vw);
    }
    100% {
        transform: translateX(-100%);
    }
}

/* Hover effect để tạm dừng animation */
.marquee-section:hover .marquee-content {
    animation-play-state: paused;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .marquee-text {
        font-size: 3.5rem;
        margin-right: 4rem;
    }
}

@media (max-width: 768px) {
    .marquee-text {
        font-size: 2.8rem;
        margin-right: 3rem;
    }

    .marquee-section {
        padding: 1.5rem 0;
    }
}

@media (max-width: 480px) {
    .marquee-text {
        font-size: 2.2rem;
        margin-right: 2rem;
    }

    .marquee-section {
        padding: 1rem 0;
    }
}

/* Performance optimizations */
.marquee-content,
.marquee-text {
    backface-visibility: hidden;
    perspective: 1000px;
    transform-style: preserve-3d;
}
</style>
