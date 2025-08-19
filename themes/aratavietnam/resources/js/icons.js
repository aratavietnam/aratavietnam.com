// Lucide Icons Integration for Arata Vietnam Theme

/**
 * Icon registry for the theme
 * Maps icon names to Lucide icon components
 */
const iconRegistry = {
    // Header icons
    'search': Search,
    'user': User,
    'cart': ShoppingCart,
    'menu': Menu,
    'close': X,
    'chevron-down': ChevronDown,

    // Contact icons
    'phone': Phone,
    'mail': Mail,
    'location': MapPin,

    // Social media icons
    'facebook': Facebook,
    'twitter': Twitter,
    'instagram': Instagram,
    'youtube': Youtube,

    // UI icons
    'star': Star,
    'heart': Heart,
    'eye': Eye,
    'arrow-right': ArrowRight,
    'arrow-left': ArrowLeft,

    // Navigation icons
    'home': Home,
    'package': Package,
    'info': Info,
    'news': Newspaper,
    'contact': MessageCircle
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

    const IconComponent = iconRegistry[name];

    if (!IconComponent) {
        console.warn(`Icon "${name}" not found in registry`);
        return null;
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

    // Get icon path data
    const iconData = IconComponent.toSvg({
        size,
        color,
        strokeWidth
    });

    // Extract path elements from icon data
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = iconData;
    const paths = tempDiv.querySelectorAll('path, circle, rect, line, polyline, polygon');

    // Append paths to our SVG
    paths.forEach(path => {
        svg.appendChild(path.cloneNode(true));
    });

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
            // Replace placeholder with icon
            placeholder.parentNode.replaceChild(icon, placeholder);
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
