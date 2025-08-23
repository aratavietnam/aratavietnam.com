jQuery(document).ready(function($) {
    // Tabs functionality
    $('.homepage-meta-tabs .tab-links a').on('click', function(e) {
        e.preventDefault();
        var currentAttrValue = $(this).attr('href');

        // Show/Hide Tabs
        $('.homepage-meta-tabs ' + currentAttrValue).show().siblings().hide();

        // Change/remove current tab to active
        $(this).parent('li').addClass('active').siblings().removeClass('active');
    });

    // Media Uploader
    $(document).on('click', '.upload_image_button', function(e) {
        e.preventDefault();
        var button = $(this);
        var input = button.prev('input');

        var uploader = wp.media({
            title: 'Select an Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON();
            input.val(attachment.id);
        }).open();
    });
});
