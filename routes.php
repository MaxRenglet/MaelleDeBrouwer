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
    $tags = get_the_terms($post, 'category');

    $tags_id = [];
    foreach ($tags as $key => $tag) {
        array_push($tags_id, $tag->term_id);
    }

    $args = array(
        'post_type'         => 'recettes',
        'numberposts'      => 6,
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
    $archive_link = get_permalink(get_post(get_option( 'page_for_recettes' )));

    return view('single.recettes', [
        'archive_link' => $archive_link,
        'post' => $post,
        'related' => $related
    ]);
}]);

Route::any('singular', ['news', function ($post) {

    $tags = get_the_terms($post, 'category');

    $tags_id = [];
    foreach ($tags as $key => $tag) {
        array_push($tags_id, $tag->term_id);
    }

    $args = array(
        'post_type'         => 'post',
        'numberposts'      => 8,
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
        'numberposts'      => 4,
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


Route::any('post-type-archive', ['recettes', function () {

    $page = get_post(get_option( 'page_for_recettes' ));
    
    $args = array(
        'post_type'         => 'recettes',
        'numberposts'      => -1,
    );

    $posts = get_posts($args);

    $cats = [];
    $tags = [];

    foreach ($posts as $key => $post) {
        $cats_all = get_the_terms($post, 'category');
        $tags_all = get_the_terms($post, 'post_tag');
        foreach ($cats_all as $key => $cat) {
           $cats[$cat->term_id] = $cat;
        }
        foreach ($tags_all as $key => $tag) {
            $tags[$tag->term_id] = $tag;
         }
    }
    
    $count = count($posts);


    return view('index.recettes', [
        'page' => $page,
        'cats' => $cats,
        'tags' => $tags,
        'count' => $count
    ]);
}]);



Route::any('post-type-archive', ['news', function () {

    $page = get_post(get_option( 'page_for_news' ));
    
    $args = array(
        'post_type'         => 'news',
        'numberposts'      => -1,
    );

    $posts = get_posts($args);

    $cats = [];
    $tags = [];

    foreach ($posts as $key => $post) {
        $cats_all = get_the_terms($post, 'category');
        $tags_all = get_the_terms($post, 'post_tag');
        foreach ($cats_all as $key => $cat) {
           $cats[$cat->term_id] = $cat;
        }
        foreach ($tags_all as $key => $tag) {
            $tags[$tag->term_id] = $tag;
         }
    }

 

    return view('index.news', [
        'page' => $page,
        'cats' => $cats,
        'tags' => $tags,
    ]);
}]);



Route::any('blog', function () {


    $page = get_post(get_option( 'page_for_posts' ));
    
    $args = array(
        'post_type'         => 'post',
        'numberposts'      => -1,
    );

    $posts = get_posts($args);

    $cats = [];
    $tags = [];

    foreach ($posts as $key => $post) {
        $cats_all = get_the_terms($post, 'category');
        $tags_all = get_the_terms($post, 'post_tag');
        foreach ($cats_all as $key => $cat) {
           $cats[$cat->term_id] = $cat;
        }
        foreach ($tags_all as $key => $tag) {
            $tags[$tag->term_id] = $tag;
         }
    }

 

    return view('index.posts', [
        'page' => $page,
        'cats' => $cats,
        'tags' => $tags,
    ]);
});

Route::any('page', function ($post, $query) {
    return view('pages.page', [
        'page' => $post 
    ]);
});