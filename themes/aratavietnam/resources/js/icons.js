// Lucide Icons Integration for Arata Vietnam Theme

/**
 * Icon registry for the theme
 * Maps icon names to Lucide icon components
 */
const iconRegistry = {
  // Header icons
  'search': '<circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path>',
  'user': '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>',
  'cart': '<circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>',
  'menu': '<line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="18" y2="18"></line>',
  'close': '<line x1="18" x2="6" y1="6" y2="18"></line><line x1="6" x2="18" y1="6" y2="18"></line>',
  'chevron-down': '<path d="m6 9 6 6 6-6"></path>',

  // Contact icons
  'phone': '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>',
  'mail': '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>',
  'location': '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>',
  'message-circle': '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>',

  // Social media icons
  'facebook': '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>',
  'twitter': '<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>',
  'instagram': '<rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="m16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>',
  'youtube': '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75,15.02 15.5,11.75 9.75,8.48"></polygon>',
  'tiktok': '<path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>',
  'shopee': '<circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>',
  'globe': '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
  'share': '<circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>',
  'plus': '<path d="M5 12h14"></path><path d="M12 5v14"></path>',

  // UI icons
  'star': '<polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>',
  'heart': '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7z"></path>',
  'eye': '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>',
  'arrow-right': '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
  'arrow-left': '<path d="M19 12H5"></path><path d="m12 19-7-7 7-7"></path>',

  // Navigation icons
  'home': '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9,22 9,12 15,12 15,22"></polyline>',
  'package': '<path d="M16.5 9.4 7.55 4.24"></path><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.29,7 12,12 20.71,7"></polyline><line x1="12" x2="12" y1="22" y2="12"></line>',
  'info': '<circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path>',
  'news': '<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path>',
  'contact': '<path d="M3 21a9 9 0 0 1 9-9 9 9 0 0 1 9 9"></path><path d="M21 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>',

  // Additional icons for news section
  'megaphone': '<path d="M3 11h18l-2 8H5l-2-8Z"></path><path d="M7 15V7a5 5 0 0 1 10 0v8"></path>',
  'file-text': '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line><line x1="10" x2="8" y1="9" y2="9"></line>',
  'clock': '<circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline>',
  'building': '<rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 9h.01"></path><path d="M15 9h.01"></path><path d="M9 13h.01"></path><path d="M15 13h.01"></path><path d="M9 17h.01"></path><path d="M15 17h.01"></path>',
  'map-pin': '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle>',
  'calendar': '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path>',

  // Additional icons for archive templates
  'dollar-sign': '<line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>',
  'tag': '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 14V2h12l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line>',
  'chevron-left': '<path d="m15 18-6-6 6-6"></path>',
  'chevron-right': '<path d="m9 18 6-6-6-6"></path>',

  // Missing icons used by services pages
  'settings': '<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h0A1.65 1.65 0 0 0 10.91 3H11a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h0a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82h0A1.65 1.65 0 0 0 21 11h.09a2 2 0 1 1 0 4H21a1.65 1.65 0 0 0-1.6 0z"></path>',
  'trending-up': '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline>',
  'shipping': '<rect x="1" y="3" width="15" height="13" rx="2" ry="2"></rect><path d="M16 8h3l4 4v4h-3"></path><circle cx="5.5" cy="18.5" r="1.5"></circle><circle cx="18.5" cy="18.5" r="1.5"></circle>',
  'graduation-cap': '<path d="M22 10L12 5 2 10l10 5 10-5z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path><path d="M12 5v5"></path>',
  'headphones': '<path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"></path><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3"></path>',
  'scale': '<path d="M12 3v3"></path><path d="M6 7l-4 7h8l-4-7Z"></path><path d="M18 7l-4 7h8l-4-7Z"></path><path d="M12 10v11"></path><path d="M8 21h8"></path>',
  'list': '<line x1="8" x2="21" y1="6" y2="6"></line><line x1="8" x2="21" y1="12" y2="12"></line><line x1="8" x2="21" y1="18" y2="18"></line><line x1="3" x2="3.01" y1="6" y2="6"></line><line x1="3" x2="3.01" y1="12" y2="12"></line><line x1="3" x2="3.01" y1="18" y2="18"></line>',
  'folder': '<path d="M4 4h5l2 3h9a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>'
};

/**
 * Create and render an icon
 * @param {string} name - Icon name from registry
 * @param {Object} options - Icon options
 * @param {string} options.size - Icon size (default: 24)
 * @param {string} options.color - Icon color (default: currentColor)
 * @param {string} options.strokeWidth - Stroke width (default: 2)
 * @param {string} options.className - Additional CSS classes
 * @returns {HTMLElement} SVG icon element
 */
export function createIcon(name, options = {}) {
  const {
    size = 24,
    color = 'currentColor',
    strokeWidth = 2,
    className = ''
  } = options;

  const iconPath = iconRegistry[name];

  if (!iconPath) {
    return;
  }

  // Create SVG element
  const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  svg.setAttribute('width', size);
  svg.setAttribute('height', size);
  svg.setAttribute('viewBox', '0 0 24 24');
  svg.setAttribute('fill', 'none');
  svg.setAttribute('stroke', color);
  svg.setAttribute('stroke-width', strokeWidth);
  svg.setAttribute('stroke-linecap', 'round');
  svg.setAttribute('stroke-linejoin', 'round');

  if (className) {
    svg.setAttribute('class', className);
  }

  // Set the icon path
  svg.innerHTML = iconPath;

  return svg;
}

/**
 * Replace all icon placeholders in the DOM
 * Usage: <span data-icon="search" data-size="20" data-class="text-gray-600"></span>
 */
export function initializeIcons() {
  const iconPlaceholders = document.querySelectorAll('[data-icon]');

  iconPlaceholders.forEach(placeholder => {
    const iconName = placeholder.getAttribute('data-icon');
    const size = placeholder.getAttribute('data-size') || 24;
    const className = placeholder.getAttribute('data-class') || '';
    const strokeWidth = placeholder.getAttribute('data-stroke') || 2;

    const icon = createIcon(iconName, {
      size: parseInt(size),
      className,
      strokeWidth: parseInt(strokeWidth)
    });

    if (icon) {
      // Clear placeholder content and add icon
      placeholder.innerHTML = '';
      placeholder.appendChild(icon);
    }
  });
}

/**
 * Add icon to existing element
 * @param {HTMLElement} element - Target element
 * @param {string} iconName - Icon name
 * @param {Object} options - Icon options
 */
export function addIconToElement(element, iconName, options = {}) {
  const icon = createIcon(iconName, options);
  if (icon && element) {
    element.appendChild(icon);
  }
}

/**
 * Replace element content with icon
 * @param {HTMLElement} element - Target element
 * @param {string} iconName - Icon name
 * @param {Object} options - Icon options
 */
export function replaceElementWithIcon(element, iconName, options = {}) {
  const icon = createIcon(iconName, options);
  if (icon && element) {
    element.innerHTML = '';
    element.appendChild(icon);
  }
}

/**
 * Get available icon names
 * @returns {Array} Array of available icon names
 */
export function getAvailableIcons() {
  return Object.keys(iconRegistry);
}

// Auto-initialize icons when DOM is ready
document.addEventListener('DOMContentLoaded', initializeIcons);

// Export for global use
window.ArataIcons = {
  create: createIcon,
  init: initializeIcons,
  add: addIconToElement,
  replace: replaceElementWithIcon,
  available: getAvailableIcons
};
