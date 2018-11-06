<?php
/**
 * Event Archive - Events page
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Doublee-Events
 * @since Doublee-Events 1.0
 */

get_header(); ?>

<main id="page" class="events archive">

	<?php
		// Check if we are on the first page - only show upcoming event on first page
		if ( !is_paged() ) { ?>
		<?php
			$today = date('Y-m-d');
			// Meta query to check if the event is upcoming
			$meta_query_next = array(
				array(
					'key'       => 'event_date',
					'value'     => $today,
					'type'      => 'DATE',
					'compare'   => '>='
				)
			);
			// WP_Query arguments to get the next upcoming event
			$args = array(
				'post_type'         => array( 'event' ),
				'post_status'       => array( 'publish' ),
				'orderby'           => 'meta_value_num',
				'meta_key'          => 'event_date',
				'order'	            => 'ASC',
				'posts_per_page'    => '1',
				'meta_query'        => $meta_query_next
			);
			// The Query
			$events = new WP_Query( $args );
			// The Loop to show the next upcoming event
			if ( $events->have_posts() ) {
				while ( $events->have_posts() ) {
					$events->the_post(); ?>
					<?php if(has_post_thumbnail()) {
						// Get the featured image to use as the background
						$imgdata = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$setimage = $imgdata[0];
						?>
					<div class="next-event with-image" style="background-image: url('<?php echo $setimage; ?>');">
					<?php
					// If the featured image isn't set, then don't add the "with-image" class.
					// This allows for CSS to be targeted based on whether there's a background image or not.
					} else { ?>
					<div class="next-event">
					<?php } ?>
						<div class="row">
							<div class="info small-12 large-6 columns">
								<div class="inner small-12 columns">
									<h1>
										<span class="primary label">Next Event</span>
										<span class="title"><?php the_title(); ?></span>
									</h1>
									<?php
										// Get the start and end dates and create variables of the data we'll need
										// Note: End date may not be set for single-day events
										$start_date = get_field('event_date');
										$start_day = DateTime::createFromFormat('Y-m-d', $start_date)->format('d');
										$start_month = DateTime::createFromFormat('Y-m-d', $start_date)->format('M');
										$start_year = DateTime::createFromFormat('Y-m-d', $start_date)->format('Y');
										$end_date = get_field('event_end_date');
										if($end_date) {
											$end_day   = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'd' );
											$end_month = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'M' );
											$end_year = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'Y' );
										}
										// Get the name of the location
										$location_name = get_field('location_name');
									?>

									<?php // Markup to show the date and the location, with a Google Map link to the location ?>
									<div class="date-wrapper nested row align-middle">
										<div class="date small-3 columns">
											<time datetime="<?php echo $start_date; ?>">
												<?php if($end_date) {
													if($start_month == $end_month) { ?>
														<span class="month"><?php echo $start_month; ?></span>
														<span class="day"><?php echo $start_day . '-' . $end_day; ?></span>
													<?php } else { ?>
														<span class="month-day"><?php echo $start_day . ' ' . $start_month; ?> </span>
														<span class="month-day">- <?php echo $end_day . ' ' . $end_month; ?></span>
													<?php } ?>
													<span class="year"><?php echo $end_year; ?></span>
												<?php } else { ?>
													<span class="month"><?php echo $start_month; ?></span>
													<span class="day"><?php echo $start_day; ?></span>
													<span class="year"><?php echo $start_year; ?></span>
												<?php } ?>
											</time>
										</div>
										<div class="small-9 columns">
											<div class="details">
												<?php if($location_name) {
													echo '<p>' . $location_name . '</p>';
												} ?>
												<?php
													$location = get_field('location'); // Google Map field
													$map_address = $location['address'];
													$map_query_string = urlencode($map_address);
													$map_url = 'https://www.google.com/maps/search/?api=1&query='.$map_query_string;
												?>
												<a class="map-link" href="<?php echo $map_url; ?>" target="_blank">Google Map &nbsp; <i class="fas
								fa-external-link-alt"></i></a>
											</div>
										</div>
									</div>

									<?php // Markup to show preview text and button to the single event view ?>
									<div class="nested row">
										<div class="small-12 columns">
											<?php the_excerpt(); ?>
										</div>
										<div class="small-12 columns">
											<a class="large primary button" href="<?php echo the_permalink(); ?>">
												Full details &amp; ticketing info <i class="fas fa-angle-right"></i>
											</a>
										</div>
									</div>

								</div>
							</div>

							<?php // Markup to show the map ?>
							<div class="map-wrapper small-12 large-6 columns">
								<?php get_template_part('template-parts/minimap'); ?>
							</div>

						</div>
					</div>
					<?php
				}
			} else {
				// If there's no upcoming events, say so
				?>
				<div class="next-event">
					<div class="row align-middle align-center">
						<div class="small-12 large-8 columns">
							<div class="primary callout">There are no upcoming events.</div>
						</div>
					</div>
				</div>
			<?php }
			// We're done with this WP_Query
			// Restore original post data
			wp_reset_postdata();
		?>

		<div class="row">

			<h2 class="small-12 columns">More Upcoming Events</h2>
			<?php
			$today = date('Y-m-d');
			// Meta query to check the events are upcoming
			$meta_query_upcoming = array(
				array(
					'key'       => 'event_date',
					'value'     => $today,
					'type'      => 'DATE',
					'compare'   => '>='
				)
			);
			// WP_Query arguments to get all the upcoming events except the first one
			$args = array(
				'post_type'         => array( 'event' ),
				'post_status'       => array( 'publish' ),
				'orderby'           => 'meta_value_num',
				'meta_key'          => 'event_date',
				'order'	            => 'ASC',
				'posts_per_page'    => '100', // assuming there's not  going to be more than 100 - adjust as needed
				'offset'			=> '1', // offset by 1 because the first upcoming event is output above
				'meta_query'        => $meta_query_upcoming
			);
			// The Query
			$events = new WP_Query( $args );
			// The Loop to output the preview tiles for upcoming events
			if ( $events->have_posts() ) {
				while ( $events->have_posts() ) {
					$events->the_post();
					get_template_part('excerpts/excerpt-event');
				}
			}
			// We're done with this WP_Query
			// Restore original Post Data
			wp_reset_postdata();
			?>
		</div>
	<?php } ?>

	<div class="row">
	<h2 class="small-12 columns">Past Events</h2>
		<?php
			$today = date('Y-m-d');
			// We're going to allow past events to page, rather than showing them all on one page
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			// Meta query to check the events are past
			$meta_query_past = array(
				array(
					'key'       => 'event_date',
					'value'     => $today,
					'type'      => 'DATE',
					'compare'   => '<='
				)
			);
			// WP_Query arguments
			$args = array(
				'post_type'         => array( 'event' ),
				'post_status'       => array( 'publish' ),
				'orderby'           => 'meta_value_num',
				'meta_key'          => 'event_date',
				'order'	            => 'DESC',
				'posts_per_page'    => '12',
				'meta_query'        => $meta_query_past,
				'paged' 			=> $paged
			);
			// The Query
			$events = new WP_Query( $args );
			// The Loop to show preview cards of past events
			if ( $events->have_posts() ) {
				while ( $events->have_posts() ) {
					$events->the_post();
					get_template_part('excerpts/excerpt-event');
				}
			}
			// Pagination
			get_template_part( 'template-parts/pagination' );
			// We're done with this WP_Query
			// Restore original Post Data
			wp_reset_postdata();
		?>
	</div>

</main>

<?php get_footer(); ?>
