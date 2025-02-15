<?php
class home_large_3main_post_below_list extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
	    'name' => esc_attr__('3 main post with below post', 'nanomag'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('home_large_3main_post_below_list', $block_options);
	}
	
	
	//create form
	function form($instance) {
        $titles = isset($instance['titles']) ? esc_attr($instance['titles']) : 'Home 3 main post with below post';
        $number_show = isset($instance['number_show']) ? absint($instance['number_show']) : 7;
		$number_offset = isset($instance['number_offset']) ? absint($instance['number_offset']) : 0;
    $css_class_builder = isset($instance['css_class_builder']) ? esc_attr($instance['css_class_builder']) : 'color-9';
		?>
        <p><label for="<?php echo esc_attr($this->get_field_id('titles')); ?>"><?php esc_attr_e('Title:', 'nanomag'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('titles')); ?>" name="<?php echo esc_attr($this->get_field_name('titles')); ?>" type="text" value="<?php echo esc_attr($titles); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('css_class_builder')); ?>"><?php esc_attr_e('CSS class','nanomag'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('css_class_builder')); ?>" name="<?php echo esc_attr($this->get_field_name('css_class_builder')); ?>" type="text" value="<?php echo esc_attr($css_class_builder); ?>" /></p>
        
        <p><label for="<?php echo esc_attr($this->get_field_id('number_show')); ?>"><?php esc_attr_e('Number of posts to show:', 'nanomag'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number_show')); ?>" name="<?php echo esc_attr($this->get_field_name('number_show')); ?>" type="text" value="<?php echo esc_attr($number_show); ?>" size="3" /></p>
            
             <p><label for="<?php echo esc_attr($this->get_field_id('number_offset')); ?>"><?php esc_attr_e('Offset posts:', 'nanomag'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('number_offset')); ?>" type="text" value="<?php echo esc_attr($number_offset); ?>" size="3" /></p>    
 
            <label for="<?php echo esc_attr($this->get_field_id('cats')); ?>"><?php esc_attr_e('Choose your category:', 'nanomag'); ?> 

                <?php
                $categories = get_categories('hide_empty=0');
                echo "<br/>";
                foreach ($categories as $cat) {
                    $option = '<input type="checkbox" id="' . $this->get_field_id('cats') . '[]" name="' . $this->get_field_name('cats') . '[]"';
                    if (isset($instance['cats'])) {
                        foreach ($instance['cats'] as $cats) {
                            if ($cats == $cat->term_id) {
                                $option = $option . ' checked="checked"';
                            }
                        }
                    }
                    $option .= ' value="' . $cat->term_id . '" />';
                    $option .= '&nbsp;';
                    $option .= $cat->cat_name;
                    $option .= '<br />';
                    echo $option;
                }
                ?>
            </label>	
		<?php
		
	}
		
	
	//create block
	function block($instance) {
	extract($instance);
        $titles = apply_filters('widget_title', empty($instance['titles']) ? 'Recent Posts' : $instance['titles'], $instance, $this->id_base);
		
      	if (isset($instance['number_offset'])==''){$number_offset = 0;}else{$number_offset = absint($instance['number_offset']);}
        if (!isset($instance["cats"])){$cats = '';}

        // array to call recent posts.

        $jellywp_args = array(
            'showposts' => $number_show,
            'category__in' => $cats,
			'ignore_sticky_posts' => 1,
			'offset' => $number_offset
        );
	
        $jellywp_widget = null;
        $jellywp_widget = new WP_Query($jellywp_args);
        ?>
        <div class="widget post_list_medium_widget builder_belowpost <?php echo esc_attr($instance['css_class_builder']);?>">
        <?php if (!empty($instance['titles'])) {?><div class="widget-title"><h2><?php echo esc_attr($instance["titles"]);?></h2></div><?php }?>
		<div class="widget_container">
        <div class="post_list_medium">
        <?php
		$i = 0;
        while ($jellywp_widget->have_posts()) {
           $i++;
		   $jellywp_widget->the_post();
       //get all post categories
            $categories = get_the_category(get_the_ID());
            $post_id = get_the_ID();
		       	if ($i == 1 || $i == 2 || $i == 3) {			
                ?>   
	


    <div class="feature-three-column-home <?php if ($i == 1) {echo "first-child-grid ";}if(!of_get_option('disable_css_animation')==1){echo esc_attr("appear_animation");}?>">
                    
                <div class="image_post feature-item">
                   <a  href="<?php the_permalink(); ?>" class="feature-link" title="<?php the_title_attribute(); ?>">              
<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium-feature');}
else{echo '<img class="no_feature_img" alt="" src="'.get_template_directory_uri().'/img/feature_img/medium-feature.jpg'.'">';} ?>
<?php echo jelly_post_type(); ?>
</a>
<?php echo jelly_total_score_post_front_small_circle(get_the_ID());?>
                     </div>

<div class="wrap_box_style_main feature-custom-below main_post_2col_style">
  <div class="meta_holder">
<?php  if(of_get_option('disable_post_category') !=1){
          if ($categories) {
            echo '<span class="meta-category-small">';
            foreach( $categories as $tag) {
              $tag_link = get_category_link($tag->term_id);
              $titleColor = jelly_categorys_title_color($tag->term_id, "category", false);
             echo '<a class="post-category-color-text" style="color:'.esc_attr($titleColor).'" href="'.esc_url($tag_link).'">'.$tag->name.'</a>';          
            }
            echo "</span>";
            }
       }?>
<?php echo jelly_post_like_meta(get_the_ID());?>
</div>
 <h3 class="image-post-title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h3>      
  <?php echo jelly_post_meta(get_the_ID()); ?>  
 <?php echo jelly_post_meta_footer(get_the_ID()); ?>
   </div>
    </div>

   
<?php   if ($i == 3) {  ?>
     <div class="clear margin-buttons"></div>
      <ul class="feature-post-list large_list_bellow 3_main_bellow_post_list">   
         <?php }}else{?>        			
			<li class="<?php if($i%2){echo esc_attr("large_list_right ");}else{echo esc_attr("large_list_left ");} if(!of_get_option('disable_css_animation')==1){echo esc_attr("appear_animation");}?>">
<a  href="<?php the_permalink(); ?>" class="feature-image-link image_post" title="<?php the_title_attribute(); ?>">              
<?php if ( has_post_thumbnail()) {the_post_thumbnail('small-feature');}
else{echo '<img class="no_feature_img" alt="" src="'.get_template_directory_uri().'/img/feature_img/small-feature.jpg'.'">';} ?>
<?php echo jelly_post_type(); ?>
</a>
<div class="item-details">
      <?php  if(of_get_option('disable_post_category') !=1){
          if ($categories) {
            echo '<span class="meta-category-small">';
            foreach( $categories as $tag) {
              $tag_link = get_category_link($tag->term_id);
              $titleColor = jelly_categorys_title_color($tag->term_id, "category", false);
             echo '<a class="post-category-color-text" style="color:'.esc_attr($titleColor).'" href="'.esc_url($tag_link).'">'.$tag->name.'</a>';          
            }
            echo "</span>";
            }
       }?>
<?php echo jelly_total_score_post_front_small_list(get_the_ID());?>

   <h3 class="feature-post-title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h3>
<?php echo jelly_post_meta(get_the_ID()); ?>
   </div>
   <div class="clearfix"></div>
   </li>
				 <?php if($i==5 || $i==7 || $i==9 || $i==11 || $i==13 || $i==15 || $i==17 || $i==19){echo '<div class="clearfix"></div>';}?>
				<?php }}?>
                
         </ul>       
              
                
      </div>
        </div>
        </div>
     
        <?php
        wp_reset_query();	
		
	}
	
	    function update($new_instance, $old_instance) {
        return $new_instance;
    }

	
}
