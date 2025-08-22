// Import Lucide Icons
import './icons.js';

// Import Contact Popup
import './contact-popup.js';

// Font Loading Detection for Google Fonts
function detectFontLoading() {
  // Check if Font Loading API is supported
  if ('fonts' in document) {
    // Check for Inter font (our primary font)
    document.fonts.load('16px "Inter"').then(function () {
      document.documentElement.classList.add('font-loaded');
    }).catch(function () {
      document.documentElement.classList.add('font-fallback');
    });

    // Set a reasonable timeout
    setTimeout(function () {
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
  const menuToggle = document.querySelector('.menu-toggle')
  const mobileNavigation = document.getElementById('primary-navigation')

  if (menuToggle && mobileNavigation && !menuToggle.hasAttribute('data-initialized')) {
    menuToggle.setAttribute('data-initialized', 'true')
    menuToggle.addEventListener('click', function (e) {
      e.preventDefault()
      e.stopPropagation()

      // Toggle mobile navigation
      const isHidden = mobileNavigation.classList.contains('hidden')
      if (isHidden) {
        mobileNavigation.classList.remove('hidden')
        menuToggle.setAttribute('aria-expanded', 'true')
      } else {
        mobileNavigation.classList.add('hidden')
        menuToggle.setAttribute('aria-expanded', 'false')
      }

      // Toggle hamburger icon
      const icon = menuToggle.querySelector('svg')
      if (icon) {
        const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true'
        if (isExpanded) {
          // Change to X icon
          icon.innerHTML = `
                        <line x1="18" x2="6" y1="6" y2="18" stroke-width="2.5"></line>
                        <line x1="6" x2="18" y1="6" y2="18" stroke-width="2.5"></line>
                    `
        } else {
          // Change back to hamburger icon
          icon.innerHTML = `
                        <line x1="4" x2="20" y1="6" y2="6" stroke-width="2.5"></line>
                        <line x1="4" x2="20" y1="12" y2="12" stroke-width="2.5"></line>
                        <line x1="4" x2="20" y1="18" y2="18" stroke-width="2.5"></line>
                    `
        }
      }
    })
  }
}

function createMobileMenu() {
  const mobileMenu = document.createElement('div')
  mobileMenu.id = 'mobile-menu'
  mobileMenu.className = 'fixed inset-0 z-50 lg:hidden'
  mobileMenu.style.backgroundColor = 'rgba(0, 0, 0, 0.3)'

  // Get menu items from desktop navigation
  const desktopNav = document.querySelector('#site-navigation ul')
  let menuItems = ''

  if (desktopNav) {
    const links = desktopNav.querySelectorAll('a')
    links.forEach(link => {
      menuItems += `
                <li>
                    <a href="${link.href}" class="block px-6 py-4 text-gray-900 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                        ${link.textContent}
                    </a>
                </li>
            `
    })
  }

  mobileMenu.innerHTML = `
        <div class="bg-white w-80 h-full shadow-xl">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Menu</h2>
                <button class="mobile-menu-close p-2 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <line x1="18" x2="6" y1="6" y2="18"></line>
                        <line x1="6" x2="18" y1="6" y2="18"></line>
                    </svg>
                </button>
            </div>
            <nav class="py-4">
                <ul>
                    ${menuItems}
                </ul>
            </nav>
        </div>
    `

  // Add close functionality
  const closeButton = mobileMenu.querySelector('.mobile-menu-close')
  closeButton.addEventListener('click', () => {
    mobileMenu.classList.add('hidden')
    document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'false')

    // Reset hamburger icon
    const icon = document.querySelector('.menu-toggle svg')
    if (icon) {
      icon.innerHTML = `
                <line x1="4" x2="20" y1="6" y2="6"></line>
                <line x1="4" x2="20" y1="12" y2="12"></line>
                <line x1="4" x2="20" y1="18" y2="18"></line>
            `
    }
  })

  // Close when clicking overlay
  mobileMenu.addEventListener('click', (e) => {
    if (e.target === mobileMenu) {
      mobileMenu.classList.add('hidden')
      document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'false')

      // Reset hamburger icon
      const icon = document.querySelector('.menu-toggle svg')
      if (icon) {
        icon.innerHTML = `
                    <line x1="4" x2="20" y1="6" y2="6"></line>
                    <line x1="4" x2="20" y1="12" y2="12"></line>
                    <line x1="4" x2="20" y1="18" y2="18"></line>
                `
      }
    }
  })

  return mobileMenu
}

// Font Performance Monitoring
function monitorFontPerformance() {
  if ('performance' in window && 'getEntriesByType' in performance) {
    window.addEventListener('load', function () {
      setTimeout(function () {
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
    searchInput.addEventListener('focus', function () {
      searchResults.classList.remove('hidden')
    })

    // Hide search results when clicking outside
    document.addEventListener('click', function (e) {
      if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
        searchResults.classList.add('hidden')
      }
    })

    // Search input handler with debounce
    searchInput.addEventListener('input', function () {
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
    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        searchResults.classList.add('hidden')
        this.blur()
      }
      if (e.key === 'Enter') {
        e.preventDefault()
        createSearchModal()
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

  // Mobile search toggle
  if (mobileSearchToggle) {
    mobileSearchToggle.addEventListener('click', function () {
      createSearchModal()
    })
  }

  // Desktop search box click to show popup
  if (searchInput) {
    searchInput.addEventListener('click', function () {
      createSearchModal()
    })
  }

  function createSearchModal() {
    // Create search modal overlay
    const modal = document.createElement('div')
    modal.className = 'fixed inset-0 z-50 flex items-start justify-center pt-20'
    modal.style.backgroundColor = 'rgba(255, 255, 255, 0.05)'
    modal.innerHTML = `
            <div class="bg-white w-full max-w-2xl mx-4 rounded-lg shadow-xl">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="relative flex-1">
                            <input
                                type="search"
                                id="modal-search"
                                placeholder="Tìm kiếm sản phẩm, bài viết..."
                                class="w-full pl-10 pr-4 py-2.5 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                autocomplete="off"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </div>
                        </div>
                        <button class="modal-search-close p-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <line x1="18" x2="6" y1="6" y2="18"></line>
                                <line x1="6" x2="18" y1="6" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div id="modal-search-results" class="max-h-96 overflow-y-auto">
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            <p class="text-lg font-medium mb-2">Tìm kiếm nhanh</p>
                            <p class="text-sm">Nhập từ khóa để tìm kiếm sản phẩm, bài viết...</p>
                        </div>
                    </div>
                </div>
            </div>
        `

    document.body.appendChild(modal)

    // Initialize modal search functionality
    const modalSearchInput = modal.querySelector('#modal-search')
    const modalSearchResults = modal.querySelector('#modal-search-results')
    const closeButton = modal.querySelector('.modal-search-close')
    let modalSearchTimeout

    // Focus on input
    modalSearchInput.focus()

    // Search functionality
    modalSearchInput.addEventListener('input', function () {
      const query = this.value.trim()

      clearTimeout(modalSearchTimeout)

      if (query.length < 2) {
        showModalSearchPlaceholder()
        return
      }

      showModalSearchLoading()

      modalSearchTimeout = setTimeout(() => {
        performModalSearch(query)
      }, 300)
    })

    function showModalSearchPlaceholder() {
      modalSearchResults.innerHTML = `
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <p class="text-lg font-medium mb-2">Tìm kiếm nhanh</p>
                    <p class="text-sm">Nhập từ khóa để tìm kiếm sản phẩm, bài viết...</p>
                </div>
            `
    }

    function showModalSearchLoading() {
      modalSearchResults.innerHTML = `
                <div class="p-8 text-center text-gray-500">
                    <div class="animate-spin w-8 h-8 mx-auto mb-4 border-2 border-gray-300 border-t-primary rounded-full"></div>
                    <p class="text-lg font-medium">Đang tìm kiếm...</p>
                </div>
            `
    }

    function performModalSearch(query) {
      fetch(`${window.location.origin}/wp-json/wp/v2/search?search=${encodeURIComponent(query)}&per_page=8`)
        .then(response => response.json())
        .then(data => {
          displayModalSearchResults(data, query)
        })
        .catch(error => {
          // Handle search error silently
          showModalSearchError()
        })
    }

    function displayModalSearchResults(results, query) {
      if (results.length === 0) {
        modalSearchResults.innerHTML = `
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        <p class="text-lg font-medium mb-2">Không tìm thấy kết quả</p>
                        <p class="text-sm">Không có kết quả nào cho "${query}"</p>
                    </div>
                `
      } else {
        let resultsHTML = '<div class="space-y-2">'

        results.forEach(result => {
          resultsHTML += `
                        <a href="${result.url}" class="block p-4 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                            <div class="flex items-start space-x-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">${result.title}</h3>
                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">${result.excerpt || 'Không có mô tả'}</p>
                                    <span class="inline-block px-2 py-1 text-xs bg-primary text-white rounded">${getPostTypeLabel(result.subtype)}</span>
                                </div>
                            </div>
                        </a>
                    `
        })

        resultsHTML += `
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <a href="/?s=${encodeURIComponent(query)}" class="block text-center py-3 text-primary hover:text-primary-dark font-medium">
                            Xem tất cả kết quả cho "${query}"
                        </a>
                    </div>
                </div>`

        modalSearchResults.innerHTML = resultsHTML
      }
    }

    function showModalSearchError() {
      modalSearchResults.innerHTML = `
                <div class="p-8 text-center text-red-500">
                    <p class="text-lg font-medium">Có lỗi xảy ra</p>
                    <p class="text-sm">Vui lòng thử lại sau</p>
                </div>
            `
    }

    // Close modal handlers
    closeButton.addEventListener('click', () => {
      document.body.removeChild(modal)
    })

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        document.body.removeChild(modal)
      }
    })

    // Escape key to close
    document.addEventListener('keydown', function escapeHandler(e) {
      if (e.key === 'Escape') {
        document.body.removeChild(modal)
        document.removeEventListener('keydown', escapeHandler)
      }
    })
  }
}

// Cart functionality
function initCart() {
  const cartToggle = document.querySelector('.cart-toggle')

  if (cartToggle) {
    // Show cart popup on click
    cartToggle.addEventListener('click', function (e) {
      e.preventDefault()
      e.stopPropagation()

      // Create or show cart popup
      let cartPopup = document.getElementById('cart-popup')

      if (!cartPopup) {
        cartPopup = createCartPopup()
        document.body.appendChild(cartPopup)
      }

      // Show popup
      cartPopup.classList.remove('hidden')
      cartPopup.style.display = 'block'

      // Load cart contents
      loadCartContents()
    })
  }

  function createCartPopup() {
    const popup = document.createElement('div')
    popup.id = 'cart-popup'
    popup.className = 'fixed inset-0 z-50 lg:hidden'
    popup.style.backgroundColor = 'rgba(0, 0, 0, 0.3)'

    popup.innerHTML = `
            <!-- Mobile Cart Popup -->
            <div class="fixed inset-y-0 right-0 w-full max-w-sm bg-white shadow-xl transform transition-transform duration-300 ease-in-out">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Giỏ hàng</h2>
                    <button class="cart-close p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Cart Content -->
                <div id="cart-content" class="flex-1 overflow-y-auto">
                    <div class="p-4 text-center text-gray-500">
                        <div class="animate-spin w-6 h-6 mx-auto mb-2 border-2 border-gray-300 border-t-primary rounded-full"></div>
                        <p class="text-sm">Đang tải giỏ hàng...</p>
                    </div>
                </div>
            </div>

            <!-- Desktop Cart Popup -->
            <div class="hidden lg:block fixed inset-y-0 right-0 w-96 bg-white shadow-xl transform transition-transform duration-300 ease-in-out">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Giỏ hàng</h2>
                    <button class="cart-close p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Cart Content -->
                <div id="cart-content-desktop" class="flex-1 overflow-y-auto">
                    <div class="p-6 text-center text-gray-500">
                        <div class="animate-spin w-6 h-6 mx-auto mb-2 border-2 border-gray-300 border-t-primary rounded-full"></div>
                        <p class="text-sm">Đang tải giỏ hàng...</p>
                    </div>
                </div>
            </div>
        `

    // Add close event listeners
    const closeButtons = popup.querySelectorAll('.cart-close')
    closeButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault()
        e.stopPropagation()
        popup.classList.add('hidden')
        popup.style.display = 'none'
      })
    })

    // Close when clicking backdrop
    popup.addEventListener('click', (e) => {
      if (e.target === popup) {
        popup.classList.add('hidden')
        popup.style.display = 'none'
      }
    })

    // Close with Escape key
    document.addEventListener('keydown', function escapeHandler(e) {
      if (e.key === 'Escape' && !popup.classList.contains('hidden')) {
        popup.classList.add('hidden')
        popup.style.display = 'none'
      }
    })

    return popup
  }

  function loadCartContents() {
    const cartContent = document.getElementById('cart-content')
    const cartContentDesktop = document.getElementById('cart-content-desktop')

    // Show loading state
    const loadingHTML = `
            <div class="p-6 text-center text-gray-500">
                <div class="animate-spin w-6 h-6 mx-auto mb-2 border-2 border-gray-300 border-t-primary rounded-full"></div>
                <p class="text-sm">Đang tải giỏ hàng...</p>
            </div>
        `

    if (cartContent) cartContent.innerHTML = loadingHTML
    if (cartContentDesktop) cartContentDesktop.innerHTML = loadingHTML

    // For now, show empty cart (can be enhanced with WooCommerce AJAX later)
    setTimeout(() => {
      displayCartContents(null) // Show empty cart state
    }, 500)
  }

  function displayCartContents(cartData) {
    const cartContent = document.getElementById('cart-content')
    const cartContentDesktop = document.getElementById('cart-content-desktop')

    if (!cartData || cartData.count === 0) {
      const emptyHTML = `
                <div class="p-6 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <circle cx="8" cy="21" r="1"></circle>
                        <circle cx="19" cy="21" r="1"></circle>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>
                    </svg>
                    <p class="text-lg font-medium text-gray-900 mb-2">Giỏ hàng trống</p>
                    <p class="text-sm text-gray-500 mb-4">Thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                    <a href="/san-pham" class="inline-block bg-primary text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                        Khám phá sản phẩm
                    </a>
                </div>
            `
      if (cartContent) cartContent.innerHTML = emptyHTML
      if (cartContentDesktop) cartContentDesktop.innerHTML = emptyHTML
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
                <div class="p-6 border-t border-gray-100 bg-gray-50 sticky bottom-0">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-medium text-gray-900">Tổng cộng:</span>
                        <span class="text-xl font-bold text-primary">${cartData.total || '0₫'}</span>
                    </div>
                    <div class="space-y-3">
                        <a href="/gio-hang" class="block w-full bg-gray-100 text-gray-900 text-center py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            Xem giỏ hàng
                        </a>
                        <a href="/thanh-toan" class="block w-full bg-primary text-white text-center py-3 px-4 rounded-lg font-medium hover:bg-primary-dark transition-colors">
                            Thanh toán ngay
                        </a>
                    </div>
                </div>
            `

      if (cartContent) cartContent.innerHTML = cartHTML
      if (cartContentDesktop) cartContentDesktop.innerHTML = cartHTML

      // Add remove item event listeners
      const containers = [cartContent, cartContentDesktop].filter(Boolean)
      containers.forEach(container => {
        container.querySelectorAll('.remove-item').forEach(button => {
          button.addEventListener('click', function () {
            removeCartItem(this.dataset.key)
          })
        })
      })
    }

    // Re-initialize icons
    if (window.ArataIcons) {
      window.ArataIcons.init()
    }
  }

  function showCartError() {
    const cartContent = document.getElementById('cart-content')
    const cartContentDesktop = document.getElementById('cart-content-desktop')

    const errorHTML = `
            <div class="p-6 text-center text-red-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900 mb-2">Có lỗi xảy ra</p>
                <p class="text-sm text-gray-500 mb-4">Không thể tải giỏ hàng. Vui lòng thử lại.</p>
                <button onclick="location.reload()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-dark transition-colors">
                    Thử lại
                </button>
            </div>
        `

    if (cartContent) cartContent.innerHTML = errorHTML
    if (cartContentDesktop) cartContentDesktop.innerHTML = errorHTML
  }

  function showBasicCart() {
    const cartContent = document.getElementById('cart-content')
    const cartContentDesktop = document.getElementById('cart-content-desktop')

    const basicHTML = `
            <div class="p-6 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <circle cx="8" cy="21" r="1"></circle>
                    <circle cx="19" cy="21" r="1"></circle>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900 mb-4">Giỏ hàng</p>
                <a href="/gio-hang" class="block w-full bg-primary text-white text-center py-3 px-4 rounded-lg font-medium hover:bg-primary-dark transition-colors">
                    Xem giỏ hàng
                </a>
            </div>
        `

    if (cartContent) cartContent.innerHTML = basicHTML
    if (cartContentDesktop) cartContentDesktop.innerHTML = basicHTML
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
          // Handle remove item error silently
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

/**
 * Floating Social Media Widget
 */
function initFloatingSocial() {
  const widget = document.getElementById('floating-social-widget');
  const toggle = document.getElementById('floating-social-toggle');
  const links = document.getElementById('floating-social-links');

  if (!widget || !toggle || !links) return;

  // Load saved state
  const isOpen = localStorage.getItem('floating-social-open') === 'true';
  if (isOpen) {
    toggle.classList.add('active');
    links.classList.add('active');
  }

  // Toggle functionality
  toggle.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const isActive = toggle.classList.contains('active');

    if (isActive) {
      // Close
      toggle.classList.remove('active');
      links.classList.remove('active');
      localStorage.setItem('floating-social-open', 'false');
    } else {
      // Open
      toggle.classList.add('active');
      links.classList.add('active');
      localStorage.setItem('floating-social-open', 'true');
    }
  });

  // Close when clicking outside
  document.addEventListener('click', function (e) {
    if (!widget.contains(e.target)) {
      toggle.classList.remove('active');
      links.classList.remove('active');
      localStorage.setItem('floating-social-open', 'false');
    }
  });

  // Prevent closing when clicking inside widget
  widget.addEventListener('click', function (e) {
    e.stopPropagation();
  });

  // Add entrance animation with delay
  setTimeout(() => {
    widget.style.opacity = '1';
    widget.style.transform = 'translateY(0)';
  }, 1000);
}

/**
 * Dropdown Menu Functionality
 */
function initDropdownMenu() {
  const dropdownItems = document.querySelectorAll('.menu-item.has-dropdown, .menu-item-has-children');

  dropdownItems.forEach(function (item) {
    const dropdown = item.querySelector('.dropdown-menu');
    const link = item.querySelector('a');

    if (!dropdown) return;

    // Desktop behavior
    if (window.innerWidth >= 1024) {
      // Prevent default click on parent link if it has dropdown
      link.addEventListener('click', function (e) {
        e.preventDefault();

        // Close other dropdowns
        document.querySelectorAll('.dropdown-menu.show').forEach(function (otherDropdown) {
          if (otherDropdown !== dropdown) {
            otherDropdown.classList.remove('show');
          }
        });

        // Toggle current dropdown
        dropdown.classList.toggle('show');
      });
    } else {
      // Mobile behavior - create toggle button
      const mobileToggle = document.createElement('button');
      mobileToggle.className = 'mobile-dropdown-toggle';
      mobileToggle.innerHTML = link.textContent + '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';

      // Replace link with toggle button
      link.style.display = 'none';
      item.insertBefore(mobileToggle, dropdown);

      // Add mobile submenu class
      dropdown.className = 'mobile-submenu';

      // Mobile toggle functionality
      mobileToggle.addEventListener('click', function (e) {
        e.preventDefault();
        mobileToggle.classList.toggle('active');
        dropdown.classList.toggle('active');
      });
    }

    // Desktop hover events
    if (window.innerWidth >= 1024) {
      // Show dropdown on hover
      item.addEventListener('mouseenter', function () {
        // Close other dropdowns
        document.querySelectorAll('.dropdown-menu.show').forEach(function (otherDropdown) {
          if (otherDropdown !== dropdown) {
            otherDropdown.classList.remove('show');
          }
        });

        dropdown.classList.add('show');
        item.classList.add('show');
      });

      // Hide dropdown on mouse leave
      item.addEventListener('mouseleave', function () {
        setTimeout(function () {
          if (!item.matches(':hover') && !dropdown.matches(':hover')) {
            dropdown.classList.remove('show');
            item.classList.remove('show');
          }
        }, 150);
      });

      // Keep dropdown open when hovering over it
      dropdown.addEventListener('mouseenter', function () {
        dropdown.classList.add('show');
        item.classList.add('show');
      });

      dropdown.addEventListener('mouseleave', function () {
        setTimeout(function () {
          if (!item.matches(':hover') && !dropdown.matches(':hover')) {
            dropdown.classList.remove('show');
            item.classList.remove('show');
          }
        }, 150);
      });
    }
  });

  // Close dropdowns when clicking outside
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.menu-item.has-dropdown, .menu-item-has-children')) {
      document.querySelectorAll('.dropdown-menu.show').forEach(function (dropdown) {
        dropdown.classList.remove('show');
      });
    }
  });

  // Handle window resize
  window.addEventListener('resize', function () {
    if (window.innerWidth < 1024) {
      // On mobile, remove show class and let CSS handle it
      document.querySelectorAll('.dropdown-menu.show').forEach(function (dropdown) {
        dropdown.classList.remove('show');
      });
    }
  });

  // Debug: Log dropdown elements

  dropdownItems.forEach(function (item, index) {
    const dropdown = item.querySelector('.dropdown-menu');

  });
}

// Contact Popup Handler
function initContactPopup() {

  // Create popup HTML
  const popupHTML = `
    <div id="arata-contact-popup" class="arata-popup-overlay" style="display: none;">
      <div class="arata-popup-container arata-popup-md">
        <div class="arata-popup-header">
          <h3 class="arata-popup-title">${arataContactPopup.settings.title}</h3>
          <button class="arata-popup-close" aria-label="Close popup">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div class="arata-popup-body">
          <p class="arata-popup-description">${arataContactPopup.settings.description}</p>
          <form id="arata-popup-form" class="arata-popup-form">
            <input type="hidden" name="action" value="arata_popup_contact_submit" />
            <input type="hidden" name="nonce" value="${arataContactPopup.nonce}" />
            <input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" />

            <div class="arata-form-grid">
              <div class="arata-form-group">
                <label for="popup-name" class="arata-form-label">Họ tên *</label>
                <div class="arata-input-wrapper">
                  <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <input type="text" id="popup-name" name="name" class="arata-form-input" required />
                </div>
                <div id="popup-name-error" class="arata-error-message"></div>
              </div>

              <div class="arata-form-group">
                <label for="popup-email" class="arata-form-label">Email *</label>
                <div class="arata-input-wrapper">
                  <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  <input type="email" id="popup-email" name="email" class="arata-form-input" required />
                </div>
                <div id="popup-email-error" class="arata-error-message"></div>
              </div>
            </div>

            <div class="arata-form-grid">
              <div class="arata-form-group">
                <label for="popup-phone" class="arata-form-label">Số điện thoại</label>
                <div class="arata-input-wrapper">
                  <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                  <input type="tel" id="popup-phone" name="phone" class="arata-form-input" />
                </div>
                <div id="popup-phone-error" class="arata-error-message"></div>
              </div>

              <div class="arata-form-group">
                <label for="popup-subject" class="arata-form-label">Tiêu đề</label>
                <div class="arata-input-wrapper">
                  <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                  </svg>
                  <input type="text" id="popup-subject" name="subject" class="arata-form-input" />
                </div>
              </div>
            </div>

            <div class="arata-form-group">
              <label for="popup-message" class="arata-form-label">Nội dung *</label>
              <textarea id="popup-message" name="message" class="arata-form-textarea" rows="4" required></textarea>
              <div id="popup-message-error" class="arata-error-message"></div>
            </div>

            <div class="arata-form-actions">
              <button type="submit" class="arata-submit-btn">
                <span class="arata-submit-text">Gửi liên hệ</span>
                <svg class="arata-loading-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  `;

  // Add popup to body
  document.body.insertAdjacentHTML('beforeend', popupHTML);

  // Get elements
  const popup = document.getElementById('arata-contact-popup');
  const closeBtn = popup.querySelector('.arata-popup-close');
  const form = document.getElementById('arata-popup-form');

  // Open popup when clicking contact links
  document.addEventListener('click', function (e) {
    if (e.target.matches('a[href*="contact"], a[href*="lien-he"]')) {

      e.preventDefault();
      openPopup();
    }
  });

  // Close popup
  closeBtn.addEventListener('click', closePopup);
  popup.addEventListener('click', function (e) {
    if (e.target === popup) {
      closePopup();
    }
  });

  // Close on escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && popup.style.display !== 'none') {
      closePopup();
    }
  });

  // Form submission
  form.addEventListener('submit', handleFormSubmission);

  function openPopup() {
    popup.style.display = 'flex';
    document.body.classList.add('arata-popup-open');
    popup.querySelector('input:first').focus();
  }

  function closePopup() {
    popup.style.display = 'none';
    document.body.classList.remove('arata-popup-open');
    resetForm();
  }

  function resetForm() {
    form.reset();
    form.querySelectorAll('.arata-error-message').forEach(el => el.textContent = '');
    form.querySelectorAll('.arata-form-input, .arata-form-textarea').forEach(el => el.classList.remove('arata-input-error'));
    form.querySelector('.arata-submit-btn').disabled = false;
    form.querySelector('.arata-submit-text').textContent = 'Gửi liên hệ';
    form.querySelector('.arata-loading-spinner').style.display = 'none';
  }

  function handleFormSubmission(e) {
    e.preventDefault();

    const submitBtn = form.querySelector('.arata-submit-btn');
    const submitText = form.querySelector('.arata-submit-text');
    const loadingSpinner = form.querySelector('.arata-loading-spinner');

    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = 'Đang gửi...';
    loadingSpinner.style.display = 'inline-block';

    // Submit form
    const formData = new FormData(form);

    fetch(arataContactPopup.ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showSuccessMessage(data.data.message);
          resetForm();
          setTimeout(closePopup, 2000);
        } else {
          showErrorMessage(data.data.message);
        }
      })
      .catch(error => {
        // Handle form submission error silently
        showErrorMessage('Có lỗi xảy ra. Vui lòng thử lại.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitText.textContent = 'Gửi liên hệ';
        loadingSpinner.style.display = 'none';
      });
  }

  function showSuccessMessage(message) {
    const body = popup.querySelector('.arata-popup-body');
    body.innerHTML = `
      <div class="arata-success-message">
        <svg class="arata-success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>${message}</p>
      </div>
    `;
  }

  function showErrorMessage(message) {
    const body = popup.querySelector('.arata-popup-body');
    body.insertAdjacentHTML('afterbegin', `
      <div class="arata-error-alert">
        <svg class="arata-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>${message}</p>
      </div>
    `);
  }


}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
  detectFontLoading();
  optimizeVietnameseText();
  initNavigation();
  initDropdownMenu();
  initSearch();
  initCart();
  initFloatingSocial();
  monitorFontPerformance();

  // Initialize contact popup if enabled
  if (typeof arataContactPopup !== 'undefined' && arataContactPopup.settings.enabled) {

    initContactPopup();
  } else {

  }
});

// Initialize navigation when window loads (fallback)
window.addEventListener('load', function () {
  initNavigation();
  initDropdownMenu();
});
