<?php
/**
 * Single Product Tabs
 *
 * @package ArataVietnam
 */

global $product;

$tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($tabs)) : ?>
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-100">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <?php foreach ($tabs as $key => $tab) : ?>
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm tab-btn <?php echo $key === 'description' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>"
                            data-tab="<?php echo esc_attr($key); ?>">
                        <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
                    </button>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6 lg:p-8">
            <?php foreach ($tabs as $key => $tab) : ?>
                <div id="<?php echo esc_attr($key); ?>-tab" class="tab-content <?php echo $key !== 'description' ? 'hidden' : ''; ?>">
                    <div class="prose max-w-none">
                        <?php
                        if (isset($tab['callback'])) {
                            call_user_func($tab['callback'], $key, $tab);
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
