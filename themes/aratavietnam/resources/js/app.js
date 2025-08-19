// Import Lucide Icons
import './icons.js';

// Font Loading Detection for Google Fonts
function detectFontLoading() {
    // Check if Font Loading API is supported
    if ('fonts' in document) {
        // Check for Inter font (our primary font)
        document.fonts.load('16px "Inter"').then(function() {
            console.log('Inter font loaded successfully');
            document.documentElement.classList.add('font-loaded');
        }).catch(function() {
            console.log('Using system fonts as fallback');
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

                if (fontResources.length > 0) {
                    console.log('Google Fonts loaded successfully');
                    fontResources.forEach(font => {
                        console.log(`Font: ${font.name.split('/').pop()}, Load time: ${font.duration.toFixed(2)}ms`);
                    });
                }
            }, 1000);
        });
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    detectFontLoading();
    optimizeVietnameseText();
    initNavigation();
    monitorFontPerformance();
});

// Initialize navigation when window loads (fallback)
window.addEventListener('load', function () {
    initNavigation();
});
