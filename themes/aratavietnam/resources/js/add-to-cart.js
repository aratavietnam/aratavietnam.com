/**
 * Enhanced Add to Cart functionality with notifications
 * Handles AJAX add to cart with comprehensive feedback
 */

import NotificationManager from './notifications.js';

class AddToCartManager {
    constructor() {
        this.isLoading = false;
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupWooCommerceIntegration();
    }

    bindEvents() {
        // Handle add to cart form submissions
        document.addEventListener('submit', (e) => {
            if (e.target.matches('form.cart, .cart')) {
                e.preventDefault();
                this.handleAddToCart(e.target);
            }
        });

        // Handle direct add to cart button clicks
        document.addEventListener('click', (e) => {
            if (e.target.matches('[name="add-to-cart"], .add_to_cart_button')) {
                e.preventDefault();
                this.handleDirectAddToCart(e.target);
            }
        });
    }

    setupWooCommerceIntegration() {
        // Listen for WooCommerce AJAX events
        document.addEventListener('added_to_cart', (e) => {
            this.handleAddedToCart(e.detail);
        });

        document.addEventListener('wc_add_to_cart_error', (e) => {
            this.handleAddToCartError(e.detail);
        });
    }

    async handleAddToCart(form) {
        if (this.isLoading) return;

        const formData = new FormData(form);
        const productId = formData.get('add-to-cart') || formData.get('product_id');
        const quantity = formData.get('quantity') || 1;
        const variation = formData.get('variation_id');

        if (!productId) {
            this.showError('Không thể xác định sản phẩm');
            return;
        }

        const button = form.querySelector('[name="add-to-cart"], .single_add_to_cart_button');
        
        try {
            this.setLoadingState(button, true);
            
            const result = await this.addToCartAjax({
                product_id: productId,
                quantity: quantity,
                variation_id: variation
            });

            if (result.success) {
                this.handleSuccess(result.data);
            } else {
                this.handleError(result.data);
            }

        } catch (error) {
            console.error('Add to cart error:', error);
            this.showError('Có lỗi xảy ra khi thêm sản phẩm');
        } finally {
            this.setLoadingState(button, false);
        }
    }

    async handleDirectAddToCart(button) {
        if (this.isLoading) return;

        const productId = button.value || button.dataset.productId;
        const quantity = button.dataset.quantity || 1;

        if (!productId) {
            this.showError('Không thể xác định sản phẩm');
            return;
        }

        try {
            this.setLoadingState(button, true);
            
            const result = await this.addToCartAjax({
                product_id: productId,
                quantity: quantity
            });

            if (result.success) {
                this.handleSuccess(result.data);
            } else {
                this.handleError(result.data);
            }

        } catch (error) {
            console.error('Add to cart error:', error);
            this.showError('Có lỗi xảy ra khi thêm sản phẩm');
        } finally {
            this.setLoadingState(button, false);
        }
    }

    async addToCartAjax(data) {
        const formData = new FormData();
        formData.append('action', 'woocommerce_add_to_cart');
        formData.append('product_id', data.product_id);
        formData.append('quantity', data.quantity);
        
        if (data.variation_id) {
            formData.append('variation_id', data.variation_id);
        }

        // Add nonce if available
        if (window.wc_add_to_cart_params?.wc_ajax_nonce) {
            formData.append('_wpnonce', window.wc_add_to_cart_params.wc_ajax_nonce);
        }

        const response = await fetch(window.wc_add_to_cart_params?.ajax_url || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.text();
        
        try {
            return JSON.parse(result);
        } catch (e) {
            // Handle HTML response (typical WooCommerce behavior)
            if (result.includes('error') || result.includes('Error')) {
                return { success: false, data: { message: 'Có lỗi xảy ra khi thêm sản phẩm' } };
            }
            return { success: true, data: { message: 'Đã thêm sản phẩm vào giỏ hàng' } };
        }
    }

    handleSuccess(data) {
        const productName = this.getProductName();
        
        window.notificationManager.success(
            `Đã thêm "${productName}" vào giỏ hàng`,
            {
                description: 'Sản phẩm đã được thêm thành công',
                actions: [
                    {
                        text: 'Xem giỏ hàng',
                        onclick: `window.location.href='${this.getCartUrl()}'`
                    },
                    {
                        text: 'Tiếp tục mua',
                        onclick: 'window.notificationManager.remove(this.closest(".transform"))'
                    }
                ]
            }
        );

        // Update cart count if element exists
        this.updateCartCount();
        
        // Trigger custom event
        this.triggerEvent('arata_added_to_cart', data);
    }

    handleError(data) {
        const message = data?.message || 'Có lỗi xảy ra khi thêm sản phẩm';
        
        if (message.includes('stock') || message.includes('hết hàng') || message.includes('out of stock')) {
            this.handleOutOfStock();
        } else if (message.includes('quantity') || message.includes('số lượng')) {
            this.handleInvalidQuantity(message);
        } else {
            this.showError(message);
        }
    }

    handleOutOfStock() {
        window.notificationManager.error(
            'Sản phẩm đã hết hàng',
            {
                description: 'Sản phẩm này hiện tại không còn hàng trong kho',
                actions: [
                    {
                        text: 'Thông báo khi có hàng',
                        onclick: 'this.closest(".transform").querySelector("button").click(); alert("Tính năng sẽ sớm được cập nhật!");'
                    }
                ]
            }
        );

        // Disable add to cart button
        const addToCartButton = document.querySelector('[name="add-to-cart"]');
        if (addToCartButton) {
            addToCartButton.disabled = true;
            addToCartButton.textContent = 'Hết hàng';
            addToCartButton.classList.remove('bg-primary', 'hover:bg-primary-dark');
            addToCartButton.classList.add('bg-gray-400', 'cursor-not-allowed');
        }
    }

    handleInvalidQuantity(message) {
        window.notificationManager.warning(
            'Số lượng không hợp lệ',
            {
                description: message,
                actions: [
                    {
                        text: 'Điều chỉnh',
                        onclick: 'document.querySelector("[name=quantity]")?.focus(); window.notificationManager.remove(this.closest(".transform"));'
                    }
                ]
            }
        );
    }

    handleAddedToCart(data) {
        // Handle WooCommerce native added_to_cart event
        this.handleSuccess(data);
    }

    handleAddToCartError(data) {
        // Handle WooCommerce native error event
        this.handleError(data);
    }

    showError(message) {
        window.notificationManager.error(message, {
            description: 'Vui lòng thử lại hoặc liên hệ hỗ trợ nếu vấn đề tiếp tục'
        });
    }

    setLoadingState(button, isLoading) {
        this.isLoading = isLoading;
        
        if (!button) return;

        if (isLoading) {
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-wait');
            
            const originalText = button.innerHTML;
            button.dataset.originalText = originalText;
            
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Đang thêm...
            `;
        } else {
            button.disabled = false;
            button.classList.remove('opacity-75', 'cursor-wait');
            
            if (button.dataset.originalText) {
                button.innerHTML = button.dataset.originalText;
                delete button.dataset.originalText;
            }
        }
    }

    getProductName() {
        const titleElement = document.querySelector('.product_title, h1.entry-title, [data-product-title]');
        return titleElement ? titleElement.textContent.trim() : 'Sản phẩm';
    }

    getCartUrl() {
        return window.wc_add_to_cart_params?.cart_url || '/gio-hang';
    }

    async updateCartCount() {
        try {
            const response = await fetch(window.wc_add_to_cart_params?.ajax_url || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_cart_contents',
                credentials: 'same-origin'
            });

            const result = await response.json();
            
            if (result.success) {
                const cartCountElements = document.querySelectorAll('[data-cart-count], .cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = result.data.count || '0';
                });

                // Trigger cart updated event
                this.triggerEvent('arata_cart_updated', result.data);
            }
        } catch (error) {
            console.error('Failed to update cart count:', error);
        }
    }

    triggerEvent(eventName, data = {}) {
        const event = new CustomEvent(eventName, {
            detail: data,
            bubbles: true,
            cancelable: true
        });
        document.dispatchEvent(event);
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.addToCartManager = new AddToCartManager();
    });
} else {
    window.addToCartManager = new AddToCartManager();
}

export default AddToCartManager;
