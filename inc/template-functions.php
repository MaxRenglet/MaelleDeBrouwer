<?php

use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Filter;
use Bikubi\WPBulmaNavbarWalker;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
Filter::add('body_class', function ($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
});

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
Action::add('wp_head', function () {
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="' . esc_url(get_bloginfo('pingback_url')) . '">';
    }
});

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
Action::add('after_setup_theme', function () {
    $GLOBALS['content_width'] = 640;
}, 0);

/**
 * 
 * Disable Gutenberg
 * 
 */
// add_filter('use_block_editor_for_post', '__return_false', 10);

function menu_header($location)
{

    $menu = wp_nav_menu(array(
        'theme_location'  => $location,
        'depth'        =>    3,
        'menu'            =>    'NewNav',
        'container'        =>    '',
        'menu_class'        =>    '',
        'items_wrap'        =>    '%3$s',
        'walker'        =>    new Bulma_Navwalker(),
        'fallback_cb'        =>    'Bulma_NavWalker::fallback'
    ));

    return $menu;
}

add_filter('the_content', 'wpautop');


function reading_time($content)
{
    $word = str_word_count(strip_tags($content));
    $m = floor($word / 200);
    $s = floor($word % 200 / (200 / 60));
    $est = $m . ' minute' . ($m == 1 ? '' : 's') . ', ' . $s . ' seconde' . ($s == 1 ? '' : 's');
    return $est;
}
