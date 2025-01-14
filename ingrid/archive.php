<?php
/*
	Template for displaying Archive pages.
*/

get_header(); 


print '<section id="page" class="wrapper">
';


	print '
		<header class="heading">	
			';				
				if ( is_day() ){
					print '<h1>'.__('DAILY ARCHIVES','ingrid').'</h1><h2>'.get_the_date().'</h2>';
				}elseif ( is_month() ){
					print '<h1>'.__('MONTHLY ARCHIVES','ingrid').'</h1><h2>'.strtoupper(get_the_date( _x( 'F Y', 'monthly archives date format', 'ingrid' ) )).'</h2>';
				}elseif ( is_year() ){
					print '<h1>'.__('YEARLY ARCHIVES','ingrid').'</h1><h2>'.get_the_date( _x( 'Y', 'yearly archives date format', 'ingrid' ) ).'</h2>';
				}else{
					print '<h1>'.__('ARCHIVES','ingrid').'</h1>';
				}
			print 
			''. strtoupper(sprintf( __('%s','ingrid'), single_cat_title( '', false ) )) .'</h2>			
		</header>	
		';
		

				if ( category_description() ){
					print '
					<article class="archive-meta">
						'.category_description().'
						<hr class="hr2" />
					</article>
					';
				}		


// check if page is full width or have sidebar -> check it at selected blog page.. if not set, use default widget area settings
	$blog_page_id = get_option('page_for_posts');
	$tp_pages_default_sb_widget_area = get_option('tp_pages_default_sb_widget_area');
	if(!empty($blog_page_id)){
		$curr_widget_area = get_post_meta($blog_page_id,'ub_widget_area',true);
		$GLOBALS['indexblog_id'] = $blog_page_id;
	}else{
		$curr_widget_area = '';
	}
	
	if($curr_widget_area != ''){		
		if($curr_widget_area != 'no-widget-area'){
			$GLOBALS['curr_widget_area'] = $curr_widget_area;
		}else{
			$curr_widget_area = '';
			$GLOBALS['curr_widget_area'] = '';
		}
	}elseif($tp_pages_default_sb_widget_area != ''){
		if($tp_pages_default_sb_widget_area != 'no-widget-area'){
			$curr_widget_area = $tp_pages_default_sb_widget_area;
			$GLOBALS['curr_widget_area'] = $tp_pages_default_sb_widget_area;
		}else{
			$curr_widget_area = '';
			$GLOBALS['curr_widget_area'] = '';
		}
	}


	
	//if no sidebar
	if($curr_widget_area == ''){
		print '
		<section id="full-width-content" class="bloglist">
		';	
		
		
	
				if ( have_posts() ){
					while ( have_posts() ) {
						the_post();

						get_template_part( 'content' );
					}
				}else{
					print '
					<article>
						<p><strong>'.__('There isn\'t any post in this category!','ingrid').'</strong></p>
					</article>';					
				}
				
				//pagination
						if(function_exists('wp_paginate')) {
							wp_paginate();		
						} 
						else{
							//display default next/prev links
							
							if($wp_query->max_num_pages > 1 ){								
								
								print '
								<div id="page_control">';
									next_posts_link('<div id="page_control-older">'.__('NEXT PAGE','ingrid').'</div>');
									previous_posts_link('<div id="page_control-newer">'.__('PREVIOUS PAGE ','ingrid').'</div>');
								print '
								</div>';
								
							}
						}					
				
	
		print '</section>';		
	
	}else{
	//if page has sidebar
		$tp_default_sidebar_position = get_option('tp_default_sidebar_position');
		if($tp_default_sidebar_position == 'left'){	
			//left sidebar
				get_sidebar();
				
				print '
				<section id="content" class="left-margin bloglist">
				';
				
				if ( have_posts() ){
					while ( have_posts() ) {
						the_post();

						get_template_part( 'content' );
					}
				}else{
					print '
					<article>
						<p><strong>'.__('There isn\'t any post in this category!','ingrid').'</strong></p>
					</article>';					
				}
		
					//pagination
						if(function_exists('wp_paginate')) {
							wp_paginate();		
						} 
						else{
							//display default next/prev links
							
							if($wp_query->max_num_pages > 1 ){								
								
								print '
								<div id="page_control">';
									next_posts_link('<div id="page_control-older">'.__('NEXT PAGE','ingrid').'</div>');
									previous_posts_link('<div id="page_control-newer">'.__('PREVIOUS PAGE ','ingrid').'</div>');
								print '
								</div>';
								
							}
						}	
		
				print '
				</section>
				';
		}else{
			//right sidebar
				print '
				<section id="content" class="bloglist">
				';
				
				
				if ( have_posts() ){
					while ( have_posts() ) {
						the_post();

						get_template_part( 'content' );
					}
				}else{
					print '
					<article>
						<p><strong>'.__('There isn\'t any post in this category!','ingrid').'</strong></p>
					</article>';					
				}
				

				//pagination
						if(function_exists('wp_paginate')) {
							wp_paginate();		
						} 
						else{
							//display default next/prev links
							
							if($wp_query->max_num_pages > 1 ){								
								
								print '
								<div id="page_control">';
									next_posts_link('<div id="page_control-older">'.__('NEXT PAGE','ingrid').'</div>');
									previous_posts_link('<div id="page_control-newer">'.__('PREVIOUS PAGE ','ingrid').'</div>');
								print '
								</div>';
								
							}
						}	
				
				print '
				</section>
				';

				get_sidebar();
		}
	}
	

print '
</section><!-- #page .wrapper -->
';	
	
get_footer(); 

?>