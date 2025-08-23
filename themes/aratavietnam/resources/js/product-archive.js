/**
 * Product Archive Page JavaScript
 * Handles category toggles, filters, and product grid interactions
 */

document.addEventListener('DOMContentLoaded', function () {
  // Product sorting functionality
  const sortDropdown = document.getElementById('product-sort');

  if (sortDropdown) {
    sortDropdown.addEventListener('change', function () {
      const selectedSort = this.value;
      const currentUrl = new URL(window.location.href);

      // Update or remove orderby parameter
      if (selectedSort && selectedSort !== 'menu_order') {
        currentUrl.searchParams.set('orderby', selectedSort);
      } else {
        currentUrl.searchParams.delete('orderby');
      }

      // Reset to page 1 when sorting
      currentUrl.searchParams.delete('paged');

      // Redirect to new URL
      window.location.href = currentUrl.toString();
    });
  }

  // Category toggle functionality
  const categoryToggles = document.querySelectorAll('.category-toggle');

  categoryToggles.forEach(toggle => {
    toggle.addEventListener('click', function () {
      const categoryId = this.getAttribute('data-category');
      const subcategories = document.getElementById(`subcategories-${categoryId}`);
      const icon = this.querySelector('.category-icon');
      
      if (subcategories && icon) {
        if (subcategories.classList.contains('hidden')) {
          subcategories.classList.remove('hidden');
          icon.style.transform = 'rotate(180deg)';
        } else {
          subcategories.classList.add('hidden');
          icon.style.transform = 'rotate(0deg)';
        }
      }
    });
  });

  // Filter functionality
  const priceFilters = document.querySelectorAll('input[name="price_filter"]');
  const brandFilters = document.querySelectorAll('input[name="brand_filter[]"]');
  const clearFiltersBtn = document.getElementById('clear-filters');

  // Load saved filter state from localStorage
  function loadFilterState() {
    const savedPrice = localStorage.getItem('product_price_filter');
    const savedBrands = localStorage.getItem('product_brand_filters');

    if (savedPrice) {
      const priceFilter = document.querySelector(`input[name="price_filter"][value="${savedPrice}"]`);
      if (priceFilter) {
        priceFilter.checked = true;
      }
    }

    if (savedBrands) {
      try {
        const brands = JSON.parse(savedBrands);
        brands.forEach(brand => {
          const checkbox = document.querySelector(`input[name="brand_filter[]"][value="${brand}"]`);
          if (checkbox) checkbox.checked = true;
        });
      } catch (e) {
        console.warn('Error parsing saved brand filters:', e);
      }
    }
  }

  // Save filter state to localStorage
  function saveFilterState() {
    const selectedPriceFilter = document.querySelector('input[name="price_filter"]:checked');
    const selectedPrice = selectedPriceFilter ? selectedPriceFilter.value : 'all';

    const selectedBrands = Array.from(brandFilters)
      .filter(filter => filter.checked)
      .map(filter => filter.value);

    localStorage.setItem('product_price_filter', selectedPrice);
    localStorage.setItem('product_brand_filters', JSON.stringify(selectedBrands));
  }

  // Apply filters by redirecting with query parameters
  function applyFilters() {
    const selectedPriceFilter = document.querySelector('input[name="price_filter"]:checked');
    const selectedPrice = selectedPriceFilter ? selectedPriceFilter.value : 'all';

    const selectedBrands = Array.from(brandFilters)
      .filter(filter => filter.checked)
      .map(filter => filter.value);

    // Build query string
    const params = new URLSearchParams(window.location.search);

    if (selectedPrice !== 'all') {
      params.set('price_filter', selectedPrice);
    } else {
      params.delete('price_filter');
    }

    if (selectedBrands.length > 0) {
      params.set('brand_filter', selectedBrands.join(','));
    } else {
      params.delete('brand_filter');
    }

    // Redirect with filters
    const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');

    // Add loading state to clear filters button
    if (clearFiltersBtn) {
      clearFiltersBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Đang tải...';
    }

    window.location.href = newUrl;
  }

  // Load filters on page load
  loadFilterState();

  // Price filter change events
  priceFilters.forEach(filter => {
    filter.addEventListener('change', function () {
      saveFilterState();
      applyFilters();
    });
  });

  // Brand filter change events
  brandFilters.forEach(filter => {
    filter.addEventListener('change', function () {
      saveFilterState();
      applyFilters();
    });
  });

  // Clear filters functionality
  if (clearFiltersBtn) {
    clearFiltersBtn.addEventListener('click', function () {
      // Reset all filters
      priceFilters.forEach(filter => filter.checked = false);
      if (priceFilters[0]) {
        priceFilters[0].checked = true; // Reset to "all"
      }
      brandFilters.forEach(filter => filter.checked = false);

      // Clear localStorage
      localStorage.removeItem('product_price_filter');
      localStorage.removeItem('product_brand_filters');

      applyFilters();
    });
  }

  // Product hover effects
  const productCards = document.querySelectorAll('.group');
  productCards.forEach(card => {
    const quickViewBtn = card.querySelector('.quick-view-btn');
    if (quickViewBtn) {
      quickViewBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const productUrl = this.getAttribute('href');
        if (productUrl) {
          window.location.href = productUrl;
        }
      });
    }
  });

  // Lazy loading for product images
  const productImages = document.querySelectorAll('.product-image img');
  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          if (img.dataset.src) {
            img.src = img.dataset.src;
            img.classList.remove('opacity-0');
            img.classList.add('opacity-100');
            observer.unobserve(img);
          }
        }
      });
    });

    productImages.forEach(img => {
      if (img.dataset.src) {
        imageObserver.observe(img);
      }
    });
  }
});



  // Mobile filter panel functionality
  const trigger = document.getElementById('mobile-filter-trigger');
  const panel = document.getElementById('mobile-filter-panel');
  const content = document.getElementById('mobile-filter-content');
  const closeBtn = document.getElementById('mobile-filter-close');
  const desktopSidebar = document.querySelector('aside.hidden.lg\\:block');

  if (trigger && panel && content && closeBtn && desktopSidebar) {
    // Clone sidebar content to mobile panel
    const cloneContainer = content.querySelector('.p-4.space-y-6');
    if (cloneContainer) {
        const filtersToClone = desktopSidebar.querySelectorAll('.bg-white.rounded-lg.border');
        filtersToClone.forEach(filter => {
            cloneContainer.appendChild(filter.cloneNode(true));
        });
    }

    // Re-initialize category toggles for the cloned filters
    const mobileCategoryToggles = cloneContainer.querySelectorAll('.category-toggle');
    mobileCategoryToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const categoryId = this.getAttribute('data-category');
            const subcategories = cloneContainer.querySelector(`#subcategories-${categoryId}`);
            const icon = this.querySelector('.category-icon');

            if (subcategories && icon) {
                if (subcategories.classList.contains('hidden')) {
                    subcategories.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    subcategories.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            }
        });
    });

    function openPanel() {
        panel.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            content.classList.remove('translate-x-full');
        }, 10);
    }

    function closePanel() {
        content.classList.add('translate-x-full');
        document.body.style.overflow = '';
        setTimeout(() => {
            panel.classList.add('hidden');
        }, 300);
    }

    trigger.addEventListener('click', openPanel);
    closeBtn.addEventListener('click', closePanel);
    panel.addEventListener('click', function (e) {
        if (e.target === panel) {
            closePanel();
        }
    });
  }
