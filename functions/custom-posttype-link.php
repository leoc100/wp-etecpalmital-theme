<?php

function create_taxonomy_link() {
    $args = array(
      'public' => true,
      'label'  => 'Links',
      'supports' => ['title', 'thumbnail'],
      'taxonomies' => array('post_tag')
    );
    register_post_type( 'link', $args );
}
add_action( 'init', 'create_taxonomy_link' );

function url_meta_box_form() {
    global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'url_fields' );
	// Get the url data if it's already been entered
	$url = get_post_meta( $post->ID, 'url', true );
	// Output the field
	echo '<input type="text" name="url" value="' . esc_textarea( $url )  . '" class="widefat">';
}

function url_meta_box_add() {

    add_meta_box( 'url-meta-box', 'URL', 'url_meta_box_form', 'link', 'normal', 'high' );

}
add_action( 'add_meta_boxes', 'url_meta_box_add' );
    
function save_url_post(){
    global $post;        
        update_post_meta($post->ID, 'url', $_POST['url']);
}
add_action('save_post', 'save_url_post');
