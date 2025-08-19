// Import Lucide Icons
import './icons.js';

// Font Loading Detection for Google Fonts
function detectFontLoading() {
    // Check if Font Loading API is supported
    if ('fonts' in document) {
        // Check for Inter font (our primary font)
        document.fonts.load('16px "Inter"').then(function() {
            document.documentElement.classList.add('font-loaded');
        }).catch(function() {
            document.documentElement.classList.add('font-fallback');
        });

        // Set a reasonable timeout
        setTimeout(function() {
            if (!document.documentElement.classList.contains('font-loaded')) {
                document.documentElement.classList.add('font-fallback');
            }
        }, 2000); // 2 second timeout
    } else {
        // Graceful fallback for older browsers
        document.documentElement.classList.add('font-fallback');
    }
}

// Vietnamese Text Detection and Font Optimization
function optimizeVietnameseText() {
    // Vietnamese character pattern
    const vietnamesePattern = /[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/i;

    // Find all text nodes and check for Vietnamese characters
    function checkTextNodes(node) {
        if (node.nodeType === Node.TEXT_NODE) {
            if (vietnamesePattern.test(node.textContent)) {
                // Add Vietnamese language attribute to parent element
                let parent = node.parentElement;
                if (parent && !parent.hasAttribute('lang')) {
                    parent.setAttribute('lang', 'vi');
                }
            }
        } else {
            for (let child of node.childNodes) {
                checkTextNodes(child);
            }
        }
    }

    // Check all text content
    checkTextNodes(document.body);
}

// Navigation Menu Toggle
function initNavigation() {
    let mainNavigation = document.getElementById('primary-navigation')
    let mainNavigationToggle = document.querySelector('.menu-toggle')

    if(mainNavigation && mainNavigationToggle) {
        mainNavigationToggle.addEventListener('click', function (e) {
            e.preventDefault()
            mainNavigation.classList.toggle('hidden')

            // Update aria-expanded attribute
            const isExpanded = !mainNavigation.classList.contains('hidden')
            mainNavigationToggle.setAttribute('aria-expanded', isExpanded)

            // Toggle hamburger icon
            const icon = mainNavigationToggle.querySelector('svg')
            if (icon) {
                if (isExpanded) {
                    // Change to X icon
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                } else {
                    // Change back to hamburger icon
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>'
                }
            }
        })

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mainNavigation.contains(e.target) && !mainNavigationToggle.contains(e.target)) {
                mainNavigation.classList.add('hidden')
                mainNavigationToggle.setAttribute('aria-expanded', 'false')

                // Reset to hamburger icon
                const icon = mainNavigationToggle.querySelector('svg')
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>'
                }
            }
        })

        // Close mobile menu on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) { // lg breakpoint
                mainNavigation.classList.add('hidden')
                mainNavigationToggle.setAttribute('aria-expanded', 'false')
            }
        })
    }
}

// Font Performance Monitoring
function monitorFontPerformance() {
    if ('performance' in window && 'getEntriesByType' in performance) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                const resources = performance.getEntriesByType('resource');
                const fontResources = resources.filter(resource =>
                    resource.name.includes('fonts.gstatic.com') ||
                    resource.name.includes('Inter') ||
                    resource.name.includes('.woff')
                );

                // Font resources loaded successfully
            }, 1000);
        });
    }
}

// Search functionality
function initSearch() {
    const searchInput = document.getElementById('header-search')
    const searchResults = document.getElementById('search-results')
    const mobileSearchToggle = document.querySelector('.search-toggle-mobile')
    let searchTimeout

    if (searchInput && searchResults) {
        // Show/hide search results on focus/blur
        searchInput.addEventListener('focus', function() {
            searchResults.classList.remove('hidden')
        })

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden')
            }
        })

        // Search input handler with debounce
        searchInput.addEventListener('input', function() {
            const query = this.value.trim()

            // Clear previous timeout
            clearTimeout(searchTimeout)

            if (query.length < 2) {
                showSearchPlaceholder()
                return
            }

            // Show loading state
            showSearchLoading()

            // Debounce search request
            searchTimeout = setTimeout(() => {
                performSearch(query)
            }, 300)
        })

        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchResults.classList.add('hidden')
                this.blur()
            }
        })
    }

    function showSearchPlaceholder() {
        searchResults.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <span data-icon="search" data-size="24" data-class="w-6 h-6 mx-auto mb-2 text-gray-300"></span>
                <p class="text-sm">Nhập từ khóa để tìm kiếm...</p>
            </div>
        `
        // Re-initialize icons
        if (window.ArataIcons) {
            window.ArataIcons.init()
        }
    }

    function showSearchLoading() {
        searchResults.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <div class="animate-spin w-6 h-6 mx-auto mb-2 border-2 border-gray-300 border-t-primary rounded-full"></div>
                <p class="text-sm">Đang tìm kiếm...</p>
            </div>
        `
    }

    function performSearch(query) {
        // AJAX search request to WordPress
        fetch(`${window.location.origin}/wp-json/wp/v2/search?search=${encodeURIComponent(query)}&per_page=5`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data, query)
            })
            .catch(error => {
                showSearchError()
            })
    }

    function displaySearchResults(results, query) {
        if (results.length === 0) {
            searchResults.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <span data-icon="search" data-size="24" data-class="w-6 h-6 mx-auto mb-2 text-gray-300"></span>
                    <p class="text-sm">Không tìm thấy kết quả cho "${query}"</p>
                </div>
            `
        } else {
            let resultsHTML = '<div class="py-2">'

            results.forEach(result => {
                resultsHTML += `
                    <a href="${result.url}" class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start space-x-3">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900 line-clamp-1">${result.title}</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">${result.excerpt || 'Không có mô tả'}</p>
                                <span class="text-xs text-primary mt-1 inline-block">${getPostTypeLabel(result.subtype)}</span>
                            </div>
                        </div>
                    </a>
                `
            })

            resultsHTML += `
                <div class="border-t border-gray-100 px-4 py-2">
                    <a href="/?s=${encodeURIComponent(query)}" class="text-sm text-primary hover:text-primary-dark flex items-center">
                        Xem tất cả kết quả
                        <span data-icon="arrow-right" data-size="16" data-class="w-4 h-4 ml-1"></span>
                    </a>
                </div>
            </div>`

            searchResults.innerHTML = resultsHTML
        }

        // Re-initialize icons
        if (window.ArataIcons) {
            window.ArataIcons.init()
        }
    }

    function showSearchError() {
        searchResults.innerHTML = `
            <div class="p-4 text-center text-red-500">
                <p class="text-sm">Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại.</p>
            </div>
        `
    }

    function getPostTypeLabel(subtype) {
        const labels = {
            'post': 'Bài viết',
            'page': 'Trang',
            'product': 'Sản phẩm'
        }
        return labels[subtype] || 'Nội dung'
    }
}

// Cart functionality
function initCart() {
    const cartToggle = document.querySelector('.cart-toggle')
    const cartDropdown = document.getElementById('cart-dropdown')

    if (cartToggle && cartDropdown) {
        // Show cart dropdown on click
        cartToggle.addEventListener('click', function(e) {
            e.preventDefault()
            e.stopPropagation()

            // Toggle dropdown
            cartDropdown.classList.toggle('hidden')

            // Load cart contents if showing
            if (!cartDropdown.classList.contains('hidden')) {
                loadCartContents()
            }
        })

        // Hide cart dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!cartToggle.contains(e.target) && !cartDropdown.contains(e.target)) {
                cartDropdown.classList.add('hidden')
            }
        })

        // Prevent dropdown from closing when clicking inside
        cartDropdown.addEventListener('click', function(e) {
            e.stopPropagation()
        })
    }

    function loadCartContents() {
        // Show loading state
        cartDropdown.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <div class="animate-spin w-6 h-6 mx-auto mb-2 border-2 border-gray-300 border-t-primary rounded-full"></div>
                <p class="text-sm">Đang tải giỏ hàng...</p>
            </div>
        `

        // Fetch cart contents via AJAX
        if (typeof wc_add_to_cart_params !== 'undefined') {
            fetch(wc_add_to_cart_params.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_cart_contents&nonce=' + (wc_add_to_cart_params.wc_ajax_nonce || '')
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayCartContents(data.data)
                } else {
                    showCartError()
                }
            })
            .catch(error => {
                console.error('Cart error:', error)
                showCartError()
            })
        } else {
            // Fallback: show basic cart info
            showBasicCart()
        }
    }

    function displayCartContents(cartData) {
        if (!cartData || cartData.count === 0) {
            cartDropdown.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <span data-icon="cart" data-size="24" data-class="w-6 h-6 mx-auto mb-2 text-gray-300"></span>
                    <p class="text-sm">Giỏ hàng trống</p>
                    <a href="/san-pham" class="text-xs text-primary hover:text-primary-dark mt-2 inline-block">Khám phá sản phẩm</a>
                </div>
            `
        } else {
            let cartHTML = '<div class="max-h-64 overflow-y-auto">'

            // Cart items
            if (cartData.items && cartData.items.length > 0) {
                cartData.items.forEach(item => {
                    cartHTML += `
                        <div class="flex items-center space-x-3 p-3 border-b border-gray-100">
                            <img src="${item.image || '/wp-content/themes/aratavietnam/assets/images/placeholder.jpg'}"
                                 alt="${item.name}"
                                 class="w-12 h-12 object-cover rounded">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">${item.name}</h4>
                                <p class="text-xs text-gray-500">Số lượng: ${item.quantity}</p>
                                <p class="text-sm font-medium text-primary">${item.price}</p>
                            </div>
                            <button class="remove-item text-gray-400 hover:text-red-500 p-1" data-key="${item.key}">
                                <span data-icon="close" data-size="16" data-class="w-4 h-4"></span>
                            </button>
                        </div>
                    `
                })
            }

            // Cart footer
            cartHTML += `
                </div>
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-medium text-gray-900">Tổng cộng:</span>
                        <span class="text-lg font-bold text-primary">${cartData.total || '0₫'}</span>
                    </div>
                    <div class="space-y-2">
                        <a href="/gio-hang" class="block w-full bg-gray-100 text-gray-900 text-center py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                            Xem giỏ hàng
                        </a>
                        <a href="/thanh-toan" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                            Thanh toán
                        </a>
                    </div>
                </div>
            `

            cartDropdown.innerHTML = cartHTML

            // Add remove item event listeners
            cartDropdown.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    removeCartItem(this.dataset.key)
                })
            })
        }

        // Re-initialize icons
        if (window.ArataIcons) {
            window.ArataIcons.init()
        }
    }

    function showCartError() {
        cartDropdown.innerHTML = `
            <div class="p-4 text-center text-red-500">
                <p class="text-sm">Có lỗi xảy ra khi tải giỏ hàng.</p>
                <button onclick="location.reload()" class="text-xs text-primary hover:text-primary-dark mt-2">Thử lại</button>
            </div>
        `
    }

    function showBasicCart() {
        cartDropdown.innerHTML = `
            <div class="p-4 text-center">
                <span data-icon="cart" data-size="24" data-class="w-6 h-6 mx-auto mb-2 text-gray-400"></span>
                <p class="text-sm text-gray-600 mb-3">Giỏ hàng</p>
                <a href="/gio-hang" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                    Xem giỏ hàng
                </a>
            </div>
        `

        // Re-initialize icons
        if (window.ArataIcons) {
            window.ArataIcons.init()
        }
    }

    function removeCartItem(cartKey) {
        if (typeof wc_add_to_cart_params !== 'undefined') {
            fetch(wc_add_to_cart_params.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=remove_cart_item&cart_item_key=${cartKey}&nonce=${wc_add_to_cart_params.wc_ajax_nonce || ''}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload cart contents
                    loadCartContents()
                    // Update cart count in header
                    updateCartCount(data.data.count || 0)
                }
            })
            .catch(error => {
                console.error('Remove item error:', error)
            })
        }
    }

    function updateCartCount(count) {
        const cartCountElement = document.querySelector('.cart-count')
        if (cartCountElement) {
            if (count > 0) {
                cartCountElement.textContent = count
                cartCountElement.classList.remove('hidden')
            } else {
                cartCountElement.classList.add('hidden')
            }
        }
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    detectFontLoading();
    optimizeVietnameseText();
    initNavigation();
    initSearch();
    initCart();
    monitorFontPerformance();
});

// Initialize navigation when window loads (fallback)
window.addEventListener('load', function () {
    initNavigation();
});
