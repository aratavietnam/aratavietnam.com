/**
 * Single Product Page JavaScript
 * Handles image gallery, tabs, and quantity controls
 */

import PhotoSwipeLightbox from 'photoswipe/lightbox';
import Swiper from 'swiper';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', function() {
    // Swiper and PhotoSwipe for Product Gallery
    const mainSwiperEl = document.querySelector('.main-product-swiper');
    const thumbsSwiperEl = document.querySelector('.thumbs-product-swiper');

    if (mainSwiperEl && thumbsSwiperEl) {
        // Initialize thumbnails swiper first
        const thumbsSwiper = new Swiper(thumbsSwiperEl, {
            modules: [FreeMode],
            spaceBetween: 8,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                320: {
                    slidesPerView: 3,
                    spaceBetween: 6,
                },
                640: {
                    slidesPerView: 4,
                    spaceBetween: 8,
                },
                768: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                }
            }
        });

        // Initialize main swiper
        const mainSwiper = new Swiper(mainSwiperEl, {
            modules: [Navigation, Thumbs],
            spaceBetween: 0,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
            on: {
                slideChange: function() {
                    // Update active thumbnail
                    const activeIndex = this.activeIndex;
                    const thumbSlides = thumbsSwiperEl.querySelectorAll('.swiper-slide');

                    thumbSlides.forEach((slide, index) => {
                        if (index === activeIndex) {
                            slide.classList.add('border-primary', 'border-opacity-100');
                            slide.classList.remove('border-transparent');
                        } else {
                            slide.classList.remove('border-primary', 'border-opacity-100');
                            slide.classList.add('border-transparent');
                        }
                    });

                    // Update slide counter
                    const currentSlideEl = mainSwiperEl.querySelector('.current-slide');
                    if (currentSlideEl) {
                        currentSlideEl.textContent = activeIndex + 1;
                    }
                }
            }
        });

        // Initialize PhotoSwipe Lightbox
        const lightbox = new PhotoSwipeLightbox({
            gallery: '.main-product-swiper .swiper-wrapper',
            children: 'a',
            pswpModule: () => import('photoswipe'),
            paddingFn: (viewportSize) => {
                return {
                    top: 30, bottom: 30, left: 30, right: 30
                };
            }
        });

        // Customize PhotoSwipe UI
        lightbox.on('uiRegister', function() {
            lightbox.pswp.ui.registerElement({
                name: 'custom-caption',
                order: 9,
                isButton: false,
                appendTo: 'root',
                html: 'Caption text',
                onInit: (el, pswp) => {
                    lightbox.pswp.on('change', () => {
                        const currSlideElement = lightbox.pswp.currSlide.data.element;
                        let captionHTML = '';
                        if (currSlideElement) {
                            const hiddenCaption = currSlideElement.querySelector('.hidden-caption-content');
                            if (hiddenCaption) {
                                captionHTML = hiddenCaption.innerHTML;
                            }
                        }
                        el.innerHTML = captionHTML || '';
                    });
                }
            });
        });

        lightbox.init();

        // Set initial active thumbnail
        const firstThumb = thumbsSwiperEl.querySelector('.swiper-slide');
        if (firstThumb) {
            firstThumb.classList.add('border-primary', 'border-opacity-100');
            firstThumb.classList.remove('border-transparent');
        }
    }

    // Tab functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    if (tabBtns.length > 0 && tabContents.length > 0) {
        tabBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const tabId = this.dataset.tab;

                // Remove active classes
                tabBtns.forEach(b => {
                    b.classList.remove('active', 'border-primary', 'text-primary');
                    b.classList.add('border-transparent', 'text-gray-500');
                });

                tabContents.forEach(c => c.classList.add('hidden'));

                // Add active classes
                this.classList.add('active', 'border-primary', 'text-primary');
                this.classList.remove('border-transparent', 'text-gray-500');

                const targetTab = document.getElementById(tabId + '-tab');
                if (targetTab) {
                    targetTab.classList.remove('hidden');
                }
            });
        });
    }

    // Quantity controls
    const quantityInput = document.getElementById('quantity');

    if (quantityInput) {
        // Increase quantity function
        window.increaseQuantity = function() {
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.getAttribute('max')) || 999;
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        };

        // Decrease quantity function
        window.decreaseQuantity = function() {
            const currentValue = parseInt(quantityInput.value);
            const minValue = parseInt(quantityInput.getAttribute('min')) || 1;
            if (currentValue > minValue) {
                quantityInput.value = currentValue - 1;
            }
        };

        // Ensure quantity input is always valid
        quantityInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.getAttribute('min')) || 1;
            const max = parseInt(this.getAttribute('max')) || 999;

            if (isNaN(value) || value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
            }
        });
    }

    // Add to cart form enhancement
    const addToCartForm = document.querySelector('form.cart');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                // Add loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Đang thêm...';

                // Reset button after 3 seconds (in case of errors)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtn.dataset.originalText || 'Thêm vào giỏ hàng';
                }, 3000);
            }
        });
    }
});

    // Copy to clipboard functionality
    const copyBtn = document.getElementById('copy-product-link');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const link = this.dataset.link;
            navigator.clipboard.writeText(link).then(() => {
                const originalIconHTML = this.innerHTML;
                const checkIconSVG = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>';
                this.innerHTML = checkIconSVG;
                setTimeout(() => {
                    this.innerHTML = originalIconHTML;
                }, 2000);
            });
        });
    }
