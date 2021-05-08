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
        'numberposts'      => 5,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
    );
    $lastest_post = get_posts($args);

    $args = array(
        'post_type'         => 'news',
        'numberposts'      => 5,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
    );
    $lastest_news = get_posts($args);

    $args = array(
        'post_type'         => 'recettes',
        'numberposts'      => 6,
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
        'numberposts'      => 6,
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
    $archive_link = get_permalink(get_post(get_option( 'page_for_news' )));

    return view('single.news', [
        'archive_link' => $archive_link,
        'post' => $post,
        'related' => $related
    ]);
}]);

Route::any('singular', ['post', function ($post) {


    $tags = get_the_terms($post, 'category');

    $tags_id = [];
    foreach ($tags as $key => $tag) {
        array_push($tags_id, $tag->term_id);
    }

    $args = array(
        'post_type'         => 'post',
        'numberposts'      => 3,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $tags_id
            )
        )
    );


    $related = get_posts($args);


    return view('single.post', [
        'post' => $post,
        'related' => $related
    ]);
}]);



Route::any('post-type-archive', ['recettes', function () {

    $post = get_post(get_option( 'page_for_recettes' ));
    return view('index.recettes', [
        'post' => $post
    ]);
}]);

// TODO : TAG archive page


Route::any('post-type-archive', ['news', function () {

    $post = get_post(get_option( 'page_for_news' ));
    return view('index.news', [
        'post' => $post
    ]);
}]);

Route::any('category', function () {
    // get_terms($)
    $term = get_queried_object()->term_id;
    $term = get_term($term, 'category');

    $args = array(
        'post_type'         => 'post',
        'numberposts'      => -1,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $term->term_id
            )
        )
    );

    $posts = get_posts($args);

    $args = array(
        'post_type'         => 'recettes',
        'numberposts'      => -1,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $term->term_id
            )
        )
    );

    $recettes = get_posts($args);

    $args = array(
        'post_type'         => 'news',
        'numberposts'      => -1,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $term->term_id
            )
        )
    );


    $news = get_posts($args);

    return view('index.cat', [
       'term' => $term,
       'posts' => $posts,
       'recettes' => $recettes,
       'news' => $news
    ]);
});

Route::any('tag', function () {
    $term = get_queried_object()->term_id;
    $term = get_term($term, 'post_tag');

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
                'terms' => $term->term_id
            )
        )
    );

    $posts = get_posts($args);

    $args = array(
        'post_type'         => 'recettes',
        'numberposts'      => -1,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $term->term_id
            )
        )
    );

    $recettes = get_posts($args);

    $args = array(
        'post_type'         => 'news',
        'numberposts'      => -1,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $term->term_id
            )
        )
    );


    $news = get_posts($args);

    return view('index.tag', [
       'term' => $term,
       'posts' => $posts,
       'recettes' => $recettes,
       'news' => $news
    ]);
});





// Route::any('blog', function () {

//     var_dump(get_taxonomies());
// die();

//     $post = get_post(get_option( 'page_for_post' ));
//     return view('index.posts', [
//         'post' => $post
//     ]);
// });
