<?php
// Register Custom Post Type
	function doublee_event() {

		$labels = array(
			'name'                  => _x( 'Events', 'Post Type General Name', 'caqi' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'caqi' ),
			'menu_name'             => __( 'Events', 'caqi' ),
			'name_admin_bar'        => __( 'Event', 'caqi' ),
			'archives'              => __( 'Event Archives', 'caqi' ),
			'attributes'            => __( 'Event Attributes', 'caqi' ),
			'parent_item_colon'     => __( 'Parent Event:', 'caqi' ),
			'all_items'             => __( 'All Events', 'caqi' ),
			'add_new_item'          => __( 'Add New Event', 'caqi' ),
			'add_new'               => __( 'Add New', 'caqi' ),
			'new_item'              => __( 'New Event', 'caqi' ),
			'edit_item'             => __( 'Edit Event', 'caqi' ),
			'update_item'           => __( 'Update Event', 'caqi' ),
			'view_item'             => __( 'View Event', 'caqi' ),
			'view_items'            => __( 'View Events', 'caqi' ),
			'search_items'          => __( 'Search Event', 'caqi' ),
			'not_found'             => __( 'Not found', 'caqi' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'caqi' ),
			'featured_image'        => __( 'Featured Image', 'caqi' ),
			'set_featured_image'    => __( 'Set featured image', 'caqi' ),
			'remove_featured_image' => __( 'Remove featured image', 'caqi' ),
			'use_featured_image'    => __( 'Use as featured image', 'caqi' ),
			'insert_into_item'      => __( 'Insert into event', 'caqi' ),
			'uploaded_to_this_item' => __( 'Uploaded to this event', 'caqi' ),
			'items_list'            => __( 'Events list', 'caqi' ),
			'items_list_navigation' => __( 'Events list navigation', 'caqi' ),
			'filter_items_list'     => __( 'Filter events list', 'caqi' ),
		);
		$args = array(
			'label'                 => __( 'Event', 'caqi' ),
			'description'           => __( 'Custom post type for listing a event', 'caqi' ),
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