<?php
function get_custom_cat_template($single_template) {
    global $post;
    foreach(get_the_category($post->ID) as $post_category) {
        $file_path = get_template_directory() . '/single-category-' . $post_category->slug . '.php';
            if(file_exists($file_path))
                $single_template = $file_path;
            elseif($post_category->parent != 0) {
                $category = get_category($post_category->parent);
                $file_path = get_template_directory() . '/single-category-' . $category->slug . '.php';
                if(file_exists($file_path))
                    $single_template = $file_path;
            }
    }

    return $single_template;
}

add_filter( "single_template", "get_custom_cat_template" ) ;