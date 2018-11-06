<?php
/* 
MAGIC MAP SETUP FUNCTIONS
These functions are used by template-parts/map.php to echo the text we need into the Google Map JavaScript.
Having as many of the operations as possible in functions here helps keep everything neat and tidy,
as the map template part has the potential to get quite messy given the amount of things that need to be done and the switching between PHP and JS.
*/

// Use WP_Query inside a function to get an indexed array of address IDs
function caqi_get_address_ids() {
	
	// WP_Query arguments
	$args = array(
		'post_type'         => array( 'club' ),
		'post_status'       => array( 'publish' ),
		'orderby'           => 'menu_order',
		'order'             => 'ASC',
		'posts_per_page'    => -1,
	);

	$address_array = array(); 

	$address_query = new WP_Query( $args );

	while ( $address_query->have_posts() ) : $address_query->the_post();
		$id = get_the_ID(); 
		array_push($address_array, $id);
	endwhile;

	return $address_array; 
}

// Function to get the lat and long of a given address (entered in the lat and long fields in WP) and store them in an array
function caqi_get_address_data($id) {
	
	$address_id = $id;
	$map = get_field('location', $address_id);
	$get_lat = $map['lat'];
	$get_long = $map['lng'];

	// Return an associative array
	$data = array(
		'id' 	=> $address_id,
		'lat' 	=> $get_lat,
		'long' 	=> $get_long,
	);
	return $data;
}

// Function to output the info windows on the map. This is what you want to edit if you want to include different data in the box.
function caqi_map_info_box($id) {
	
	// Get the info from WordPress.
	$image = get_field('logo', $id);
	if( !empty($image) ) {
		$alt      = $image['alt'];
		$setimage = $image['sizes']['medium'];
	}
	// Texturize ACF text fields in case there's symbols that would break the output, such as ' and <
	$title = get_the_title($id);
	$suburb = wptexturize(get_field('suburb', $id));
	$postcode = wptexturize(get_field('postcode', $id));
	$phone = wptexturize(get_field('phone', $id));
	$link = get_the_permalink($id);
	
	// Build the output
	$infobox = '<div class="map-infobox">';
		if($image) {
			$infobox .= '<img src="' . $setimage . '" title="' . get_the_title() . '" alt="' . $alt .'"/>';
		}
		$infobox .= '<div>';
		$infobox .= '<span class="title">'.$title.'</span>';
		if($suburb) {
			$infobox .= '<span class="suburb"><i class="fas fa-map-marker-alt"></i>' . $suburb . '</span>';
			$infobox .= '<span class="postcode">'.$postcode.'</span>';
		}
		if($phone) {
			$infobox .= '<span class="phone"><i class="fas fa-mobile-alt"></i>' . $phone . '</span>';
		}
		$infobox .= '<span class="link"><a class="small button" href="'.$link.'">Find out more</a></span>';
		$infobox .= '</div>';
	$infobox .= '</div>';
	
	return $infobox;
}
