<?php if ( !$is_compact ) echo VP_View::instance()->load( 'control/template_control_head', $head_info ); ?>

<input class="vp-input-language" type="text" readonly id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" />
<div class="buttons-language">
    <input id="language_upload" class="" type="button" value="<?php esc_html_e( 'Choose File', 'crazyblog' ); ?>" />
</div>
<div id="language_uploader_output"></div>
<?php if ( !$is_compact ) echo VP_View::instance()->load( 'control/template_control_foot' ); ?>
