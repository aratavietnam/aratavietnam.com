<?php
/**
 * Template part for displaying social sharing buttons
 *
 * @package ArataVietnam
 */

$share_title = is_singular('product') ? 'Chia sẻ sản phẩm:' : 'Chia sẻ bài viết:';
$post_url = urlencode(get_permalink());
$post_title = urlencode(get_the_title());
$post_thumbnail = urlencode(get_the_post_thumbnail_url());
$button_id = 'copy-link-' . get_the_ID(); // Unique ID for the copy button
?>

<div class="pt-6 mt-6">
    <span class="font-semibold text-gray-800 mb-3 block"><?php echo esc_html($share_title); ?></span>
    <div class="flex items-center gap-3">
        <!-- Facebook -->
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300" aria-label="Share on Facebook">
            <span data-icon="facebook" data-size="20"></span>
        </a>

        <!-- Pinterest -->
        <a href="https://pinterest.com/pin/create/button/?url=<?php echo $post_url; ?>&media=<?php echo $post_thumbnail; ?>&description=<?php echo $post_title; ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300" aria-label="Pin on Pinterest">
            <span data-icon="pinterest" data-size="20"></span>
        </a>

        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-blue-700 hover:text-white transition-all duration-300" aria-label="Share on LinkedIn">
            <span data-icon="linkedin" data-size="20"></span>
        </a>

        <!-- Copy Link -->
        <button id="<?php echo esc_attr($button_id); ?>" class="copy-link-button w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-gray-800 hover:text-white transition-all duration-300" data-link="<?php echo esc_url(get_permalink()); ?>" aria-label="Copy link">
            <span data-icon="link-2" data-size="20"></span>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.ArataIcons === 'undefined') {
        window.ArataIcons = {};
    }

    window.ArataIcons.renderMissing = function() {
        const missingIcons = {
            'pinterest': '<path d="M12.5 12c0-2.5-1.5-5-5-5-3.5 0-5 2.5-5 5 0 2.5 1.5 5 5 5 1.5 0 2.5-1 2.5-2.5 0-1.5-1-2.5-2.5-2.5-1.5 0-2.5 1-2.5 2.5 0 1.5 1 2.5 2.5 2.5 3.5 0 5-2.5 5-5z"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"/>',
            'link-2': '<path d="M9 17H7A5 5 0 0 1 7 7h2" /><path d="M15 7h2a5 5 0 1 1 0 10h-2" /><line x1="8" y1="12" x2="16" y2="12" />',
            'check': '<path d="M20 6 9 17l-5-5" />'
        };

        function createManualIcon(name, size = 24, className = '', strokeWidth = 2) {
            const iconPath = missingIcons[name];
            if (!iconPath) return null;

            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('width', size);
            svg.setAttribute('height', size);
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('stroke-width', strokeWidth);
            svg.setAttribute('stroke-linecap', 'round');
            svg.setAttribute('stroke-linejoin', 'round');
            if (className) svg.setAttribute('class', className);
            svg.innerHTML = iconPath;
            return svg;
        }

        document.querySelectorAll('[data-icon="pinterest"], [data-icon="link-2"]').forEach(placeholder => {
            if (placeholder.children.length === 0) { // Only render if empty
                const iconName = placeholder.getAttribute('data-icon');
                const size = placeholder.getAttribute('data-size') || 20;
                const icon = createManualIcon(iconName, size);
                if (icon) {
                    placeholder.appendChild(icon);
                }
            }
        });

        const copyButton = document.getElementById('<?php echo esc_js($button_id); ?>');
        if (copyButton && !copyButton.dataset.listenerAttached) {
            copyButton.dataset.listenerAttached = 'true';
            copyButton.addEventListener('click', function() {
                const link = this.dataset.link;
                navigator.clipboard.writeText(link).then(() => {
                    const originalIcon = this.innerHTML;
                    const checkIcon = createManualIcon('check', 20);
                    if (checkIcon) {
                        this.innerHTML = '';
                        this.appendChild(checkIcon);
                    }
                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                    }, 2000);
                });
            });
        }
    };

    // Ensure main icon script is loaded before running this
    const ensureIconsAreRendered = () => {
        if (window.ArataIcons && typeof window.ArataIcons.init === 'function') {
            window.ArataIcons.init(); // Run main script first
            window.ArataIcons.renderMissing(); // Then run our fix
        } else {
            setTimeout(ensureIconsAreRendered, 100);
        }
    };

    ensureIconsAreRendered();
});
</script>
