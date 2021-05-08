<?php

use Themosis\Support\Facades\Taxonomy;

PostType::make('recettes', 'Recettes', 'recette')
    ->setArguments([
        'public' => true,
        'menu_position' => 5,
        'supports' => ['title', 'editor'],
        'rewrite' => 'recettes',
        'query_var' => false,
        'menu_icon' => 'dashicons-food'
    ])->set();



    add_action('init', 'recettes_tax');
    function recettes_tax()
    {
        register_taxonomy_for_object_type('post_tag', 'recettes');
        register_taxonomy_for_object_type('category', 'recettes');
    };


    /**
 * Adds a custom field: "Projects page"; on the "Settings > Reading" page.
 */
add_action( 'admin_init', function () {
    $id = 'page_for_recettes';
    // add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() )
    add_settings_field( $id, 'Recettes page:', 'settings_field_page_for_recettes', 'reading', 'default', array(
        'label_for' => 'field-' . $id, // A unique ID for the field. Optional.
        'class'     => 'row-' . $id,   // A unique class for the TR. Optional.
    ) );
} );

/**
 * Renders the custom "Projects page" field.
 *
 * @param array $args
 */
function settings_field_page_for_recettes( $args ) {
    $id = 'page_for_recettes';
    wp_dropdown_pages( array(
        'name'              => $id,
        'show_option_none'  => '&mdash; Select &mdash;',
        'option_none_value' => '0',
        'selected'          => get_option( $id ),
    ) );
}

/**
 * Adds page_for_projects to the white-listed options, which are automatically
 * updated by WordPress.
 *
 * @param array $options
 */
add_filter( 'allowed_options', function ( $options ) {
    $options['reading'][] = 'page_for_recettes';

    return $options;
} );


add_filter( 'display_post_states', function ( $states, $post ) {
    if ( intval( get_option( 'page_for_recettes' ) ) === $post->ID ) {
        $states['page_for_recettes'] = __( 'Recettes Page' );
    }

    return $states;
}, 10, 2 );
