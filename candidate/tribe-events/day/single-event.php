<?php 
/**
 * Day View Single Event
 * This file contains one event in the day view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php 

$venue_details = array();

if ($venue_name = tribe_get_meta( 'tribe_event_venue_name' ) ) {
	$venue_details[] = $venue_name;	
}

if ($venue_address = tribe_get_meta( 'tribe_event_venue_address' ) ) {
	$venue_details[] = $venue_address;	
}
// Venue microformats
$has_venue = ( $venue_details ) ? ' vcard': '';
$has_venue_address = ( $venue_address ) ? ' location': '';

$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-full'); 
?>

<!-- Event Image -->
<div class="post-image">

	<a href="<?php echo esc_url(tribe_get_event_link()); ?>" class="">
		<img src="<?php  echo $thumb_image_url[0];  ?>" alt="">
	</a>
	
</div>


<div class="post-content">
    <div class="post-header">

	<!-- Event Cost -->
	<?php if ( tribe_get_cost() ) : ?> 
		<div class="tribe-events-event-cost">
			<span><?php echo tribe_get_cost( null, true ); ?></span>
		</div>
	<?php endif; ?>

	<!-- Event Title -->
	<?php do_action( 'tribe_events_before_the_event_title' ) ?>
	<h2 class="tribe-events-list-event-title summary">
		<a class="url" href="<?php echo tribe_get_event_link() ?>" title="<?php the_title() ?>" rel="bookmark">
			<?php the_title() ?>
		</a>
	</h2>
	<?php do_action( 'tribe_events_after_the_event_title' ) ?>

	<!-- Event Meta -->
	<?php do_action( 'tribe_events_before_the_meta' ) ?>
	<div class="post-meta tribe-events-event-meta <?php echo $has_venue . $has_venue_address; ?>">

		<!-- Schedule & Recurrence Details -->
		<div class="updated published time-details">
			<?php echo tribe_events_event_schedule_details() ?>
		</div>
		
		<?php if ( $venue_details ) : ?>
			<!-- Venue Display Info -->
			<div class="tribe-events-venue-details">
				<?php echo implode( ', ', $venue_details) ; ?>
			</div> <!-- .tribe-events-venue-details -->
		<?php endif; ?>

	</div><!-- .tribe-events-event-meta -->
	<?php do_action( 'tribe_events_after_the_meta' ) ?>

</div><!-- .post-header -->

<!-- Event Content -->
<?php do_action( 'tribe_events_before_the_content' ) ?>

<div class="post-exceprt tribe-events-list-event-description tribe-events-content description entry-summary">

	<p><?php echo tribe_events_get_the_excerpt(); ?></p>
	
	<a href="<?php echo esc_url(tribe_get_event_link()); ?>" class="button read-more-button big button-arrow"><?php esc_html_e( 'Read More', 'candidate' ); ?></a>
	
</div><!-- .tribe-events-list-event-description -->

<?php do_action( 'tribe_events_after_the_content' ) ?>



</div>









