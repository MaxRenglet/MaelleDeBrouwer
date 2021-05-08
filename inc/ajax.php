<?php

Filter::add('themosis_front_global', function ($data) {
    $data['nonce'] = wp_create_nonce('add-posts');
    return $data;
});

Ajax::listen('filter', function () {
    // Perform security check before anything - nonce
    check_ajax_referer('add-posts', 'security');

    if (isset($_POST['post_type'])) {

        $cpt = $_POST['post_type'];

        if (isset($_POST['cat_val'])) {
            $cat = $_POST['cat_val'];
            $args_cat =  array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $cat
            );
        } else {
            $args_cat = "";
        }

        if (isset($_POST['tag_val'])) {
            $tag = $_POST['tag_val'];
            $args_tag =  array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag
            );
        } else 
        {
            $args_tag = "";
        }

        if (isset($_POST['order'])) {
            $order = $_POST['order'];
        } else {
            $order = "DESC";
        }


        $args = array(
            'post_type'         => $cpt,
            'numberposts'      => -1,
            'orderby'          => 'post_date',
            'order'            => $order,

            'tax_query' => array(
                'relation' => 'AND',
               $args_cat,
               $args_tag
            )
        );



        $posts = get_posts($args);

       if($posts){
        echo view('components.layout.filter', [
            'posts' => $posts
        ]);
       } else {
           echo "No results";
       }

    }

    die();
    // Perform your WordPress actions...
});
