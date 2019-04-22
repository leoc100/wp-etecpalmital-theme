<?php
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