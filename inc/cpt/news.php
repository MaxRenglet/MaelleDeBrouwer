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



Taxonomy::make('post_tag', array('news', 'post'), 'Tags', 'Tag')
    ->set();

Taxonomy::make('category', array('news', 'post'), 'Catégories', 'Catégorie')
->setArguments([
    'hierarchical' => true,
])
    ->set();
