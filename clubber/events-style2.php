<?php
/*
Template Name: Event Style 2
*/
?>

<?php get_header(); ?>


<div id="content">

<div class="title-head"><h1><?php
$prefix = false;
if (function_exists('is_tag') && is_tag()) {
    $prefix = true;
} elseif (is_archive()) {
    wp_title(' ');
} elseif (is_page()) {
    the_title();
}
?>
</h1></div><!-- end #title-head -->

<?php
$page_layout = sidebar_layout();
switch ($page_layout) {
    case "layout-sidebar-left":
        echo '
<div class="sidebar-left">';
        wz_setSection('zone-sidebar');
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-page'));
        echo '
</div><!-- end .sidebar-left -->';
        break;
    case "layout-sidebar-right":
        echo '
<div class="sidebar-right">';
        wz_setSection('zone-sidebar');
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-page'));
        echo '
</div><!-- end .sidebar-right -->';
        break;
    case "layout-full":
        echo '
<div class="sidebar-right">';
        wz_setSection('zone-sidebar');
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-page'));
        echo '
</div><!-- end .sidebar-right -->';
        break;
}
?>

<div class="fixed">
  <div class="col-blog-archive">
    <div class="event-upcoming"><h3><?php _e('Upcoming Events', 'clubber'); ?></h3></div>
<?php 
$term     = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$query    = array(
    'post_type' => 'event',
    'orderby' => 'meta_value',
	'order' => 'asc',
	'posts_per_page' => 10,
	'meta_value' => strftime("%Y/%m/%d", time()- (60 * 60 * 24) ),
	'meta_key' => 'event_date_interval',
	'meta_compare' => '>',
    'taxonomy' => 'events',
	'term' => $term->slug
);
$wp_query = new WP_Query($query);
$results = $wp_query->post_count;
if ($results != ''):
    while ($wp_query->have_posts()):
        $wp_query->the_post();
        global $post;
 		setup_postdata($post); 	
		$results = $wp_query->post_count;
        $data_event     = get_post_meta($post->ID, 'event_date_interval', true);
		$data_finish    = get_post_meta($post->ID, 'event_date_interval_finish', true);
        $time           = strtotime($data_event);
		$time_finish    = strtotime($data_finish);
        $date_yy 		= date('Y', $time);
        $date_d  		= date('d', $time);
		$date_yy_finish = date('Y', $time_finish);
		$date_d_finish  = date('d', $time_finish);
		require('includes/language.php');
        $tstart         = get_post_meta($post->ID, 'event_tstart', true);
        $tend           = get_post_meta($post->ID, 'event_tend', true);
        $venue          = get_post_meta($post->ID, 'event_venue', true);
		$event_text     = get_post_meta($post->ID, "ev_text", true);
        $custom         = get_post_custom($post->ID);
        $event_ticket   = $custom["event_ticket"][0];
        $image_id       = get_post_thumbnail_id();
        $cover          = wp_get_attachment_image_src($image_id, 'event-cover-arc');	
        echo '
    <div class="event-archive2">';
		if ($data_finish != null) {
			echo '    
      <div class="event-arc-data2-finish">
        <div class="event-arc-day2-finish">' . $date_d . ' ' . $date_M . ' - ' . $date_d_finish . ' ' . $date_M_finish . '</div>
      </div><!-- end #event-arc-data2 -->';            
	  	} elseif ($data_event != null) {
			echo '
      <div class="event-arc-data2">
        <div class="event-arc-day2">' . $date_d . '</div>
        <div class="event-arc-month2">' . $date_M . '</div>
      </div><!-- end #event-arc-data2 -->';    
		}
			echo '
      <div class="event-arc-text">
        <h2 class="event-arc-title"><a href="' . get_permalink() . '">';
if (strlen($post->post_title) > 43) {
echo substr(the_title($before = '', $after = '', FALSE), 0, 43) . '...'; } else {
the_title();
}
        echo '</a></h2>
          <div class="event-arc-info2">';
            if($venue) {
                echo '<p class="event-arc-venue">' . $venue . '</p>';    
            }              
            if (get_post_meta($post->ID, 'event_allday', true) == 'yes'){            
                echo '<p class="event-arc-time">' . __('All Day', 'clubber') . '</p>';           
            }elseif ($tstart) {            
                echo '<p class="event-arc-time">' . $tstart . '';            
            }if ($tend) { 
                echo ' – ' . $tend . '</p>';
            }         
          echo '
                </div><!-- end #event-arc-info2 -->';   
             
	if (get_post_meta($post->ID, 'event_disable', true) == 'no') {
        if ($event_text) {   
            echo '
                        <div class="event-tickets2"><a href="' . $event_ticket . '" target="_blank">' . $event_text . '</a></div>';
        } else {  
            if (get_post_meta($post->ID, 'event_out', true) == 'yes') {
                echo '
                        <div class="event-cancel-out2"><p>' . __('Sold Out', 'clubber') . '</p></div>';
            } elseif (get_post_meta($post->ID, 'event_cancel', true) == 'yes') {
                echo '
                        <div class="event-cancel-out2"><p>' . __('Canceled', 'clubber') . '</p></div>';
            } elseif (get_post_meta($post->ID, 'event_free', true) == 'yes') {
                echo '
                        <div class="event-cancel-out2"><p>' . __('Free Entry', 'clubber') . '</p></div>';
            } else {
                echo '
                        <div class="event-tickets2"><a href="' . $event_ticket . '" target="_blank">' . __('Buy Tickets', 'clubber') . '</a></div>';
            }
        }
	}

        echo '
      </div><!-- end #event-arc-text -->
    </div><!-- end #event-archive -->';	
    		
	endwhile;

else :
echo '<h4>' . __('Sorry, no events coming up.', 'clubber') . '</h4>';
endif;
?>

  </div><!-- end .col-blog-archive -->
  <div class="col-blog-archive">
    <div class="event-past"><h3><?php _e('Past Events', 'clubber'); ?></h3></div>


<?php 
// Build a custom query to get posts from future dates.
$term     = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$query    = array(
    'post_type' => 'event',
    'orderby' => 'meta_value',
	'order' => 'desc',
	'posts_per_page' => 10,
	'meta_value' => strftime("%Y/%m/%d", time()- (60 * 60 * 24) ),
	'meta_key' => 'event_date_interval',
	'meta_compare' => '<',
    'taxonomy' => 'events',
	'term' => $term->slug
);
$wp_query = new WP_Query($query);
$results = $wp_query->post_count;
if ($results != ''):
    while ($wp_query->have_posts()):
        $wp_query->the_post();
        global $post;
 		setup_postdata($post); 	
		$results = $wp_query->post_count;
        $data_event     = get_post_meta($post->ID, 'event_date_interval', true);
		$data_finish    = get_post_meta($post->ID, 'event_date_interval_finish', true);
        $time           = strtotime($data_event);
		$time_finish    = strtotime($data_finish);
        $date_yy 		= date('Y', $time);
        $date_d  		= date('d', $time);
		$date_yy_finish = date('Y', $time_finish);
		$date_d_finish  = date('d', $time_finish);
		require('includes/language.php');
        $tstart         = get_post_meta($post->ID, 'event_tstart', true);
        $tend           = get_post_meta($post->ID, 'event_tend', true);
        $venue          = get_post_meta($post->ID, 'event_venue', true);
		$event_text     = get_post_meta($post->ID, "ev_text", true);
        $custom         = get_post_custom($post->ID);
        $event_ticket   = $custom["event_ticket"][0];
        $image_id       = get_post_thumbnail_id();
        $cover          = wp_get_attachment_image_src($image_id, 'event-cover-arc');	
        echo '
    <div class="event-archive2">';
		if ($data_finish != null) {
			echo '    
      <div class="event-arc-data2-finish">
        <div class="event-arc-day2-finish">' . $date_d . ' ' . $date_M . ' - ' . $date_d_finish . ' ' . $date_M_finish . '</div>
      </div><!-- end #event-arc-data2 -->';            
	  	} elseif ($data_event != null) {
			echo '
      <div class="event-arc-data2">
        <div class="event-arc-day2">' . $date_d . '</div>
        <div class="event-arc-month2">' . $date_M . '</div>
      </div><!-- end #event-arc-data2 -->';    
		}
			echo '
      <div class="event-arc-text">
        <h2 class="event-arc-title"><a href="' . get_permalink() . '">';
if (strlen($post->post_title) > 43) {
echo substr(the_title($before = '', $after = '', FALSE), 0, 43) . '...'; } else {
the_title();
}
        echo '</a></h2>
          <div class="event-arc-info2">';
            if($venue) {
                echo '<p class="event-arc-venue">' . $venue . '</p>';    
            }              
            if (get_post_meta($post->ID, 'event_allday', true) == 'yes'){            
                echo '<p class="event-arc-time">' . __('All Day', 'clubber') . '</p>';           
            }elseif ($tstart) {            
                echo '<p class="event-arc-time">' . $tstart . '';            
            }if ($tend) { 
                echo ' – ' . $tend . '</p>';
            }         
          echo '
                </div><!-- end #event-arc-info2 -->';   
             
	if (get_post_meta($post->ID, 'event_disable', true) == 'no') {
        if ($event_text) {   
            echo '
                        <div class="event-tickets2"><a href="' . $event_ticket . '" target="_blank">' . $event_text . '</a></div>';
        } else {  
            if (get_post_meta($post->ID, 'event_out', true) == 'yes') {
                echo '
                        <div class="event-cancel-out2"><p>' . __('Sold Out', 'clubber') . '</p></div>';
            } elseif (get_post_meta($post->ID, 'event_cancel', true) == 'yes') {
                echo '
                        <div class="event-cancel-out2"><p>' . __('Canceled', 'clubber') . '</p></div>';
            } elseif (get_post_meta($post->ID, 'event_free', true) == 'yes') {
                echo '
                        <div class="event-cancel-out2"><p>' . __('Free Entry', 'clubber') . '</p></div>';
            } else {
                echo '
                        <div class="event-tickets2"><a href="' . $event_ticket . '" target="_blank">' . __('Buy Tickets', 'clubber') . '</a></div>';
            }
        }
	}

        echo '
      </div><!-- end #event-arc-text -->
    </div><!-- end #event-archive -->';	
    		
	endwhile;

else :
echo '<h4>' . __('Sorry, no events past.', 'clubber') . '</h4>';
endif;
 ?>


  </div><!-- end .col-blog-archive -->
</div><!-- end .fixed-->  
</div><!-- end #content -->
	

<?php get_footer(); ?>