<?php

/*
*  ACF Flexible Content Field Class
*
*  All the logic for this field type
*
*  @class 		acf_field_flexible_content
*  @extends		acf_field
*  @package		ACF
*  @subpackage	Fields
*/

if( ! class_exists('acf_field_flexible_content') ) :

class acf_field_flexible_content extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// vars
		$this->name = 'flexible_content';
		$this->label = __("Flexible Content",'acf');
		$this->category = 'layout';
		$this->defaults = array(
			'layouts'		=> array(),
			'min'			=> '',
			'max'			=> '',
			'button_label'	=> __("Add Row",'acf'),
		);
		$this->l10n = array(
			'layout' 		=> __("layout", 'acf'),
			'layouts'		=> __("layouts", 'acf'),
			'remove'		=> __("remove {layout}?", 'acf'),
			'min'			=> __("This field requires at least {min} {identifier}",'acf'),
			'max'			=> __("This field has a limit of {max} {identifier}",'acf'),
			'min_layout'	=> __("This field requires at least {min} {label} {identifier}",'acf'),
			'max_layout'	=> __("Maximum {label} limit reached ({max} {identifier})",'acf'),
			'available'		=> __("{available} {label} {identifier} available (max {max})",'acf'),
			'required'		=> __("{required} {label} {identifier} required (min {min})",'acf'),
		);		
		
		
		// do not delete!
    	parent::__construct();
		
	}
	
	
	/*
	*  get_valid_layout
	*
	*  This function will fill in the missing keys to create a valid layout
	*
	*  @type	function
	*  @date	3/10/13
	*  @since	1.1.0
	*
	*  @param	$layout (array)
	*  @return	$layout (array)
	*/
	
	function get_valid_layout( $layout = array() ) {
		
		// parse
		$layout = wp_parse_args($layout, array(
			'key'			=> uniqid(),
			'name'			=> '',
			'label'			=> '',
			'display'		=> 'block',
			'sub_fields'	=> array(),
			'min'			=> '',
			'max'			=> '',
		));
		
		
		// return
		return $layout;
	}
	

	/*
	*  load_field()
	*
	*  This filter is appied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$field - the field array holding all the field options
	*/
	
	function load_field( $field ) {
		
		// bail early if no field layouts
		if( empty($field['layouts']) ) {
			
			return $field;
			
		}
		
		
		// vars
		$sub_fields = acf_get_fields($field);
		
		
		// loop through layouts, sub fields and swap out the field key with the real field
		foreach( array_keys($field['layouts']) as $i ) {
			
			// extract layout
			$layout = acf_extract_var( $field['layouts'], $i );
			
			
			// validate layout
			$layout = $this->get_valid_layout( $layout );
			
			
			// append sub fields
			if( !empty($sub_fields) ) {
				
				foreach( array_keys($sub_fields) as $k ) {
					
					// check if 'parent_layout' is empty
					if( empty($sub_fields[ $k ]['parent_layout']) ) {
					
						// parent_layout did not save for this field, default it to first layout
						$sub_fields[ $k ]['parent_layout'] = $layout['key'];
						
					}
					
					
					// append sub field to layout, 
					if( $sub_fields[ $k ]['parent_layout'] == $layout['key'] ) {
					
						$layout['sub_fields'][] = acf_extract_var( $sub_fields, $k );
						
					}
					
				}
				
			}
			
			
			// append back to layouts
			$field['layouts'][ $i ] = $layout;
			
		}
		
		
		// return
		return $field;
	}
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function render_field( $field ) {
	
		// defaults
		if( empty($field['button_label']) ) {
		
			$field['button_label'] = $this->defaults['button_label'];
			
		}
		
		
		// sort layouts into names
		$layouts = array();
		
		foreach( $field['layouts'] as $k => $layout ) {
		
			$layouts[ $layout['name'] ] = acf_extract_var( $field['layouts'], $k );
			
		}
		
		
		// hidden input
		acf_hidden_input(array(
			'type'	=> 'hidden',
			'name'	=> $field['name'],
		));
		
		
		// no value message
		$no_value_message = __('Click the "%s" button below to start creating your layout','acf');
		$no_value_message = apply_filters('acf/fields/flexible_content/no_value_message', $no_value_message, $field);

?>
<div <?php acf_esc_attr_e(array( 'class' => 'acf-flexible-content', 'data-min' => $field['min'], 'data-max'	=> $field['max'] )); ?>>
	
	<div class="no-value-message" <?php if( $field['value'] ){ echo 'style="display:none;"'; } ?>>
		<?php printf( $no_value_message, $field['button_label'] ); ?>
	</div>
	
	<div class="clones">
		<?php foreach( $layouts as $layout ): ?>
			<?php $this->render_layout( $field, $layout, 'acfcloneindex', array() ); ?>
		<?php endforeach; ?>
	</div>
	<div class="values">
		<?php if( !empty($field['value']) ): ?>
			<?php foreach( $field['value'] as $i => $value ): ?>
				<?php 
				
				// validate
				if( empty($layouts[ $value['acf_fc_layout'] ]) ) {
				
					continue;
					
				}

				$this->render_layout( $field, $layouts[ $value['acf_fc_layout'] ], $i, $value );
				
				?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	
	<ul class="acf-hl">
		<li class="acf-fr">
			<a href="#" class="acf-button blue" data-event="add-layout"><?php echo $field['button_label']; ?></a>
		</li>
	</ul>
	
	<script type="text-html" class="tmpl-popup"><?php 
		?><div class="acf-fc-popup">
			<ul>
				<?php foreach( $layouts as $layout ): 
					
					$atts = array(
						'data-layout'	=> $layout['name'],
						'data-min' 		=> $layout['min'],
						'data-max' 		=> $layout['max'],
					);
					
					?>
					<li>
						<a href="#" <?php acf_esc_attr_e( $atts ); ?>><?php echo $layout['label']; ?><span class="status"></span></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<a href="#" class="focus"></a>
		</div>
	</script>
	
</div>
<?php
		
	}
	
	
	/*
	*  render_layout
	*
	*  description
	*
	*  @type	function
	*  @date	19/11/2013
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function render_layout( $field, $layout, $i, $value ) {
		
		// vars
		$order = 0;
		$el = 'div';
		$div = array(
			'class'			=> 'layout',
			'data-id'		=> $i,
			'data-layout'	=> $layout['name']
		);
		
	
		// collapsed
		$collapsed = acf_get_user_setting('collapsed_' . $field['key'], '');
		
		
		// cookie fallback ( version < 5.3.2 )
		if( $collapsed === '' ) {
			
			$collapsed = acf_extract_var($_COOKIE, "acf_collapsed_{$field['key']}", '');
			$collapsed = str_replace('|', ',', $collapsed);
			
			acf_update_user_setting( 'collapsed_' . $field['key'], $collapsed );
				
		}
		
		
		// explode
		$collapsed = explode(',', $collapsed);
		$collapsed = array_filter($collapsed, 'is_numeric');
			
		
		// collapsed class
		if( in_array($i, $collapsed) ) {
			
			$div['class'] .= ' -collapsed';
			
		}
		
		
		// clone
		if( is_numeric($i) ) {
			
			$order = $i + 1;
			
		} else {
			
			$div['class'] .= ' acf-clone';
			
		}
		
		
?>
<div <?php acf_esc_attr_e($div); ?>>
			
	<div class="acf-hidden">
		<?php acf_hidden_input(array( 'name' => "{$field['name']}[{$i}][acf_fc_layout]", 'value' => $layout['name'] )); ?>
	</div>
	
	<div class="acf-fc-layout-handle">
		<span class="fc-layout-order"><?php echo $order; ?></span> <?php echo $layout['label']; ?>
	</div>
	
	<ul class="acf-fc-layout-controlls acf-hl">
		<li class="acf-fc-show-on-hover">
			<a class="acf-icon -plus small" href="#" data-event="add-layout" title="<?php _e('Add layout','acf'); ?>"></a>
		</li>
		<li class="acf-fc-show-on-hover">
			<a class="acf-icon -minus small" href="#" data-event="remove-layout" title="<?php _e('Remove layout','acf'); ?>"></a>
		</li>
		<li>
			<a class="acf-icon -collapse small" href="#" data-event="collapse-layout" title="<?php _e('Click to toggle','acf'); ?>"></a>
		</li>
	</ul>
	
<?php if( !empty($layout['sub_fields']) ): ?>
	
	<?php if( $layout['display'] == 'table' ): 
		
		// update vars
		$el = 'td';
		
		?>
	<table class="acf-table">
		
		<thead>
			<tr>
				<?php foreach( $layout['sub_fields'] as $sub_field ): 
					
					$atts = array(
						'class'		=> "acf-th acf-th-{$sub_field['name']}",
						'data-key'	=> $sub_field['key'],
					);
					
					
					// Add custom width
					if( $sub_field['wrapper']['width'] ) {
					
						$atts['data-width'] = $sub_field['wrapper']['width'];
						
					}
						
					?>
					<th <?php acf_esc_attr_e( $atts ); ?>>
						<?php acf_the_field_label( $sub_field ); ?>
						<?php if( $sub_field['instructions'] ): ?>
							<p class="description"><?php echo $sub_field['instructions']; ?></p>
						<?php endif; ?>
					</th>
					
				<?php endforeach; ?> 
			</tr>
		</thead>
		
		<tbody>
	<?php else: ?>
	<div class="acf-fields <?php if($layout['display'] == 'row'): ?>-left<?php endif; ?>">
	<?php endif; ?>
	
		<?php
			
		// loop though sub fields
		foreach( $layout['sub_fields'] as $sub_field ) {
			
			// prevent repeater field from creating multiple conditional logic items for each row
			if( $i !== 'acfcloneindex' ) {
				
				$sub_field['conditional_logic'] = 0;
				
			}
			
			
			// add value
			if( isset($value[ $sub_field['key'] ]) ) {
				
				// this is a normal value
				$sub_field['value'] = $value[ $sub_field['key'] ];
				
			} elseif( isset($sub_field['default_value']) ) {
				
				// no value, but this sub field has a default value
				$sub_field['value'] = $sub_field['default_value'];
				
			}
			
			
			// update prefix to allow for nested values
			$sub_field['prefix'] = "{$field['name']}[{$i}]";
			
			
			// render input
			acf_render_field_wrap( $sub_field, $el );
		
		}
		
		?>
			
	<?php if( $layout['display'] == 'table' ): ?>
		</tbody>
	</table>
	<?php else: ?>
	</div>
	<?php endif; ?>

<?php endif; ?>

</div>
<?php
		
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function render_field_settings( $field ) {
		
		// load default layout
		if( empty($field['layouts']) ) {
		
			$field['layouts'] = array();
			$field['layouts'][] = $this->get_valid_layout();
			
		}
		
		
		// loop through layouts
		foreach( $field['layouts'] as $layout ) {
			
			// get valid layout
			$layout = $this->get_valid_layout( $layout );
			
			
			// vars
			$layout_prefix = "{$field['prefix']}[layouts][{$layout['key']}]";
			
			
?><tr class="acf-field" data-name="fc_layout" data-setting="flexible_content" data-id="<?php echo $layout['key']; ?>">
	<td class="acf-label">
		<label><?php _e("Layout",'acf'); ?></label>
		<p class="description acf-fl-actions">
			<a data-name="acf-fc-reorder" title="<?php _e("Reorder Layout",'acf'); ?>" ><?php _e("Reorder",'acf'); ?></a>
			<a data-name="acf-fc-delete" title="<?php _e("Delete Layout",'acf'); ?>" href="#"><?php _e("Delete",'acf'); ?></a>
			<a data-name="acf-fc-duplicate" title="<?php _e("Duplicate Layout",'acf'); ?>" href="#"><?php _e("Duplicate",'acf'); ?></a>
			<a data-name="acf-fc-add" title="<?php _e("Add New Layout",'acf'); ?>" href="#"><?php _e("Add New",'acf'); ?></a>
		</p>
	</td>
	<td class="acf-input">
		
		<ul class="acf-fc-meta acf-bl">
			<li class="acf-fc-meta-key">
				<?php 
				
				acf_hidden_input(array(
					'name'		=> "{$layout_prefix}[key]",
					'data-name'	=> 'layout-key',
					'value'		=> $layout['key']
				));
				
				?>
			</li>
			<li class="acf-fc-meta-label">
				<?php 
				
				acf_render_field(array(
					'type'		=> 'text',
					'name'		=> 'label',
					'prefix'	=> $layout_prefix,
					'value'		=> $layout['label'],
					'prepend'	=> __('Label','acf')
				));
				
				?>
			</li>
			<li class="acf-fc-meta-name">
				<?php 
						
				acf_render_field(array(
					'type'		=> 'text',
					'name'		=> 'name',
					'prefix'	=> $layout_prefix,
					'value'		=> $layout['name'],
					'prepend'	=> __('Name','acf')
				));
				
				?>
			</li>
			<li class="acf-fc-meta-display">
				<div class="acf-input-prepend"><?php _e('Layout','acf'); ?></div>
				<div class="acf-input-wrap select">
					<?php 
					
					acf_render_field(array(
						'type'		=> 'select',
						'name'		=> 'display',
						'prefix'	=> $layout_prefix,
						'value'		=> $layout['display'],
						'choices'	=> array(
							'table'			=> __('Table','acf'),
							'block'			=> __('Block','acf'),
							'row'			=> __('Row','acf')
						),
					));
					
					?>
				</div>
			</li>
			<li class="acf-fc-meta-min">
				<?php
						
				acf_render_field(array(
					'type'		=> 'text',
					'name'		=> 'min',
					'prefix'	=> $layout_prefix,
					'value'		=> $layout['min'],
					'prepend'	=> __('Min','acf')
				));
				
				?>
			</li>
			<li class="acf-fc-meta-max">
				<?php 
				
				acf_render_field(array(
					'type'		=> 'text',
					'name'		=> 'max',
					'prefix'	=> $layout_prefix,
					'value'		=> $layout['max'],
					'prepend'	=> __('Max','acf')
				));
				
				?>
			</li>
		</ul>
		<?php 
		
		// vars
		$args = array(
			'fields'	=> $layout['sub_fields'],
			'layout'	=> $layout['display'],
			'parent'	=> $field['ID']
		);
		
		acf_get_view('field-group-fields', $args);
		
		?>
	</td>
</tr>
<?php
	
		}
		// endforeach
		
		
		// min
		acf_render_field_setting( $field, array(
			'label'			=> __('Button Label','acf'),
			'instructions'	=> '',
			'type'			=> 'text',
			'name'			=> 'button_label',
		));
		
		
		// min
		acf_render_field_setting( $field, array(
			'label'			=> __('Minimum Layouts','acf'),
			'instructions'	=> '',
			'type'			=> 'number',
			'name'			=> 'min',
		));
		
		
		// max
		acf_render_field_setting( $field, array(
			'label'			=> __('Maximum Layouts','acf'),
			'instructions'	=> '',
			'type'			=> 'number',
			'name'			=> 'max',
		));
				
	}
	
	
	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	function load_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) || empty($field['layouts']) ) {
			
			return $value;
			
		}
		
		
		// value must be an array
		$value = acf_get_array( $value );
		
		
		// vars
		$rows = array();
		
		
		// populate $layouts
		$layouts = array();
		
		foreach( array_keys($field['layouts']) as $i ) {
			
			// get layout
			$layout = $field['layouts'][ $i ];
			
			
			// append to $layouts
			$layouts[ $layout['name'] ] = $layout['sub_fields'];
			
		}
	
		
		// loop through rows
		foreach( $value as $i => $l ) {
			
			// append to $values
			$rows[ $i ] = array();
			$rows[ $i ]['acf_fc_layout'] = $l;
			
			
			// bail early if layout deosnt contain sub fields
			if( empty($layouts[ $l ]) ) {
				
				continue;
				
			}
			
			
			// get layout
			$layout = $layouts[ $l ];
			
			
			// loop through sub fields
			foreach( array_keys($layout) as $j ) {
				
				// get sub field
				$sub_field = $layout[ $j ];
				
				
				// update full name
				$sub_field['name'] = "{$field['name']}_{$i}_{$sub_field['name']}";
				
				
				// get value
				$sub_value = acf_get_value( $post_id, $sub_field );
				
				
				// add value
				$rows[ $i ][ $sub_field['key'] ] = $sub_value;
				
			}
			// foreach
			
		}
		// foreach
		
		
		
		// return
		return $rows;
		
	}
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) || empty($field['layouts']) ) {
			
			return false;
			
		}
		
		
		// populate $layouts
		$layouts = array();
		
		foreach( array_keys($field['layouts']) as $i ) {
			
			// get layout
			$layout = $field['layouts'][ $i ];
			
			
			// append to $layouts
			$layouts[ $layout['name'] ] = $layout['sub_fields'];
			
		}
		
		
		// loop over rows
		foreach( array_keys($value) as $i ) {
			
			// get layout name
			$l = $value[ $i ]['acf_fc_layout'];
			
			
			// bail early if layout deosnt exist
			if( empty($layouts[ $l ]) ) {
				
				continue;
				
			}
			
			
			// get layout
			$layout = $layouts[ $l ];
			
			
			// loop through sub fields
			foreach( array_keys($layout) as $j ) {
				
				// get sub field
				$sub_field = $layout[ $j ];
				
				
				// extract value
				$sub_value = acf_extract_var( $value[ $i ], $sub_field['key'] );
				
				
				// format value
				$sub_value = acf_format_value( $sub_value, $post_id, $sub_field );
				
				
				// append to $row
				$value[ $i ][ $sub_field['name'] ] = $sub_value;
				
			}
			
		}
		
		
		// return
		return $value;
	}
	
	
	/*
	*  validate_value
	*
	*  description
	*
	*  @type	function
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function validate_value( $valid, $value, $field, $input ){
		
		// remove acfcloneindex
		if( isset($value['acfcloneindex']) ) {
		
			unset($value['acfcloneindex']);
			
		}
		
		
		// valid
		if( $field['required'] && empty($value) ) {
		
			$valid = false;
			
		}
		
		
		// populate $layouts
		$layouts = array();
		
		foreach( array_keys($field['layouts']) as $i ) {
			
			$layout = acf_extract_var($field['layouts'], $i);
			
			// append to $layouts
			$layouts[ $layout['name'] ] = $layout['sub_fields'];
			
		}	
		
		
		// check sub fields
		if( !empty($value) ) {
			
			// loop through rows
			foreach( $value as $i => $row ) {	
				
				// get layout
				$l = $row['acf_fc_layout'];
				
				
				// loop through sub fields
				if( !empty($layouts[ $l ]) ) {
					
					foreach( $layouts[ $l ] as $sub_field ) {
						
						// get sub field key
						$k = $sub_field['key'];
						
						
						// exists?
						if( ! isset($value[ $i ][ $k ]) ) {
							
							continue;
							
						}
						
						
						// validate
						acf_validate_value( $value[ $i ][ $k ], $sub_field, "{$input}[{$i}][{$k}]" );
					
					}
					// foreach
					
				}
				// if
				
			}
			// foreach
			
		}
		// if
		
		
		// return
		return $valid;
		
	}
	
	
	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the $post_id of which the value will be saved
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field ) {
		
		// remove acfcloneindex
		if( isset($value['acfcloneindex']) ) {
		
			unset($value['acfcloneindex']);
			
		}
		
		
		// vars
		$order = array();
		$layouts = array();
		
		
		// populate $layouts
		foreach( $field['layouts'] as $layout ) {
			
			$layouts[ $layout['name'] ] = $layout['sub_fields'];
			
		}
		
		
		// update sub fields
		if( !empty($value) ) {
			
			// $i
			$i = -1;
			
			
			// loop through rows
			foreach( $value as $row ) {	
				
				// $i
				$i++;
				
				
				// get layout
				$l = $row['acf_fc_layout'];
				
				
				// append to order
				$order[] = $l;
				
				
				// loop through sub fields
				if( !empty($layouts[ $l ]) ) {
					
					foreach( $layouts[ $l ] as $sub_field ) {
						
						// value
						$v = false;
						
						
						// key (backend)
						if( isset($row[ $sub_field['key'] ]) ) {
							
							$v = $row[ $sub_field['key'] ];
							
						} elseif( isset($row[ $sub_field['name'] ]) ) {
							
							$v = $row[ $sub_field['name'] ];
							
						} else {
							
							// input is not set (hidden by conditioanl logic)
							continue;
							
						}
						
						
						// modify name for save
						$sub_field['name'] = "{$field['name']}_{$i}_{$sub_field['name']}";
						
						
						// update field
						acf_update_value( $v, $post_id, $sub_field );
						
					}
					// foreach
					
				}
				// if
				
			}
			// foreach
			
		}
		// if
		
		
		// remove old data
		$old_order = acf_get_metadata( $post_id, $field['name'] );
		$old_count = empty($old_order) ? 0 : count($old_order);
		$new_count = empty($order) ? 0 : count($order);
		
		
		if( $old_count > $new_count ) {
			
			for( $i = $new_count; $i < $old_count; $i++ ) {
				
				// get layout
				$l = $old_order[ $i ];
				
				
				// loop through sub fields
				if( !empty($layouts[ $l ]) ) {
					
					foreach( $layouts[ $l ] as $sub_field ) {
						
						// modify name for delete
						$sub_field['name'] = "{$field['name']}_{$i}_{$sub_field['name']}";
						
						
						// delete value
						acf_delete_value( $post_id, $sub_field );
						
					}
					
				}
				
			}
			
		}

		
		// save false for empty value
		if( empty($order) ) {
			
			$order = false;
		
		}
		
		
		// return
		return $order;
	}
	
	
	/*
	*  update_field()
	*
	*  This filter is appied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = acf)
	*
	*  @return	$field - the modified field
	*/

	function update_field( $field ) {
		
		// vars
		$layouts = acf_extract_var($field, 'layouts');
		
		
		// update layouts
		$field['layouts'] = array();
		
		
		// loop through sub fields
		if( !empty($layouts) ) {
			
			foreach( $layouts as $layout ) {
				
				// remove sub fields
				unset($layout['sub_fields']);
				
				
				// append to layouts
				$field['layouts'][] = $layout;	
				
			}
			
		}
		
		
		// return		
		return $field;
	}
	
	
	/*
	*  delete_field
	*
	*  description
	*
	*  @type	function
	*  @date	4/04/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function delete_field( $field ) {
		
		if( !empty($field['layouts']) ) {
			
			// loop through layouts
			foreach( $field['layouts'] as $layout ) {
				
				// loop through sub fields
				if( !empty($layout['sub_fields']) ) {
				
					foreach( $layout['sub_fields'] as $sub_field ) {
					
						acf_delete_field( $sub_field['ID'] );
						
					}
					// foreach
					
				}
				// if
				
			}
			// foreach
			
		}
		// if
		
	}
	
	
	/*
	*  duplicate_field()
	*
	*  This filter is appied to the $field before it is duplicated and saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$field - the modified field
	*/
	
	function duplicate_field( $field ) {
		
		// vars
		$sub_fields = array();
		
		
		if( !empty($field['layouts']) ) {
			
			// loop through layouts
			foreach( $field['layouts'] as $layout ) {
				
				// extract sub fields
				$extra = acf_extract_var( $layout, 'sub_fields' );
				
				
				// merge
				if( !empty($extra) ) {
					
					$sub_fields = array_merge($sub_fields, $extra);
					
				}
				
			}
			// foreach
			
		}
		// if
		
		
		// save field to get ID
		$field = acf_update_field( $field );
		
		
		// duplicate sub fields
		acf_duplicate_fields( $sub_fields, $field['ID'] );
		
		
		// return		
		return $field;
		
	}
	
}

new acf_field_flexible_content();

endif;

?>
