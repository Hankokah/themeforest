<?php

/**
 * BuddyPress Member Settings
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

//get theme options
global $oswc_bp;

//set theme options
$oswc_bp_sidebar_unique = $oswc_bp['bp_sidebar_unique'];
$oswc_bp_members_sidebar_unique = $oswc_bp['bp_members_sidebar_unique'];

//setup variables
$sidebar="Default Sidebar";
if($oswc_bp_sidebar_unique) { $sidebar="BuddyPress Default Sidebar"; }
if($oswc_bp_members_sidebar_unique) { $sidebar="BuddyPress Members Sidebar"; } 

get_header( 'buddypress' ); ?>

<div class="main-content-left">

	<div class="page-content" id="content">
    
		<?php do_action( 'bp_before_member_settings_template' ); ?>

        <div id="item-header">

            <?php locate_template( array( 'members/single/member-header.php' ), true ); ?>

        </div><!-- #item-header -->

        <div id="item-nav">
            <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                <ul>

                    <?php bp_get_displayed_user_nav(); ?>

                    <?php do_action( 'bp_member_options_nav' ); ?>

                </ul>
            </div>
        </div><!-- #item-nav -->

        <div id="item-body" role="main">

            <?php do_action( 'bp_before_member_body' ); ?>

            <div class="item-list-tabs no-ajax" id="subnav">
                <ul>

                    <?php bp_get_options_nav(); ?>

                    <?php do_action( 'bp_member_plugin_options_nav' ); ?>

                </ul>
            </div><!-- .item-list-tabs -->

            <h3><?php _e( 'General Settings', 'buddypress' ); ?></h3>

            <?php do_action( 'bp_template_content' ); ?>

            <form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

                <?php if ( !is_super_admin() ) : ?>

                    <label for="pwd"><?php _e( 'Current Password <span>(required to update email or change current password)</span>', 'buddypress' ); ?></label>
                    <input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small" /> &nbsp;<a href="<?php echo esc_url(site_url( add_query_arg( array( 'action' => 'lostpassword' ), 'wp-login.php' ), 'login' )); ?>" title="<?php _e( 'Password Lost and Found', 'buddypress' ); ?>"><?php _e( 'Lost your password?', 'buddypress' ); ?></a>

                <?php endif; ?>

                <label for="email"><?php _e( 'Account Email', 'buddypress' ); ?></label>
                <input type="text" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" />

                <label for="pass1"><?php _e( 'Change Password <span>(leave blank for no change)</span>', 'buddypress' ); ?></label>
                <input type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small" /> &nbsp;<?php _e( 'New Password', 'buddypress' ); ?><br />
                <input type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small" /> &nbsp;<?php _e( 'Repeat New Password', 'buddypress' ); ?>

                <?php do_action( 'bp_core_general_settings_before_submit' ); ?>

                <div class="submit">
                    <input type="submit" name="submit" value="<?php _e( 'Save Changes', 'buddypress' ); ?>" id="submit" class="auto" />
                </div>

                <?php do_action( 'bp_core_general_settings_after_submit' ); ?>

                <?php wp_nonce_field( 'bp_settings_general' ); ?>

            </form>

            <?php do_action( 'bp_after_member_body' ); ?>

        </div><!-- #item-body -->

        <?php do_action( 'bp_after_member_settings_template' ); ?>

	</div>
	
</div>

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

<br class="clearer" />

<?php get_footer( 'buddypress' ); ?>