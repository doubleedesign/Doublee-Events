<?php
/**
 * The template for displaying single events
 *
 * @package WordPress
 * @subpackage Doublee-Events
 * @since Doublee-Events 1.0
 */

get_header(); ?>

<?php
if(has_post_thumbnail()) {
	get_template_part( 'template-parts/featured-image-banner' );
}
?>

<div id="single-event">

	<div class="this-event">
		<div class="row">
			<div class="info small-12 large-6 columns">
				<div class="inner small-12 columns">
					<h1>
						<?php
						// Get start and end date fields (Note: Also used display the date later)
						$start_date = get_field('event_date');
						$end_date = get_field('event_end_date');
						// Get today's date as an integer
						$today = (int)date('Ymd');
						// Convert the start or end date from the usual format to the integer we need to work out whether the event is upcoming or past
						// Use end date if set, otherwise use start date)
						if($end_date) {
							$date_to_use_for_status = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'Ymd' );
						} else {
							$date_to_use_for_status = DateTime::createFromFormat( 'Y-m-d', $start_date )->format( 'Ymd' );
						}
						// Cast to integer
						$date_to_use_for_status = (int)$date_to_use_for_status;
						// Compare event date to today's date (smaller integer = past event)
						if($today <= $date_to_use_for_status) {
							$status = 'upcoming';
						} else {
							$status = 'past';
						}
						?>
						<span class="primary label"><?php echo ucfirst($status); ?> event</span>
						<span class="title"><?php the_title(); ?></span>
					</h1>
					<?php the_content(); ?>
				</div>
			</div>

			<div class="map-wrapper small-12 large-6 columns">

				<?php // Markup to show the date and location name ?>
				<div class="date-wrapper nested row align-middle">
					<div class="date small-3 columns">
						<?php
							$start_day = DateTime::createFromFormat('Y-m-d', $start_date)->format('d');
							$start_month = DateTime::createFromFormat('Y-m-d', $start_date)->format('M');
							$start_year = DateTime::createFromFormat('Y-m-d', $start_date)->format('Y');
							if($end_date) {
								$end_day   = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'd' );
								$end_month = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'M' );
								$end_year = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'Y' );
							}
							$location_name = get_field('location_name');
						?>
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
								echo '<p class="location-name"><strong>' . $location_name . '</strong></p>';
							} ?>
							<?php
								$location = get_field('location'); // Google Map field
								$map_address = $location['address'];
								$map_query_string = urlencode($map_address);
								$map_url = 'https://www.google.com/maps/search/?api=1&query='.$map_query_string;
							?>
							<p class="location-address"><?php echo $map_address; ?></p>
							<a class="map-link" href="<?php echo $map_url; ?>" target="_blank">Google Map &nbsp; <i class="fas
							fa-external-link-alt"></i></a>
						</div>
					</div>
				</div>

				<?php
				// Show the ticketing link if the event is upcoming
				$ticket_link = get_field('ticketing_link');
				if (($ticket_link) && ($status == 'upcoming')) { ?>
					<a class="large primary expanded button" href="<?php echo $ticket_link; ?>" target="_blank">
						Tickets<i class="fas fa-external-link-alt"></i>
					</a>
				<?php } ?>

				<?php
				// Show the map
				get_template_part('template-parts/minimap');
				?>

			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
