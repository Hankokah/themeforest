<?php
class Blog_Widget extends WP_Widget {
    /*--------------------------------------------------*/
    /* CONSTRUCT THE WIDGET
    /*--------------------------------------------------*/
    function Blog_Widget() {
        /* Widget name and description */
        $widget_opts = array(
            'classname' => 'blog_widget',
            'description' => __('Recent posts on blog your site.', 'clubber')
        );
        parent::__construct('blog-widget', esc_html__('CLUBBER - Recent Posts', 'clubber'), $widget_opts);
    }
    /*--------------------------------------------------*/
    /* DISPLAY THE WIDGET
    /*--------------------------------------------------*/
    /* outputs the content of the widget
     * @args --> The array of form elements*/
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title  = apply_filters('widget_title', $instance['title']);
        $number = $instance['number'];
        /* before widget */
        echo $before_widget;
        /* display title */
        if ($title)
            echo $before_title . $title . $after_title;
        /* display the widget */
?>
		
	<?php
        global $post;
        $query = new WP_Query();
        $query->query('posts_per_page=' . $number);
        echo '
    <div class="widgets-col">
      <div class="blog-w">                                        
        <ul>';
        while ($query->have_posts()):
            $query->the_post();
?>
          <li>
            <?php if (has_post_thumbnail()) { echo 
            '' . the_post_thumbnail(array( 60, 60 )) . '';
            } else {
                echo '
            <img src="' . get_template_directory_uri() . '/images/no-featured/blog-widget.png" alt="no image" />';
            }
?>
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php if (strlen($post->post_title) > 50) {
echo substr(the_title($before = '', $after = '', FALSE), 0, 48) . '...'; } else {
the_title();
} ?></a>
            <div class="blog-w-data"><?php echo get_the_time('F jS, Y'); ?></div>
          </li>	
<?php
        endwhile;
        echo '
        </ul>
      </div><!-- end .blog-w-->	
    </div><!-- .event-widgets-col-->';
        wp_reset_query();
?>

		<?php
        /* after widget */
        echo $after_widget;
    }
    /*--------------------------------------------------*/
    /* UPDATE THE WIDGET
    /*--------------------------------------------------*/
    function update($new_instance, $old_instance) {
        $instance           = $old_instance;
        $instance['title']  = strip_tags($new_instance['title']);
        $instance['number'] = strip_tags($new_instance['number']);
        return $instance;
    }
    /*--------------------------------------------------*/
    /* WIDGET ADMIN FORM
    /*--------------------------------------------------*/
    /* @instance	The array of keys and values for the widget. */
    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
            'title' => 'Recent Posts',
            'number' => 3
        ));
        // Display the admin form
?>
        <p>
		<label for="<?php
        echo $this->get_field_id('title');
?>"><?php
        _e('Title:', 'clubber');
?></label>
		<input type="text" class="widefat" id="<?php
        echo $this->get_field_id('title');
?>" name="<?php
        echo $this->get_field_name('title');
?>" value="<?php
        echo $instance['title'];
?>" />
	</p>
		
	<p>
		<label for="<?php
        echo $this->get_field_id('number');
?>"><?php
        _e('Posts Number:', 'clubber');
?></label>
		<input type="text" class="widefat" id="<?php
        echo $this->get_field_id('number');
?>" name="<?php
        echo $this->get_field_name('number');
?>" value="<?php
        echo $instance['number'];
?>" />
	</p>
	<?php
    } // end form
} // end class
add_action('widgets_init', create_function('', 'register_widget("Blog_Widget");'));
?>