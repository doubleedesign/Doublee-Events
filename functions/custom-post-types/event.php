<?php
// Register Custom Post Type
function doublee_event() {

	$labels = array(
		'name'                  => _x( 'Events', 'Post Type General Name', 'doublee' ),
		'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'doublee' ),
		'menu_name'             => __( 'Events', 'doublee' ),
		'name_admin_bar'        => __( 'Event', 'doublee' ),
		'archives'              => __( 'Event Archives', 'doublee' ),
		'attributes'            => __( 'Event Attributes', 'doublee' ),
		'parent_item_colon'     => __( 'Parent Event:', 'doublee' ),
		'all_items'             => __( 'All Events', 'doublee' ),
		'add_new_item'          => __( 'Add New Event', 'doublee' ),
		'add_new'               => __( 'Add New', 'doublee' ),
		'new_item'              => __( 'New Event', 'doublee' ),
		'edit_item'             => __( 'Edit Event', 'doublee' ),
		'update_item'           => __( 'Update Event', 'doublee' ),
		'view_item'             => __( 'View Event', 'doublee' ),
		'view_items'            => __( 'View Events', 'doublee' ),
		'search_items'          => __( 'Search Event', 'doublee' ),
		'not_found'             => __( 'Not found', 'doublee' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'doublee' ),
		'featured_image'        => __( 'Featured Image', 'doublee' ),
		'set_featured_image'    => __( 'Set featured image', 'doublee' ),
		'remove_featured_image' => __( 'Remove featured image', 'doublee' ),
		'use_featured_image'    => __( 'Use as featured image', 'doublee' ),
		'insert_into_item'      => __( 'Insert into event', 'doublee' ),
		'uploaded_to_this_item' => __( 'Uploaded to this event', 'doublee' ),
		'items_list'            => __( 'Events list', 'doublee' ),
		'items_list_navigation' => __( 'Events list navigation', 'doublee' ),
		'filter_items_list'     => __( 'Filter events list', 'doublee' ),
	);
	$args = array(
		'label'                 => __( 'Event', 'doublee' ),
		'description'           => __( 'Custom post type for listing a event', 'doublee' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'event', $args );

}
add_action( 'init', 'doublee_event', 0 );
