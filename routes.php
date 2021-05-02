<?php

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */


Route::any('/', function ($post) {


    $args = array(
        'post_type'         => 'post',
        'numberposts'      => 3,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
    );
    $lastest_post = get_posts($args);

    $args = array(
        'post_type'         => 'news',
        'numberposts'      => 3,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
    );
    $lastest_news = get_posts($args);

    $args = array(
        'post_type'         => 'recettes',
        'numberposts'      => 3,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
    );
    $lastest_recettes = get_posts($args);


    return view('pages.front', [
        'posts' => $lastest_post,
        'recettes' => $lastest_recettes,
        'news' => $lastest_news,
        'post' => $post
    ]);
});

Route::any('singular', ['recettes', function ($post) {
    return view('single.recettes', [
        'post' => $post
    ]);
}]);

Route::any('singular', ['news', function ($post) {

    $tags = get_the_terms($post, 'post_tag');

    $tags_id = [];
    foreach ($tags as $key => $tag) {
        array_push($tags_id, $tag->term_id);
    }

    $args = array(
        'post_type'         => 'post',
        'numberposts'      => -1,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tags_id
            )
        )
    );

    $related = get_posts($args);


    return view('single.news', [
        'post' => $post,
        'related' => $related
    ]);
}]);

Route::any('single', function ($post) {

    $cpt = $post->post_type;

    return view('single.' . $cpt, [
        'post' => $post
    ]);
});


Route::any('post-type-archive', ['recettes', function () {

    $post = get_post(get_option( 'page_for_recettes' ));
    return view('index.recettes', [
        'post' => $post
    ]);
}]);