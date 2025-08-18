<?php

namespace ArataVietnam\Theme;

class Pagination
{
    public const TEXT_PREV = 'Previous';
    public const TEXT_NEXT = 'Next';

    public static function render($query = null)
    {
        if (!$query) {
            global $wp_query;
            $query = $wp_query;
        }

        if ($query->max_num_pages <= 1) {
            return;
        }

        $big = 999999999;
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        $paginate_links = paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $query->max_num_pages,
            'prev_text' => self::TEXT_PREV,
            'next_text' => self::TEXT_NEXT,
            'type' => 'array',
            'end_size' => 3,
            'mid_size' => 3,
        ]);

        if ($paginate_links) {
            echo '<nav class="pagination" aria-label="Pagination">';
            echo '<ul class="pagination-list">';

            foreach ($paginate_links as $link) {
                $class = 'pagination-item';
                if (strpos($link, 'current') !== false) {
                    $class .= ' current';
                }
                if (strpos($link, 'prev') !== false) {
                    $class .= ' prev';
                }
                if (strpos($link, 'next') !== false) {
                    $class .= ' next';
                }

                echo '<li class="' . esc_attr($class) . '">';
                echo $link;
                echo '</li>';
            }

            echo '</ul>';
            echo '</nav>';
        }
    }

    public static function renderSimple($query = null)
    {
        if (!$query) {
            global $wp_query;
            $query = $wp_query;
        }

        if ($query->max_num_pages <= 1) {
            return;
        }

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        echo '<nav class="pagination-simple" aria-label="Simple pagination">';
        echo '<div class="pagination-links">';

        if ($paged > 1) {
            echo '<a href="' . esc_url(get_pagenum_link($paged - 1)) . '" class="pagination-prev">' . self::TEXT_PREV . '</a>';
        }

        if ($paged < $query->max_num_pages) {
            echo '<a href="' . esc_url(get_pagenum_link($paged + 1)) . '" class="pagination-next">' . self::TEXT_NEXT . '</a>';
        }

        echo '</div>';
        echo '</nav>';
    }
}
