<?php
/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'category_post_widget' );

/* Function that registers our widget. */
function category_post_widget() {
	register_widget( 'category_posts' );
}

class category_posts extends WP_Widget {
	function category_posts() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'category_posts', 'description' => 'Displays the post image and excerpt from a selected category **Does not work on singlepost sidebar**'.'buler' );

		/* Create the widget. */
		parent::__construct( 'category_posts-widget', __('Buler- Premium Popular Posts', 'buler'), $widget_ops, '' );
	}

	function widget( $args, $instance ) {
		global $sitepress, $pmc_data;
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		// to sure the number of posts displayed isn't negative or more than 10
		if ( !$number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 10 )
			$number = 10;

		//the query that will get post from a specific category. 
		//Wr slug the category because you actualy need the slug and not the name
		$pc = new WP_Query("orderby=comment_count&showposts=".$number."&nopaging=0&post_status=publish&ignore_sticky_posts=1&post_type=post");
		
		//display the posts title as a link
		if ($pc->have_posts()) : 
		
			echo $before_widget; 
		
				if ( $title ) echo $before_title . $title . $after_title; 
		?>
		
		
		<?php  while ($pc->have_posts()) : $pc->the_post();  ?>
				
			
				
	
		<div class="widgett">		
    <?php
			$image=$comment_0=$comment_1=$comment_2= '';
			if ( has_post_thumbnail() ){
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'widget', false);
				$image = $image[0];}	
		
		
	?>			<div class="imgholder">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
						<?php if (has_post_thumbnail( get_the_ID() )) echo '<img src = '.$image.' alt = "'.esc_attr(get_the_title() ? get_the_title() : get_the_ID()).'"  > ' ;?>	
					</a>
				</div>
				<div class="wttitle"><h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php $title = the_title('','',FALSE);  echo substr($title, 0, 40);  ?></a></h4></div>
		</div>	
			
		<?php endwhile; ?>
	
		

		
		
	<?php
			wp_reset_query();  // Restore global post data stomped by the_post().
			endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Popular Posts', 'number' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'buler') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'buler') ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
			<br /><small>(at most 10)</small>
		</p>

		<?php
	}

	function slug($string)
	{
		$slug = trim($string);
		$slug= preg_replace('/[^a-zA-Z0-9 -]/','', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
		$slug= str_replace(' ','-', $slug); // replace spaces by dashes
		$slug= strtolower($slug); // make it lowercase
		return $slug;
	}

}

?>
