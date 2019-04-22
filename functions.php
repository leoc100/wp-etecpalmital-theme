<?php
add_theme_support('post-thumbnails');

function modify_read_more_link() {
    return '<br /><a class="btn btn-dark float-right" href="' . get_permalink() . '">Leia Mais</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

function new_excerpt_more($more) {
    global $post;
    return '<br /><a class="btn btn-dark float-right"
    href="'. get_permalink($post->ID) . '">Leia Mais</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function get_custom_cat_template($single_template) {
    global $post;
    foreach(get_the_category($post->ID) as $post_category) {
        $file_path = dirname( __FILE__ ) . '/single-category-' . $post_category->slug . '.php';
            if(file_exists($file_path))
                $single_template = $file_path;
            elseif($post_category->parent != 0) {
                $category = get_category($post_category->parent);
                $file_path = dirname( __FILE__ ) . '/single-category-' . $category->slug . '.php';
                if(file_exists($file_path))
                    $single_template = $file_path;
            }
    }

    return $single_template;
}

add_filter( "single_template", "get_custom_cat_template" ) ;