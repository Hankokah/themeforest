<?php
/**
 * BuddyPress - Groups Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the group home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_group_home_content' ); ?>

	<div id="item-body">

		<?php

		/**
		 * Fires before the display of the group home body.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_group_body' );

		/**
		 * Does this next bit look familiar? If not, go check out WordPress's
		 * /wp-includes/template-loader.php file.
		 *
		 * @todo A real template hierarchy? Gasp!
		 */

			// Looking at home location
			if ( bp_is_group_home() ) :

				if ( bp_group_is_visible() ) {

					// Load appropriate front template
					bp_groups_front_template_part();

				} else {

					/**
					 * Fires before the display of the group status message.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_before_group_status_message' ); ?>

					<div id="message" class="info">
						<p><?php bp_group_status_message(); ?></p>
					</div>

					<?php

					/**
					 * Fires after the display of the group status message.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_after_group_status_message' );

				}

			// Not looking at home
			else :

				// Group Admin
				if     ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin'        );

				// Group Activity
				elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

				// Group Members
				elseif ( bp_is_group_members()    ) : bp_groups_members_template_part();

				// Group Invitations
				elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

				// Old group forums
				elseif ( bp_is_group_forum()      ) : bp_get_template_part( 'groups/single/forum'        );

				// Membership request
				elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

				// Anything else (plugins mostly)
				else                                : bp_get_template_part( 'groups/single/plugins'      );

				endif;

			endif;

		/**
		 * Fires after the display of the group home body.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_group_body' ); ?>

	</div><!-- #item-body -->

	<?php

	/**
	 * Fires after the display of the group home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_group_home_content' ); ?>

</div><!-- #buddypress -->
