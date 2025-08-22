<?php

namespace ArataVietnam\Walkers;

class CommentWalker extends \Walker_Comment
{
    protected function html5_comment($comment, $depth, $args)
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body flex space-x-4">
                <div class="flex-shrink-0">
                    <?php if (0 !== $args['avatar_size']) {
                        echo get_avatar($comment, $args['avatar_size'], '', '', ['class' => 'rounded-full']);
                    } ?>
                </div>

                <div class="flex-1">
                    <div class="comment-meta flex items-center space-x-3 text-sm">
                        <span class="font-bold text-gray-900"><?php echo get_comment_author_link($comment); ?></span>
                        <span class="text-gray-500">
                            <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php
                                    /* translators: 1: date, 2: time */
                                    printf(esc_html__('%1$s lúc %2$s', 'aratavietnam'), get_comment_date('', $comment), get_comment_time());
                                    ?>
                                </time>
                            </a>
                        </span>
                        <?php edit_comment_link(esc_html__('Chỉnh sửa', 'aratavietnam'), '<span class="edit-link text-gray-500 hover:text-primary">', '</span>'); ?>
                    </div>

                    <?php if ('0' === $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation text-sm text-yellow-600 bg-yellow-50 p-2 rounded-md mt-2">
                            <?php esc_html_e('Bình luận của bạn đang chờ kiểm duyệt.', 'aratavietnam'); ?>
                        </p>
                    <?php endif; ?>

                    <div class="prose prose-sm max-w-none mt-2 text-gray-700">
                        <?php comment_text(); ?>
                    </div>

                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            [
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply mt-2">',
                                'after'     => '</div>',
                                'reply_text' => '<span class="flex items-center text-sm font-medium text-primary hover:text-primary-dark"><span data-icon="corner-down-left" data-size="16" class="mr-1"></span>' . esc_html__('Trả lời', 'aratavietnam') . '</span>',
                            ]
                        )
                    );
                    ?>
                </div>
            </article>
        <?php
    }
}
