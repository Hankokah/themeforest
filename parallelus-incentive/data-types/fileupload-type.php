<?php
class Fileupload_type extends Data_Type {

	public $type = 'fileupload-type';
	public static $type_slug = 'fileupload-type';
	public $label = 'Fileupload';

	public function render_content( $vals = null ) {

		do_action( self::$type_slug . '_before_render_content', $this );

		if ( $vals != null ) {
			$this->field = (object)$vals;
			extract( $vals );
		}

		$value = ( $vals != null ) ? $this->field->saved : $this->get_value();
		$section = ( isset( $this->page->section ) && $this->page->section != '' ) ? 'data-section="'.$this->page->section.'"' : '';
		
		$input_value = ( $vals != null ) ? $this->field->saved : $this->get_value();
		if(!is_string($input_value) && !is_numeric($input_value))
		{
			if(is_array($input_value) && isset($input_value[0]))
				$input_value = $input_value[0];
			else
				$input_value = "";
		}		
?>
		<legend class="customize-control-title"><span><?php echo stripslashes( $this->field->title ) ?></span></legend>
		<input id="upload_image-<?php echo $this->field->alias; ?>" class="custom-data-type" <?php echo $section; ?> data-type="fileupload-type" type="text" size="36" name="<?php echo $this->field->alias; ?>" value="<?php echo @stripslashes( $input_value ); ?>" <?php $this->link(); ?> />

		<span class="field_label">
			<button id="upload_image_button-<?php echo $this->field->alias; ?>" class="button"><?php _e( 'Select File', 'framework' ); ?></button>
		</span>
		<?php
		if ( ! did_action( 'wp_enqueue_media' ) )
    		wp_enqueue_media();    	
		?>

		<script type="text/javascript">
			var file_frame;
			var current_button;
			var attached_input;

			(function($){


				$(function(){
					$("#upload_image_button-<?php echo $this->field->alias; ?>").click(function(e) {
						e.preventDefault();
						e.stopPropagation();
						current_button = $(this);
						attached_input = current_button.parent().prev();

						if ( file_frame ) {
							file_frame.open();
							return;
						}

						file_frame = wp.media.frames.file_frame = wp.media({
							multiple: false
						});

						file_frame.on( 'select', function() {
							attachment = file_frame.state().get('selection').first().toJSON();
							attached_input.val(attachment.url);
                                                        
							if ( wp.customize ) {
								var api = wp.customize;
								var mysetting = api.instance(attached_input.attr('name'));
								api.instance(attached_input.attr('name')).set(attachment.url);
							}

							var e = jQuery.Event("keypress");
							e.which = 13; //choose the one you want
							e.keyCode = 13;
							attached_input.trigger(e);
						});

						file_frame.open();
					});
				});
			})(jQuery);
		</script><?php

		do_action( self::$type_slug . '_after_render_content', $this );
	}

	public static function render_settings() { ?>

		<script id="fileupload-type" type="text/x-jquery-tmpl">

			<?php do_action( self::$type_slug . '_before_render_settings' ); ?>

		    <div class="settings-container">
		        <label class="settings-title">
		            Values:
		            <br><span class="settings-title-caption"></span>
		        </label>
		        <div class="settings-in">
		            <input name="values" value="${values}" class="settings-input" type="text">

		            <br><span class="settings-field-caption"></span>

		        </div>

		    </div><div class="clear"></div>

		    <div class="settings-container">
		        <label class="settings-title">
		            Required:
		            <br><span class="settings-title-caption"></span>
		        </label>
		        <div class="settings-in">

		            <label>
		                {{if required == 'Yes'}}
		                <input data-set="required" name="required" value="Yes" checked="true" type="checkbox">
		                {{else}}
		                <input data-set="required" name="required" value="Yes" type="checkbox">
		                {{/if}}
		                Yes
		            </label>

		            <br><span class="settings-field-caption">Is this a required field.</span><br>

		            <input data-set="requiredMessage" name="requiredMessage" value="${requiredMessage}" type="text">

		            <br><span class="settings-field-caption">Optional. Enter a custom error message.</span>

		        </div>

		    </div><div class="clear"></div>

		    <?php do_action( self::$type_slug . '_after_render_settings' ); ?>

		</script>

	<?php }

	public function get_value() {

		$value = parent::get_value();

		if ( is_array( $value ) ) {
			return ( isset( $this->field->values ) ) ? $this->field->values : '';
		} else {
			return $value;
		}

	}

	public static function data_type_register() { ?>

		<script type="text/javascript">
			jQuery(document).ready(function ($) {

		        builder.registerDataType({
		            name: 'File upload',
		            alias: '<?php echo self::$type_slug ?>',
                    settingsFormTemplateID: '<?php echo self::$type_slug ?>'
		        });

			});
		</script>

	<?php }
}

?>
