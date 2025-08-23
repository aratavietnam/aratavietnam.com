/**
 * Single Product Page JavaScript
 * Handles image gallery, tabs, and quantity controls
 */

document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    const mainImage = document.getElementById('main-product-image');
    
    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
                const imageId = this.dataset.imageId;
                
                // Remove active class from all thumbnails
                thumbnails.forEach(t => {
                    t.classList.remove('active', 'border-primary');
                    t.classList.add('border-gray-200');
                });
                
                // Add active class to clicked thumbnail
                this.classList.add('active', 'border-primary');
                this.classList.remove('border-gray-200');
                
                // Update main image
                const newImage = this.querySelector('img');
                if (newImage) {
                    const mainImageElement = mainImage.querySelector('img');
                    if (mainImageElement) {
                        // Get the full-size image URL from the thumbnail's data attribute or src
                        const fullImageUrl = newImage.src.replace('-150x150', '').replace('-300x300', '');
                        mainImageElement.src = fullImageUrl;
                        mainImageElement.alt = newImage.alt;
                    }
                }
            });
        });
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
