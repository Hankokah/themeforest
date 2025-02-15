<?php

/**
 * BuddyPress - Groups Directory
 *
 * @package BuddyPress
 * @subpackage bp-default
 */
 
//get theme options
global $oswc_bp;

//set theme options
$oswc_bp_sidebar_unique = $oswc_bp['bp_sidebar_unique'];
$oswc_bp_groups_sidebar_unique = $oswc_bp['bp_groups_sidebar_unique'];

//setup variables
$override = get_post_meta($post->ID, "Hide Trending", $single = true);
if($override!="" && $override!="null") {
	$oswc_trending_hide=$override;
	if($oswc_trending_hide=="false") {
		$oswc_trending_hide=false;	
	} else {
		$oswc_trending_hide=true;
	}
}
$sidebar="Default Sidebar";
if($oswc_bp_sidebar_unique) { $sidebar="BuddyPress Default Sidebar"; }
if($oswc_bp_groups_sidebar_unique) { $sidebar="BuddyPress Groups Sidebar"; }
if ( is_page_template('template-full-width.php') ) {
	$displaysidebar=false;
}else{
	$displaysidebar=true;
}

get_header( 'buddypress' ); ?>

<?php do_action( 'bp_before_directory_groups_page' ); ?>

<div class="main-content<?php if($displaysidebar) { ?>-left<?php } ?>">

	<div class="page-content" id="content">
        
		<?php do_action( 'bp_before_directory_groups' ); ?>
    
        <form action="" method="post" id="groups-directory-form" class="dir-form">
    
            <h3><?php _e( 'Groups Directory', 'buddypress' ); ?><?php if ( is_user_logged_in() && bp_user_can_create_groups() ) : ?> &nbsp;<a class="button" href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/create' ); ?>"><?php _e( 'Create a Group', 'buddypress' ); ?></a><?php endif; ?></h3>
    
            <?php do_action( 'bp_before_directory_groups_content' ); ?>
    
            <div id="group-dir-search" class="dir-search" role="search">
    
                <?php bp_directory_groups_search_form(); ?>
    
            </div><!-- #group-dir-search -->
    
            <?php do_action( 'template_notices' ); ?>
    
            <div class="item-list-tabs" role="navigation">
                <ul>
                    <li class="selected" id="groups-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() ); ?>"><?php printf( __( 'All Groups <span>%s</span>', 'buddypress' ), bp_get_total_group_count() ); ?></a></li>
    
                    <?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
    
                        <li id="groups-personal"><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups' ); ?>"><?php printf( __( 'My Groups <span>%s</span>', 'buddypress' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>
    
                    <?php endif; ?>
    
                    <?php do_action( 'bp_groups_directory_group_filter' ); ?>
    
                </ul>
            </div><!-- .item-list-tabs -->
    
            <div class="item-list-tabs" id="subnav" role="navigation">
                <ul>
    
                    <?php do_action( 'bp_groups_directory_group_types' ); ?>
    
                    <li id="groups-order-select" class="last filter">
    
                        <label for="groups-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
                        <select id="groups-order-by">
                            <option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
                            <option value="popular"><?php _e( 'Most Members', 'buddypress' ); ?></option>
                            <option value="newest"><?php _e( 'Newly Created', 'buddypress' ); ?></option>
                            <option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
    
                            <?php do_action( 'bp_groups_directory_order_options' ); ?>
    
                        </select>
                    </li>
                </ul>
            </div>
    
            <div id="groups-dir-list" class="groups dir-list">
    
                <?php locate_template( array( 'groups/groups-loop.php' ), true ); ?>
    
            </div><!-- #groups-dir-list -->
    
            <?php do_action( 'bp_directory_groups_content' ); ?>
    
            <?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>
    
            <?php do_action( 'bp_after_directory_groups_content' ); ?>
    
        </form><!-- #groups-directory-form -->
    
        <?php do_action( 'bp_after_directory_groups' ); ?>
        
        <?php do_action( 'bp_after_directory_groups_page' ); ?>
        
	</div>
    
    <?php if(!$oswc_trending_hide) { ?>
    
    	<br class="clearer" />
    
    	<?php oswc_get_template_part('trending'); // show trending ?>
        
    <?php } ?>
	
</div>

<?php if($displaysidebar) { ?>
    <div class="sidebar">
    
        <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar($sidebar) ) : else : ?>
    
            <div class="widget-wrapper">
            
                <div class="widget">
        
                    <div class="section-wrapper"><div class="section">
                    
                        <?php _e(' Made Magazine ', 'made' ); ?>
                    
                    </div></div> 
                    
                    <div class="textwidget">  
                                                  
                        <p><?php _e( 'This is a widget panel. To remove this text, login to your WordPress admin panel and go to Appearance >> Widgets, and drag &amp; drop a widget into the corresponding widget panel.', 'made' ); ?></p>
                        
                    </div>
                                
                </div>
            
            </div>
        
        <?php endif; ?>
        
    </div>
<?php } ?>

<br class="clearer" />

<?php get_footer( 'buddypress' ); ?>

