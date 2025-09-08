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
        var preview = input.siblings('.image-preview');

        var uploader = wp.media({
            title: 'Select an Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
            
            // Remove any existing preview
            input.next('.image-preview').remove();
            
            // Show image preview
            input.after('<div class="image-preview"><img src="' + attachment.url + '" /></div>');
        }).open();
    });

    // Show existing image previews on page load
    setTimeout(function() {
        $('.upload_image_button').each(function() {
            var button = $(this);
            var input = button.prev('input');
            var imageValue = input.val();
            
            // Check if preview already exists
            if (input.next('.image-preview').length > 0) {
                return; // Skip if preview already exists
            }
            
            if (imageValue) {
                // Check if the value is a URL
                if (imageValue.match(/^https?:\/\//)) {
                    // It's a URL, show preview
                    input.after('<div class="image-preview"><img src="' + imageValue + '" onerror="this.style.display=\'none\'" /></div>');
                }
            }
        });
    }, 1000);
});

// Add some styling for the image preview
$('<style>')
    .text('.image-preview img { max-width: 300px !important; height: auto !important; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px; display: block; }')
    .appendTo('head');