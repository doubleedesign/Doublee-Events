<?php
/**
 * Event Archive - Events page
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage CAQI
 * @since CAQI 2.0
 */

get_header(); ?>

<main id="page" class="events archive">

	<?php if ( !is_paged() ) { ?>
		<?php
			$today = date('Y-m-d');
			// Meta query to check the events are upcoming
			$meta_query_next = array(
				array(
					'key'       => 'event_date',
					'value'     => $today,
					'type'      => 'DATE',
					'compare'   => '>='
				)
			);
			// WP_Query arguments
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
			// The Loop
			if ( $events->have_posts() ) {
				while ( $events->have_posts() ) {
					$events->the_post(); ?>
					<?php if(has_post_thumbnail()) {
						// Get image
						$imgdata = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$setimage = $imgdata[0];
						// Get CSS overrides from backend
						$fill = get_field('image_fill');
						$position = get_field('image_position');
						if ($position == 'left' || $position == 'right') {
							$position = $position . ' 100px';
						}
						?>
					<div class="next-event with-image" style="
							background-image: url('<?php echo $setimage; ?>');
							background-position: center <?php echo $position; ?>;
							background-size: <?php echo $fill; ?>">
					<?php } else { ?>
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
										$location_name = get_field('location_name');
									?>
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
							<div class="map-wrapper small-12 large-6 columns">
								<?php get_template_part('template-parts/minimap'); ?>
							</div>
						</div>
					</div>
					<?php
				}
			} else { ?>
				<div class="next-event">
					<div class="row align-middle align-center">
						<div class="small-12 large-8 columns">
							<div class="primary callout">There are no upcoming events.</div>
						</div>
					</div>
				</div>
			<?php }
			// Restore original Post Data
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
			// WP_Query arguments
			$args = array(
				'post_type'         => array( 'event' ),
				'post_status'       => array( 'publish' ),
				'orderby'           => 'meta_value_num',
				'meta_key'          => 'event_date',
				'order'	            => 'ASC',
				'posts_per_page'    => '100',
				'offset'			=> '1',
				'meta_query'        => $meta_query_upcoming
			);
			// The Query
			$events = new WP_Query( $args );
			// The Loop
			if ( $events->have_posts() ) {
				while ( $events->have_posts() ) {
					$events->the_post();
					get_template_part('excerpts/excerpt-event');
				}
			}
			// Restore original Post Data
			wp_reset_postdata();
			?>
		</div>
	<?php } ?>

	<div class="row">
	<h2 class="small-12 columns">Past Events</h2>
		<?php
			$today = date('Y-m-d');
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			// Meta query to check the events are upcoming
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
				'posts_per_page'    => '2',
				'meta_query'        => $meta_query_past,
				'paged' 			=> $paged
			);
			// The Query
			$events = new WP_Query( $args );
			// The Loop
			if ( $events->have_posts() ) {
				while ( $events->have_posts() ) {
					$events->the_post();
					get_template_part('excerpts/excerpt-event');
				}
			}
			// Pagination
			get_template_part( 'template-parts/pagination' );
			// Restore original Post Data
			wp_reset_postdata();
		?>
	</div>

</main>

<?php get_footer(); ?>
