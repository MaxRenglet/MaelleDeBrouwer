<?php

use Themosis\Support\Facades\Taxonomy;

PostType::make('news', 'News', 'News')
    ->setArguments([
        'public' => true,
        'menu_position' => 4,
        'supports' => ['title', 'editor'],
        'rewrite' => 'news',
        'query_var' => false,
        'menu_icon' => 'dashicons-format-aside'
    ])->set();


    add_action('init', 'news_tax');
    function news_tax()
    {
        register_taxonomy_for_object_type('post_tag', 'news');
        register_taxonomy_for_object_type('category', 'news');
    };




/**
 * Adds a custom field: "Projects page"; on the "Settings > Reading" page.
 */
add_action('admin_init', function () {
    $id = 'page_for_news';
    // add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() )
    add_settings_field($id, 'News page:', 'settings_field_page_for_news', 'reading', 'default', array(
        'label_for' => 'field-' . $id, // A unique ID for the field. Optional.
        'class'     => 'row-' . $id,   // A unique class for the TR. Optional.
    ));
});

/**
 * Renders the custom "Projects page" field.
 *
 * @param array $args
 */
function settings_field_page_for_news($args)
{
    $id = 'page_for_news';
    wp_dropdown_pages(array(
        'name'              => $id,
        'show_option_none'  => '&mdash; Select &mdash;',
        'option_none_value' => '0',
        'selected'          => get_option($id),
    ));
}

/**
 * Adds page_for_projects to the white-listed options, which are automatically
 * updated by WordPress.
 *
 * @param array $options
 */
add_filter('allowed_options', function ($options) {
    $options['reading'][] = 'page_for_news';

    return $options;
});


add_filter('display_post_states', function ($states, $post) {
    if (intval(get_option('page_for_news')) === $post->ID) {
        $states['page_for_news'] = __('News Page');
    }

    return $states;
}, 10, 2);



// add_action( 'init', 'unregister_post_tag');
// function unregister_post_tag(){
// 	global $wp_taxonomies;
// 	$taxonomies = array( 'post_tag' );
// 	foreach( $taxonomies as $taxonomy ) {
// 		if ( taxonomy_exists( $taxonomy) )
// 			unset( $wp_taxonomies[$taxonomy]);
// 	}
// }