<?php if ( !$is_compact ) echo VP_View::instance()->load( 'control/template_control_head', $head_info ); ?>

<input type="hidden" name="<?php echo esc_attr( $name ) ?>" class="vp-input input-large" value="<?php echo esc_attr( $value ); ?>" />
<p><?php echo esc_attr( $value ); ?></p>
<?php
if ( !$is_compact )
	echo VP_View::instance()->load( 'control/template_control_foot' );?>