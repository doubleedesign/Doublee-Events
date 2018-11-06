<div <?php post_class('excerpt-event small-12 medium-6 columns'); ?>>
	<a class="inner" href="<?php the_permalink(); ?>">
		<div class="nested row align-middle">
			<?php
			$start_date = get_field('event_date');
			$start_day = DateTime::createFromFormat('Y-m-d', $start_date)->format('d');
			$start_month = DateTime::createFromFormat('Y-m-d', $start_date)->format('M');

			$end_date = get_field('event_end_date');
			if($end_date) {
				$end_day   = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'd' );
				$end_month = DateTime::createFromFormat( 'Y-m-d', $end_date )->format( 'M' );
			}

			$location = get_field('location_name');
			?>
			<div class="date-wrapper small-3 columns">
				<div class="date">
					<time datetime="<?php echo $start_date; ?>">
						<?php if($end_date) {
							if($start_month == $end_month) { ?>
								<span class="month"><?php echo $start_month; ?></span>
								<span class="day"><?php echo $start_day . '-' . $end_day; ?></span>
							<?php } else { ?>
								<span class="month-day"><?php echo $start_day . ' ' . $start_month; ?> </span>
								<span class="month-day">- <?php echo $end_day . ' ' . $end_month; ?></span>
							<?php } ?>
						<?php } else { ?>
							<span class="month"><?php echo $start_month; ?></span>
							<span class="day"><?php echo $start_day; ?></span>
						<?php } ?>
					</time>
				</div>
			</div>
			<div class="small-9 columns">
				<div class="details">
					<h3><?php the_title(); ?></h3>
					<?php if($location) { echo '<p>' . $location . '</p>'; } ?>
				</div>
			</div>
		</div>
	</a>
</div>
