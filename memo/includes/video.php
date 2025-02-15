<!--BEGIN .post-header -->
<div class="post-header">
    <?php 
    $embed = get_post_meta(get_the_ID(), 'tz_video_embed', TRUE); 
    if($embed == '') :
        tz_video($post->ID);
        $height = get_post_meta($post->ID, 'tz_video_height', TRUE);
    ?>
    
    <style type="text/css">
		#jquery_jplayer_<?php echo $post->ID; ?> { height: <?php echo $height; ?>px; }
		#jquery_jplayer_<?php echo $post->ID; ?> div.jp-jplayer-video img {
			height: <?php echo $height; ?>px;
		}
	</style>
    
    <div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer jp-jplayer-video"></div>
    
    <div class="jp-video-container">
        <div class="jp-video">
            <div class="jp-type-single">
                <div id="jp_interface_<?php the_ID(); ?>" class="jp-interface">
                    <ul class="jp-controls">
                    	<li><div class="seperator-first"></div></li>
                        <li><div class="seperator-second"></div></li>
                        <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                        <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                        <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                        <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                    </ul>
                    <div class="jp-progress-container">
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="jp-volume-bar-container">
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    
    <?php echo stripslashes(htmlspecialchars_decode($embed)); ?>
    
    <?php endif; ?>
    <span class="hanger-left"></span>
	<span class="hanger-right"></span>
<!--END .post-header -->
</div>

<!--BEGIN .entry-header-->
<div class="entry-header">

<?php if( is_singular() ) : ?>
	<h1 class="entry-title"><?php the_title(); ?><?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?></h1>
<?php else : ?>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a><?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?></h2>
<?php endif; ?>

<!--END entry-header -->
</div>

<!--BEGIN .entry-content -->
<div class="entry-content clearfix">
    <?php the_content(__('Read more...', 'framework')); ?>
<!--END .entry-content -->
</div>

<?php get_template_part('includes/post-meta'); ?>