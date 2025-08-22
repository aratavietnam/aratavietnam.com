<?php
/**
 * Comments template.
 *
 * @package ArataVietnam
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-12 pt-12 border-t border-gray-200">
    <?php if (have_comments()): ?>
        <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-8">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                esc_html_e('Một bình luận', 'aratavietnam');
            } else {
                printf(
                    /* translators: 1: comment count number. */
                    esc_html(_nx('%1$s bình luận', '%1$s bình luận', $comment_count, 'comments title', 'aratavietnam')),
                    esc_html(number_format_i18n($comment_count))
                );
            }
            ?>
        </h2>

        <ol class="comment-list space-y-8">
            <?php
            wp_list_comments([
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 64,
                'walker'      => new \ArataVietnam\Walkers\CommentWalker(),
            ]);
            ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
            <nav class="comment-navigation mt-8 pt-8 border-t border-gray-200 flex justify-between text-sm font-medium" id="comment-nav-below">
                <div class="nav-previous"><?php previous_comments_link(esc_html__('« Bình luận cũ hơn', 'aratavietnam')); ?></div>
                <div class="nav-next"><?php next_comments_link(esc_html__('Bình luận mới hơn »', 'aratavietnam')); ?></div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
        <p class="no-comments text-gray-600 mt-8"><?php esc_html_e('Khu vực bình luận đã đóng.', 'aratavietnam'); ?></p>
    <?php endif; ?>

    <?php
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true'" : '');

        $fields = [
            'author' => '<p class="comment-form-author"><label for="author" class="sr-only">' . esc_html__('Tên', 'aratavietnam') . '</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__('Tên của bạn *', 'aratavietnam') . '" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"></p>',
            'email'  => '<p class="comment-form-email"><label for="email" class="sr-only">' . esc_html__('Email', 'aratavietnam') . '</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__('Email của bạn *', 'aratavietnam') . '" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"></p>',
            'url'    => '<p class="comment-form-url"><label for="url" class="sr-only">' . esc_html__('Website', 'aratavietnam') . '</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" placeholder="' . esc_html__('Website (tùy chọn)', 'aratavietnam') . '" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"></p>',
        ];

        $comment_field = '<p class="comment-form-comment"><label for="comment" class="sr-only">' . esc_html__('Bình luận', 'aratavietnam') . '</label><textarea id="comment" name="comment" cols="45" rows="6" aria-required="true" placeholder="' . esc_html__('Viết bình luận của bạn... *', 'aratavietnam') . '" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"></textarea></p>';

        comment_form([
            'fields'               => $fields,
            'comment_field'        => $comment_field,
            'title_reply'          => '',
            'title_reply_before'   => '',
            'title_reply_after'    => '',

            'cancel_reply_link'    => esc_html__('Hủy trả lời', 'aratavietnam'),
            'label_submit'         => esc_html__('Gửi bình luận', 'aratavietnam'),
            'class_submit'         => 'inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-300 font-medium',
            'comment_notes_before' => '<p class="comment-notes text-sm text-gray-600 mb-4">' . esc_html__('Địa chỉ email của bạn sẽ không được công khai. Các trường bắt buộc được đánh dấu *', 'aratavietnam') . '</p>',
            'logged_in_as'         => '<p class="logged-in-as text-sm text-gray-600 mb-4">' . sprintf(
                /* translators: 1: user account link, 2: logout link. */
                wp_kses(
                    __('Đã đăng nhập với tên <a href="%1$s">%2$s</a>. <a href="%3$s">Đăng xuất?</a>', 'aratavietnam'),
                    [
                        'a' => [
                            'href' => [],
                        ],
                    ]
                ),
                esc_url(admin_url('profile.php')),
                esc_html($user_identity),
                esc_url(wp_logout_url(apply_filters('the_permalink', get_permalink())))
            ) . '</p>',
        ]);
    ?>
</div>
