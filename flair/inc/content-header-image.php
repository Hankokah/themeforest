<?php  
	/**
	 * All variables in here are being brought from /page_builder_blocks/header_block.php
	 * This is a separate file so that you can override it easily from your child theme.
	 */
	if(!( isset($image) ))
		$image = false;
?>

<section id="home" class="single_image" style="background-image: url(<?php echo $image; ?>);">
	<div class="light_overlay">
	
		<?php include( locate_template('inc/content-header-titles.php') ); ?>
		
	</div>	
</section>