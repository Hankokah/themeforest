<?php 
	/*
	Template Name: Archives
	*/

	global $avia_config, $more;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */	
	 get_header();
 		
	?>


		<!-- ####### MAIN CONTAINER ####### -->
		<div id='main'>
		
			<div class='template-archives'>	
				
				<span class='entry-border-overflow entry-border-overflow-first extralight-border'></span>
				
				<div class='content six units alpha offset-by-one'>
				
				
				
				<div class="entry-content">	
				
					<div class='post-entry'>
					<?php echo "<h1>".get_the_title(avia_get_the_id())."</h1>"; ?>
					<?php 
					//display the actual post content
					the_post();
					the_content();
					
					
					/*
					* Display the latest 20 blog posts
					*/
					
					
					query_posts(array('posts_per_page'=>20));
	
					// check if we got posts to display:
					if (have_posts()) :
					
					echo "<h3>" . __('The 20 latest Blog Posts','avia_framework') . "</h3>";
					echo "<ul>";
						while (have_posts()) : the_post();
						
			        	echo "<li><a href='".get_permalink()."' rel='bookmark' title='". __('Permanent Link:','avia_framework')." ".get_the_title()."'>".get_the_title()."</a></li>";
						
						endwhile;
					echo "</ul>";
					endif;
					
					
					
					/*
					* Display the latest 20 portfolio posts
					*/
					
					
					query_posts(array('posts_per_page'=>8, 'post_type'=>'portfolio'));
	
					// check if we got posts to display:
					if (have_posts()) :
					echo avia_advanced_hr(false);	
					
					
					$columns = 4;
					$rel_class = "one_fourth";
					$slidecount = 0;
					$postcount = ($columns * 1);
	  				$count = 1;
		     		$output = "";
		     		
		        	$output .= "<div class ='latest-portfolio-archive'>";
		        	$output .= "<h3>" . __('The 8 latest Portfolio Entries','avia_framework') . "</h3>";
		     		$output .= "<div class=' autoslide_false'>";
		 	 	
		     		while (have_posts()) : the_post(); 
		     			
	
		     			$slidecount ++;
		     			
		     			if($count == 1)
		     			{
		     				$output .= "<div class='single_slide single_slide_nr_$slidecount'>";
		     			}
		     			
		     			
		     			$image = "<span class='related_posts_default_image'></span>";
			 			$slides = avia_post_meta(get_the_ID(), 'slideshow', true);
			 			
			 			//check if a preview image is set
			 			if( $slides != "" && !empty( $slides[0]['slideshow_image']) )
			 			{	
			 				//check for image or video
			 				if(is_numeric($slides[0]['slideshow_image']))
			 				{
			 					$image = avia_image_by_id($slides[0]['slideshow_image'], 'portfolio_fixed', 'image');
			 				}
			 				else
			 				{
			 					$image = "<span class='related_posts_default_image related_posts_video'></span>";
			 				}
			 			   
			 			}
		     			
		     			
		     			$output .= "<div class='relThumb relThumb".$count." ".$rel_class."'>\n";
			 			$output .= "<a href='".get_permalink()."' class='relThumWrap noLightbox'>\n";
		     			$output .= "<span class='related_image_wrap'>";
			 			$output .= $image;
			 			$output .= "</span>\n";
			 			$output .= "<span class='relThumbTitle'>\n";
			 			$output .= "<strong class='relThumbHeading'>".avia_backend_truncate(get_the_title(), 50)."</strong>\n";
			 			$output .= "</span>\n</a>";
			 			$output .= "</div><!-- end .relThumb -->\n";
		     			
		     			$count++;
		     			
		     			if($count == $columns+1)
		     			{
		     				$output .= "</div>";
		     				$count = 1;
		     			}
		     			
		     		endwhile; 
		 	 		
		 	 		if($count != 1) $output .= "</div>";
		 	 		
		     		$output .= "</div></div>";
		     		echo $output;
						
					endif;
					
					
					
					
					/*
					* Display pages, categories and month archives
					*/
					
					
					echo avia_advanced_hr(false);
					echo "<div class='one_half first archive_list'>";
					echo "<h3>" . __('Available Pages','avia_framework') . "</h3>";
					echo "<ul>";
					wp_list_pages('title_li=&depth=-1' );
					echo "</ul>";
					echo "</div>";
					
					echo "<div class='one_half archive_list'>";
					echo "<h3>" . __('Archives by Month:','avia_framework') . "</h3>";
					echo "<ul>";
					wp_get_archives('type=monthly');
					echo "</ul>";
					echo "</div>";
	
					 ?>	
					 
									
					</div>	
				
					</div>
				<!--end content-->
				</div>
				
				
			</div><!--end container-->

	</div>
	<!-- ####### END MAIN CONTAINER ####### -->
</div>
<?php 

	//get the sidebar
	$avia_config['currently_viewing'] = 'page';
	get_sidebar();
				
?>
</div>	

<?php get_footer(); ?>