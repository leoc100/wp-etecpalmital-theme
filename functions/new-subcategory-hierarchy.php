<?php
function new_subcategory_hierarchy() { 
    $category = get_queried_object();

    $templates = array();

    do {
        $parent_id = $category->parent;
        $templates[] = "category-{$category->slug}.php";
        $templates[] = "category-{$category->term_id}.php";
        if($parent_id != 0)
            $category = get_category($parent_id);
    } while ($parent_id != 0);
    $templates[] = 'category.php';
    return locate_template( $templates );
}

add_filter( 'category_template', 'new_subcategory_hierarchy' );