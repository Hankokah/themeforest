<?php if ( ! defined( 'OT_VERSION' ) ) exit( 'No direct script access allowed' );
/**
 * Functions used to build each option type.
 *
 * @package   OptionTree
 * @author    Derek Herman <derek@valendesigns.com>
 * @copyright Copyright (c) 2013, Derek Herman
 * @since     2.0
 */

/**
 * Builds the HTML for each of the available option types by calling those
 * function with call_user_func and passing the arguments to the second param.
 *
 * All fields are required!
 *
 * @param     array       $args The array of arguments are as follows:
 * @param     string      $type Type of option.
 * @param     string      $field_id The field ID.
 * @param     string      $field_name The field Name.
 * @param     mixed       $field_value The field value is a string or an array of values.
 * @param     string      $field_desc The field description.
 * @param     string      $field_std The standard value.
 * @param     string      $field_class Extra CSS classes.
 * @param     array       $field_choices The array of option choices.
 * @param     array       $field_settings The array of settings for a list item.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_display_by_type' ) ) {

  function ot_display_by_type( $args = array() ) {
    
    /* allow filters to be executed on the array */
    $args = apply_filters( 'ot_display_by_type', $args );
    
    /* build the function name */
    $function_name_by_type = str_replace( '-', '_', 'ot_type_' . $args['type'] );
    
    /* call the function & pass in arguments array */
    if ( function_exists( $function_name_by_type ) ) {
      call_user_func( $function_name_by_type, $args );
    } else {
      echo '<p>' . esc_html__( 'Sorry, this function does not exist', 'eventstation' ) . '</p>';
    }
    
  }
  
}

/**
 * Background option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_background' ) ) {
  
  function ot_type_background( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* If an attachment ID is stored here fetch its URL and replace the value */
    if ( isset( $field_value['background-image'] ) && wp_attachment_is_image( $field_value['background-image'] ) ) {
    
      $attachment_data = wp_get_attachment_image_src( $field_value['background-image'], 'original' );
      
      /* check for attachment data */
      if ( $attachment_data ) {
      
        $field_src = $attachment_data[0];
        
      }
      
    }
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-background ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* allow fields to be filtered */
        $ot_recognized_background_fields = apply_filters( 'ot_recognized_background_fields', array( 
          'background-color',
          'background-repeat', 
          'background-attachment', 
          'background-position',
          'background-size',
          'background-image'
        ), $field_id );
        
        echo '<div class="ot-background-group">';
        
          /* build background color */
          if ( in_array( 'background-color', $ot_recognized_background_fields ) ) {
          
            echo '<div class="option-tree-ui-colorpicker-input-wrap">';
              
              /* colorpicker JS */      
              echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
              
              /* set background color */
              $background_color = isset( $field_value['background-color'] ) ? esc_attr( $field_value['background-color'] ) : '';
              
              /* input */
              echo '<input type="text" name="' . esc_attr( $field_name ) . '[background-color]" id="' . $field_id . '-picker" value="' . $background_color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
            
            echo '</div>';
          
          }
      
          /* build background repeat */
          if ( in_array( 'background-repeat', $ot_recognized_background_fields ) ) {
          
            $background_repeat = isset( $field_value['background-repeat'] ) ? esc_attr( $field_value['background-repeat'] ) : '';
            
            echo '<select name="' . esc_attr( $field_name ) . '[background-repeat]" id="' . esc_attr( $field_id ) . '-repeat" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              
              echo '<option value="">' . esc_html__( 'background-repeat', 'eventstation' ) . '</option>';
              foreach ( ot_recognized_background_repeat( $field_id ) as $key => $value ) {
              
                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $background_repeat, $key, false ) . '>' . esc_attr( $value ) . '</option>';
                
              }
              
            echo '</select>';
          
          }
          
          /* build background attachment */
          if ( in_array( 'background-attachment', $ot_recognized_background_fields ) ) {
          
            $background_attachment = isset( $field_value['background-attachment'] ) ? esc_attr( $field_value['background-attachment'] ) : '';
            
            echo '<select name="' . esc_attr( $field_name ) . '[background-attachment]" id="' . esc_attr( $field_id ) . '-attachment" class="option-tree-ui-select ' . $field_class . '">';
              
              echo '<option value="">' . esc_html__( 'background-attachment', 'eventstation' ) . '</option>';
              
              foreach ( ot_recognized_background_attachment( $field_id ) as $key => $value ) {
              
                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $background_attachment, $key, false ) . '>' . esc_attr( $value ) . '</option>';
              
              }
              
            echo '</select>';
          
          }
          
          /* build background position */
          if ( in_array( 'background-position', $ot_recognized_background_fields ) ) {
          
            $background_position = isset( $field_value['background-position'] ) ? esc_attr( $field_value['background-position'] ) : '';
            
            echo '<select name="' . esc_attr( $field_name ) . '[background-position]" id="' . esc_attr( $field_id ) . '-position" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              
              echo '<option value="">' . esc_html__( 'background-position', 'eventstation' ) . '</option>';
              
              foreach ( ot_recognized_background_position( $field_id ) as $key => $value ) {
                
                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $background_position, $key, false ) . '>' . esc_attr( $value ) . '</option>';
              
              }
            
            echo '</select>';
          
          }
  
          /* Build background size  */
          if ( in_array( 'background-size', $ot_recognized_background_fields ) ) {
            
            /**
             * Use this filter to create a select instead of an text input.
             * Be sure to return the array in the correct format. Add an empty 
             * value to the first choice so the user can leave it blank.
             *
                array( 
                  array(
                    'label' => 'background-size',
                    'value' => ''
                  ),
                  array(
                    'label' => 'cover',
                    'value' => 'cover'
                  ),
                  array(
                    'label' => 'contain',
                    'value' => 'contain'
                  )
                )
             *
             */
            $choices = apply_filters( 'ot_type_background_size_choices', '', $field_id );
            
            if ( is_array( $choices ) && ! empty( $choices ) ) {
            
              /* build select */
              echo '<select name="' . esc_attr( $field_name ) . '[background-size]" id="' . esc_attr( $field_id ) . '-size" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              
                foreach ( (array) $choices as $choice ) {
                  if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
                    echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( ( isset( $field_value['background-size'] ) ? $field_value['background-size'] : '' ), $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
                  }
                }
        
              echo '</select>';
            
            } else {
            
              echo '<input type="text" name="' . esc_attr( $field_name ) . '[background-size]" id="' . esc_attr( $field_id ) . '-size" value="' . ( isset( $field_value['background-size'] ) ? esc_attr( $field_value['background-size'] ) : '' ) . '" class="widefat ot-background-size-input option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'background-size', 'eventstation' ) . '" />';
              
            }
          
          }
        
        echo '</div>';

        /* build background image */
        if ( in_array( 'background-image', $ot_recognized_background_fields ) ) {
        
          echo '<div class="option-tree-ui-upload-parent">';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[background-image]" id="' . esc_attr( $field_id ) . '" value="' . ( isset( $field_value['background-image'] ) ? esc_attr( $field_value['background-image'] ) : '' ) . '" class="widefat option-tree-ui-upload-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'background-image', 'eventstation' ) . '" />';
            
            /* add media button */
            echo '<a href="javascript:void(0);" class="ot_upload_media option-tree-ui-button button button-primary light" rel="' . $post_id . '" title="' . esc_html__( 'Add Media', 'eventstation' ) . '"><span class="icon ot-icon-plus-circle"></span>' . esc_html__( 'Add Media', 'eventstation' ) . '</a>';
          
          echo '</div>';
          
          /* media */
          if ( isset( $field_value['background-image'] ) && $field_value['background-image'] !== '' ) {
            
            /* replace image src */
            if ( isset( $field_src ) )
              $field_value['background-image'] = $field_src;
          
            echo '<div class="option-tree-ui-media-wrap" id="' . esc_attr( $field_id ) . '_media">';
            
              if ( preg_match( '/\.(?:jpe?g|png|gif|ico)$/i', $field_value['background-image'] ) )
                echo '<div class="option-tree-ui-image-wrap"><img src="' . esc_url( $field_value['background-image'] ) . '" alt="" /></div>';
              
              echo '<a href="javascript:(void);" class="option-tree-ui-remove-media option-tree-ui-button button button-secondary light" title="' . esc_html__( 'Remove Media', 'eventstation' ) . '"><span class="icon ot-icon-minus-circle"></span>' . esc_html__( 'Remove Media', 'eventstation' ) . '</a>';
              
            echo '</div>';
            
          }
        
        }

      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Border Option Type
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The markup.
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_border' ) ) {

  function ot_type_border( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-border ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        /* allow fields to be filtered */
        $ot_recognized_border_fields = apply_filters( 'ot_recognized_border_fields', array(
          'width',
          'unit',
          'style',
          'color'
        ), $field_id );

        /* build border width */
        if ( in_array( 'width', $ot_recognized_border_fields ) ) {

          $width = isset( $field_value['width'] ) ? esc_attr( $field_value['width'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-sixth"><input type="text" name="' . esc_attr( $field_name ) . '[width]" id="' . esc_attr( $field_id ) . '-width" value="' . esc_attr( $width ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'width', 'eventstation' ) . '" /></div>';

        }

        /* build unit dropdown */
        if ( in_array( 'unit', $ot_recognized_border_fields ) ) {
          
          echo '<div class="ot-option-group ot-option-group--one-fourth">';
          
            echo '<select name="' . esc_attr( $field_name ) . '[unit]" id="' . esc_attr( $field_id ) . '-unit" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
    
              echo '<option value="">' . esc_html__( 'unit', 'eventstation' ) . '</option>';
    
              foreach ( ot_recognized_border_unit_types( $field_id ) as $unit ) {
                echo '<option value="' . esc_attr( $unit ) . '"' . ( isset( $field_value['unit'] ) ? selected( $field_value['unit'], $unit, false ) : '' ) . '>' . esc_attr( $unit ) . '</option>';
              }
    
            echo '</select>';
          
          echo '</div>';
  
        }
        
        /* build style dropdown */
        if ( in_array( 'style', $ot_recognized_border_fields ) ) {
          
          echo '<div class="ot-option-group ot-option-group--one-fourth">';
          
            echo '<select name="' . esc_attr( $field_name ) . '[style]" id="' . esc_attr( $field_id ) . '-style" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
    
              echo '<option value="">' . esc_html__( 'style', 'eventstation' ) . '</option>';
    
              foreach ( ot_recognized_border_style_types( $field_id ) as $key => $style ) {
                echo '<option value="' . esc_attr( $key ) . '"' . ( isset( $field_value['style'] ) ? selected( $field_value['style'], $key, false ) : '' ) . '>' . esc_attr( $style ) . '</option>';
              }
    
            echo '</select>';
          
          echo '</div>';
  
        }
        
        /* build color */
        if ( in_array( 'color', $ot_recognized_border_fields ) ) {
          
          echo '<div class="option-tree-ui-colorpicker-input-wrap">';
            
            /* colorpicker JS */      
            echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
            
            /* set color */
            $color = isset( $field_value['color'] ) ? esc_attr( $field_value['color'] ) : '';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[color]" id="' . $field_id . '-picker" value="' . $color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
          
          echo '</div>';
        
        }
      
      echo '</div>';

    echo '</div>';

  }

}

/**
 * Box Shadow Option Type
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The markup.
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_box_shadow' ) ) {

  function ot_type_box_shadow( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-box-shadow ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        /* allow fields to be filtered */
        $ot_recognized_box_shadow_fields = apply_filters( 'ot_recognized_box_shadow_fields', array(
          'inset',
          'offset-x',
          'offset-y',
          'blur-radius',
          'spread-radius',
          'color'
        ), $field_id );
        
        /* build inset */
        if ( in_array( 'inset', $ot_recognized_box_shadow_fields ) ) {
        
          echo '<div class="ot-option-group ot-option-group--checkbox"><p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[inset]" id="' . esc_attr( $field_id ) . '-inset" value="inset" ' . ( isset( $field_value['inset'] ) ? checked( $field_value['inset'], 'inset', false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-inset">inset</label>';
          echo '</p></div>';
          
        }
          
        /* build horizontal offset */
        if ( in_array( 'offset-x', $ot_recognized_box_shadow_fields ) ) {

          $offset_x = isset( $field_value['offset-x'] ) ? esc_attr( $field_value['offset-x'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-fifth"><span class="ot-icon-arrows-h ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[offset-x]" id="' . esc_attr( $field_id ) . '-offset-x" value="' . $offset_x . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'offset-x', 'eventstation' ) . '" /></div>';

        }
        
        /* build vertical offset */
        if ( in_array( 'offset-y', $ot_recognized_box_shadow_fields ) ) {

          $offset_y = isset( $field_value['offset-y'] ) ? esc_attr( $field_value['offset-y'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-fifth"><span class="ot-icon-arrows-v ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[offset-y]" id="' . esc_attr( $field_id ) . '-offset-y" value="' . $offset_y . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'offset-y', 'eventstation' ) . '" /></div>';

        }
        
        /* build blur-radius radius */
        if ( in_array( 'blur-radius', $ot_recognized_box_shadow_fields ) ) {

          $blur_radius = isset( $field_value['blur-radius'] ) ? esc_attr( $field_value['blur-radius'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-fifth"><span class="ot-icon-circle ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[blur-radius]" id="' . esc_attr( $field_id ) . '-blur-radius" value="' . $blur_radius . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'blur-radius', 'eventstation' ) . '" /></div>';

        }
        
        /* build spread-radius radius */
        if ( in_array( 'spread-radius', $ot_recognized_box_shadow_fields ) ) {

          $spread_radius = isset( $field_value['spread-radius'] ) ? esc_attr( $field_value['spread-radius'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-fifth"><span class="ot-icon-arrows-alt ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[spread-radius]" id="' . esc_attr( $field_id ) . '-spread-radius" value="' . $spread_radius . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'spread-radius', 'eventstation' ) . '" /></div>';

        }
        
        /* build color */
        if ( in_array( 'color', $ot_recognized_box_shadow_fields ) ) {
          
          echo '<div class="option-tree-ui-colorpicker-input-wrap">';
            
            /* colorpicker JS */      
            echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
            
            /* set color */
            $color = isset( $field_value['color'] ) ? esc_attr( $field_value['color'] ) : '';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[color]" id="' . esc_attr( $field_id ) . '-picker" value="' . $color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
          
          echo '</div>';
        
        }
        
      echo '</div>';

    echo '</div>';

  }

}

/**
 * Category Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_category_checkbox' ) ) {
  
  function ot_type_category_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-category-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* get category array */
        $categories = get_categories( apply_filters( 'ot_type_category_checkbox_query', array( 'hide_empty' => false ), $field_id ) );
        
        /* build categories */
        if ( ! empty( $categories ) ) {
          foreach ( $categories as $category ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $category->term_id ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $category->term_id ) . '" value="' . esc_attr( $category->term_id ) . '" ' . ( isset( $field_value[$category->term_id] ) ? checked( $field_value[$category->term_id], $category->term_id, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $category->term_id ) . '">' . esc_attr( $category->name ) . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . esc_html__( 'No Categories Found', 'eventstation' ) . '</p>';
        }
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Category Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_category_select' ) ) {
  
  function ot_type_category_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-category-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build category */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* get category array */
        $categories = get_categories( apply_filters( 'ot_type_category_select_query', array( 'hide_empty' => false ), $field_id ) );
        
        /* has cats */
        if ( ! empty( $categories ) ) {
          echo '<option value="">-- ' . esc_html__( 'Choose One', 'eventstation' ) . ' --</option>';
          foreach ( $categories as $category ) {
            echo '<option value="' . esc_attr( $category->term_id ) . '"' . selected( $field_value, $category->term_id, false ) . '>' . esc_attr( $category->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Categories Found', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_checkbox' ) ) {
  
  function ot_type_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';    
      
        /* build checkbox */
        foreach ( (array) $field_choices as $key => $choice ) {
          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $key ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '" ' . ( isset( $field_value[$key] ) ? checked( $field_value[$key], $choice['value'], false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label>';
            echo '</p>';
          }
        }
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Colorpicker option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 * @updated   2.2.0
 */
if ( ! function_exists( 'ot_type_colorpicker' ) ) {
  
  function ot_type_colorpicker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-colorpicker ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* build colorpicker */  
        echo '<div class="option-tree-ui-colorpicker-input-wrap">';
          
          /* colorpicker JS */      
          echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '"); });</script>';
          
          /* set the default color */
          $std = $field_std ? 'data-default-color="' . $field_std . '"' : '';
          
          /* input */
          echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" ' . $std . ' />';
        
        echo '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Colorpicker Opacity option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_colorpicker_opacity' ) ) {

  function ot_type_colorpicker_opacity( $args = array() ) {

    $args['field_class'] = isset( $args['field_class'] ) ? $args['field_class'] . ' ot-colorpicker-opacity' : 'ot-colorpicker-opacity';
    ot_type_colorpicker( $args );

  }

}

/**
 * CSS option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_css' ) ) {
  
  function ot_type_css( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-css simple ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* build textarea for CSS */
        echo '<textarea class="hidden" id="textarea_' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_name ) .'">' . esc_attr( $field_value ) . '</textarea>';
    
        /* build pre to convert it into ace editor later */
        echo '<pre class="ot-css-editor ' . esc_attr( $field_class ) . '" id="' . esc_attr( $field_id ) . '">' . esc_textarea( $field_value ) . '</pre>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Custom Post Type Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_custom_post_type_checkbox' ) ) {
  
  function ot_type_custom_post_type_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-custom-post-type-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* setup the post types */
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );

        /* query posts array */
        $my_posts = get_posts( apply_filters( 'ot_type_custom_post_type_checkbox_query', array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );

        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[$my_post->ID] ) ? checked( $field_value[$my_post->ID], $my_post->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
            echo '</p>';
          }
        } else {
          echo '<p>' . esc_html__( 'No Posts Found', 'eventstation' ) . '</p>';
        }
        
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Custom Post Type Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_custom_post_type_select' ) ) {
  
  function ot_type_custom_post_type_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-custom-post-type-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* build category */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* setup the post types */
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );
        
        /* query posts array */
        $my_posts = get_posts( apply_filters( 'ot_type_custom_post_type_select_query', array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          echo '<option value="">-- ' . esc_html__( 'Choose One', 'eventstation' ) . ' --</option>';
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $field_value, $my_post->ID, false ) . '>' . $post_title . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Posts Found', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Date Picker option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.3
 */
if ( ! function_exists( 'ot_type_date_picker' ) ) {
  
  function ot_type_date_picker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* filter date format */
    $date_format = apply_filters( 'ot_type_date_picker_date_format', 'yy-mm-dd', $field_id );

    /**
     * Filter the addition of the readonly attribute.
     *
     * @since 2.5.0
     *
     * @param bool $is_readonly Whether to add the 'readonly' attribute. Default 'false'.
     * @param string $field_id The field ID.
     */
    $is_readonly = apply_filters( 'ot_type_date_picker_readonly', false, $field_id );

    /* format setting outer wrapper */
    echo '<div class="format-setting type-date-picker ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
    
    /* date picker JS */      
    echo '<script>jQuery(document).ready(function($) { OT_UI.bind_date_picker("' . esc_attr( $field_id ) . '", "' . esc_attr( $date_format ) . '"); });</script>';      
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build date picker */
        echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '"' . ( $is_readonly == true ? ' readonly' : '' ) . ' />';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Date Time Picker option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.3
 */
if ( ! function_exists( 'ot_type_date_time_picker' ) ) {
  
  function ot_type_date_time_picker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* filter date format */
    $date_format = apply_filters( 'ot_type_date_time_picker_date_format', 'yy-mm-dd', $field_id );

    /**
     * Filter the addition of the readonly attribute.
     *
     * @since 2.5.0
     *
     * @param bool $is_readonly Whether to add the 'readonly' attribute. Default 'false'.
     * @param string $field_id The field ID.
     */
    $is_readonly = apply_filters( 'ot_type_date_time_picker_readonly', false, $field_id );

    /* format setting outer wrapper */
    echo '<div class="format-setting type-date-time-picker ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
    
    /* date time picker JS */      
    echo '<script>jQuery(document).ready(function($) { OT_UI.bind_date_time_picker("' . esc_attr( $field_id ) . '", "' . esc_attr( $date_format ) . '"); });</script>';      
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build date time picker */
        echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '"' . ( $is_readonly == true ? ' readonly' : '' ) . ' />';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Dimension Option Type
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The markup.
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_dimension' ) ) {

  function ot_type_dimension( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-dimension ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        /* allow fields to be filtered */
        $ot_recognized_dimension_fields = apply_filters( 'ot_recognized_dimension_fields', array(
          'width',
          'height',
          'unit'
        ), $field_id );

        /* build width dimension */
        if ( in_array( 'width', $ot_recognized_dimension_fields ) ) {

          $width = isset( $field_value['width'] ) ? esc_attr( $field_value['width'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-third"><span class="ot-icon-arrows-h ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[width]" id="' . esc_attr( $field_id ) . '-width" value="' . esc_attr( $width ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'width', 'eventstation' ) . '" /></div>';

        }

        /* build height dimension */
        if ( in_array( 'height', $ot_recognized_dimension_fields ) ) {

          $height = isset( $field_value['height'] ) ? esc_attr( $field_value['height'] ) : '';

          echo '<div class="ot-option-group ot-option-group--one-third"><span class="ot-icon-arrows-v ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[height]" id="' . esc_attr( $field_id ) . '-height" value="' . esc_attr( $height ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'height', 'eventstation' ) . '" /></div>';

        }
        
        /* build unit dropdown */
        if ( in_array( 'unit', $ot_recognized_dimension_fields ) ) {
          
          echo '<div class="ot-option-group ot-option-group--one-third ot-option-group--is-last">';
          
            echo '<select name="' . esc_attr( $field_name ) . '[unit]" id="' . esc_attr( $field_id ) . '-unit" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
    
              echo '<option value="">' . esc_html__( 'unit', 'eventstation' ) . '</option>';
    
              foreach ( ot_recognized_dimension_unit_types( $field_id ) as $unit ) {
                echo '<option value="' . esc_attr( $unit ) . '"' . ( isset( $field_value['unit'] ) ? selected( $field_value['unit'], $unit, false ) : '' ) . '>' . esc_attr( $unit ) . '</option>';
              }
    
            echo '</select>';
          
          echo '</div>';
  
        }
      
      echo '</div>';

    echo '</div>';

  }

}

/**
 * Gallery option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The gallery metabox markup.
 *
 * @access    public
 * @since     2.2.0
 */
if ( ! function_exists( 'ot_type_gallery' ) ) {

  function ot_type_gallery( $args = array() ) {
  
    // Turns arguments array into variables
    extract( $args );
  
    // Verify a description
    $has_desc = $field_desc ? true : false;
  
    // Format setting outer wrapper
    echo '<div class="format-setting type-gallery ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
  
      // Description
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
  
      // Format setting inner wrapper
      echo '<div class="format-setting-inner">';
  
        // Setup the post type
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );
        
        $field_value = trim( $field_value );
        
        // Saved values
        echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="ot-gallery-value ' . esc_attr( $field_class ) . '" />';
        
        // Search the string for the IDs
        preg_match( '/ids=\'(.*?)\'/', $field_value, $matches );
        
        // Turn the field value into an array of IDs
        if ( isset( $matches[1] ) ) {
          
          // Found the IDs in the shortcode
          $ids = explode( ',', $matches[1] );
          
        } else {
          
          // The string is only IDs
          $ids = ! empty( $field_value ) && $field_value != '' ? explode( ',', $field_value ) : array();
          
        }

        // Has attachment IDs
        if ( ! empty( $ids ) ) {
          
          echo '<ul class="ot-gallery-list">';
          
          foreach( $ids as $id ) {
            
            if ( $id == '' )
              continue;
              
            $thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );
        
            echo '<li><img  src="' . $thumbnail[0] . '" width="75" height="75" /></li>';
        
          }
        
          echo '</ul>';
          
          echo '
          <div class="ot-gallery-buttons">
            <a href="#" class="option-tree-ui-button button button-secondary hug-left ot-gallery-delete">' . esc_html__( 'Delete Gallery', 'eventstation' ) . '</a>
            <a href="#" class="option-tree-ui-button button button-primary right hug-right ot-gallery-edit">' . esc_html__( 'Edit Gallery', 'eventstation' ) . '</a>
          </div>';
        
        } else {
        
          echo '
          <div class="ot-gallery-buttons">
            <a href="#" class="option-tree-ui-button button button-primary right hug-right ot-gallery-edit">' . esc_html__( 'Create Gallery', 'eventstation' ) . '</a>
          </div>';
        
        }
      
      echo '</div>';
      
    echo '</div>';
    
  }

}

/**
 * Google Fonts option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_google_fonts' ) ) {
  
  function ot_type_google_fonts( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-google-font ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* allow fields to be filtered */
        $ot_recognized_google_fonts_fields = apply_filters( 'ot_recognized_google_font_fields', array(
          'variants', 
          'subsets'
        ), $field_id );
        
        // Set a default to show at least one item.
        if ( ! is_array( $field_value ) || empty( $field_value ) ) {
          $field_value = array( array(
            'family'    => '',
            'variants'  => array(),
            'subsets'   => array()
          ) );
        }
        
        foreach( $field_value as $key => $value ) {
        
          echo '<div class="type-google-font-group">';
          
            /* build font family */
            $family = isset( $value['family'] ) ? $value['family'] : '';
            echo '<div class="option-tree-google-font-family">';
              echo '<a href="javascript:void(0);" class="js-remove-google-font option-tree-ui-button button button-secondary light" title="' . esc_html__( 'Remove Google Font', 'eventstation' ) . '"><span class="icon ot-icon-minus-circle"/>' . esc_html__( 'Remove Google Font', 'eventstation' ) . '</a>';
              echo '<select name="' . esc_attr( $field_name ) . '[' . $key . '][family]" id="' . esc_attr( $field_id ) . '-' . $key . '" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
                echo '<option value="">' . esc_html__( '-- Choose One --', 'eventstation' ) . '</option>';
                foreach ( ot_recognized_google_font_families( $field_id ) as $family_key => $family_value ) {
                  echo '<option value="' . esc_attr( $family_key ) . '" ' . selected( $family, $family_key, false ) . '>' . esc_html( $family_value ) . '</option>';
                }
              echo '</select>';
            echo '</div>';
    
            /* build font variants */
            if ( in_array( 'variants', $ot_recognized_google_fonts_fields ) ) {
              $variants = isset( $value['variants'] ) ? $value['variants'] : array();
              echo '<div class="option-tree-google-font-variants" data-field-id-prefix="' . esc_attr( $field_id ) . '-' . $key . '-" data-field-name="' . esc_attr( $field_name ) . '[' . $key . '][variants]" data-field-class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '">';
              foreach ( ot_recognized_google_font_variants( $field_id, $family ) as $variant_key => $variant ) {
                echo '<p class="checkbox-wrap">';
                  echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . $key . '][variants][]" id="' . esc_attr( $field_id ) . '-' . $key . '-' . $variant . '" value="' . esc_attr( $variant ) . '" ' . checked( in_array( $variant, $variants ), true, false )  . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
                  echo '<label for="' . esc_attr( $field_id ) . '-' . $key . '-' . $variant . '">' . esc_html( $variant ) . '</label>';
                echo '</p>';
              }
              echo '</div>';
            }
            
            /* build font subsets */
            if ( in_array( 'subsets', $ot_recognized_google_fonts_fields ) ) {
              $subsets = isset( $value['subsets'] ) ? $value['subsets'] : array();
              echo '<div class="option-tree-google-font-subsets" data-field-id-prefix="' . esc_attr( $field_id ) . '-' . $key . '-" data-field-name="' . esc_attr( $field_name ) . '[' . $key . '][subsets]" data-field-class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '">';
              foreach ( ot_recognized_google_font_subsets( $field_id, $family ) as $subset_key => $subset ) {
                echo '<p class="checkbox-wrap">';
                  echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . $key . '][subsets][]" id="' . esc_attr( $field_id ) . '-' . $key . '-' . $subset . '" value="' . esc_attr( $subset ) . '" ' . checked( in_array( $subset, $subsets ), true, false )  . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
                  echo '<label for="' . esc_attr( $field_id ) . '-' . $key . '-' . $subset . '">' . esc_html( $subset ) . '</label>';
                echo '</p>';
              }
              echo '</div>';
            }
          
          echo '</div>';
        
        }

        echo '<div class="type-google-font-group-clone">';
        
          /* build font family */
          echo '<div class="option-tree-google-font-family">';
            echo '<a href="javascript:void(0);" class="js-remove-google-font option-tree-ui-button button button-secondary light" title="' . esc_html__( 'Remove Google Font', 'eventstation' ) . '"><span class="icon ot-icon-minus-circle"/>' . esc_html__( 'Remove Google Font', 'eventstation' ) . '</a>';
            echo '<select name="' . esc_attr( $field_name ) . '[%key%][family]" id="' . esc_attr( $field_id ) . '-%key%" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              echo '<option value="">' . esc_html__( '-- Choose One --', 'eventstation' ) . '</option>';
              foreach ( ot_recognized_google_font_families( $field_id ) as $family_key => $family_value ) {
                echo '<option value="' . esc_attr( $family_key ) . '">' . esc_html( $family_value ) . '</option>';
              }
            echo '</select>';
          echo '</div>';
          
          /* build font variants */
          if ( in_array( 'variants', $ot_recognized_google_fonts_fields ) ) {
            echo '<div class="option-tree-google-font-variants" data-field-id-prefix="' . esc_attr( $field_id ) . '-%key%-" data-field-name="' . esc_attr( $field_name ) . '[%key%][variants]" data-field-class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '">';
            echo '</div>';
          }
          
          /* build font subsets */
          if ( in_array( 'subsets', $ot_recognized_google_fonts_fields ) ) {
            echo '<div class="option-tree-google-font-subsets" data-field-id-prefix="' . esc_attr( $field_id ) . '-%key%-" data-field-name="' . esc_attr( $field_name ) . '[%key%][subsets]" data-field-class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '">';
            echo '</div>';
          }
        
        echo '</div>';
        
        echo '<a href="javascript:void(0);" class="js-add-google-font option-tree-ui-button button button-primary right hug-right" title="' . esc_html__( 'Add Google Font', 'eventstation' ) . '">' . esc_html__( 'Add Google Font', 'eventstation' ) . '</a>';
        
      echo '</div>';
      
    echo '</div>';
    
  }

}

/**
 * JavaScript option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_javascript' ) ) {
  
  function ot_type_javascript( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-javascript simple ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* build textarea for CSS */
        echo '<textarea class="hidden" id="textarea_' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_name ) .'">' . esc_attr( $field_value ) . '</textarea>';
    
        /* build pre to convert it into ace editor later */
        echo '<pre class="ot-javascript-editor ' . esc_attr( $field_class ) . '" id="' . esc_attr( $field_id ) . '">' . esc_textarea( $field_value ) . '</pre>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Link Color option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The markup.
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_link_color' ) ) {

  function ot_type_link_color( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-link-color ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        /* allow fields to be filtered */
        $ot_recognized_link_color_fields = apply_filters( 'ot_recognized_link_color_fields', array(
          'link'    => _x( 'Standard', 'color picker', 'eventstation' ),
          'hover'   => _x( 'Hover', 'color picker', 'eventstation' ),
          'active'  => _x( 'Active', 'color picker', 'eventstation' ),
          'visited' => _x( 'Visited', 'color picker', 'eventstation' ),
          'focus'   => _x( 'Focus', 'color picker', 'eventstation' )
        ), $field_id );

        /* build link color fields */
        foreach( $ot_recognized_link_color_fields as $type => $label ) {

          if ( array_key_exists( $type, $ot_recognized_link_color_fields ) ) {
            
            echo '<div class="option-tree-ui-colorpicker-input-wrap">';

              echo '<label for="' . esc_attr( $field_id ) . '-picker-' . $type . '" class="option-tree-ui-colorpicker-label">' . esc_attr( $label ) . '</label>';

              /* colorpicker JS */
              echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker-' . $type . '"); });</script>';

              /* set color */
              $color = isset( $field_value[ $type ] ) ? esc_attr( $field_value[ $type ] ) : '';
              
              /* set default color */
              $std = isset( $field_std[ $type ] ) ? 'data-default-color="' . $field_std[ $type ] . '"' : '';

              /* input */
              echo '<input type="text" name="' . esc_attr( $field_name ) . '[' . $type . ']" id="' . esc_attr( $field_id ) . '-picker-' . $type . '" value="' . $color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" ' . $std . ' />';

            echo '</div>';

          }

        }

      echo '</div>';

    echo '</div>';

  }

}

/**
 * List Item option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_list_item' ) ) {
  
  function ot_type_list_item( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;

    // Default
    $sortable = true;

    // Check if the list can be sorted
    if ( ! empty( $field_class ) ) {
      $classes = explode( ' ', $field_class );
      if ( in_array( 'not-sortable', $classes ) ) {
        $sortable = false;
        str_replace( 'not-sortable', '', $field_class );
      }
    }

    /* format setting outer wrapper */
    echo '<div class="format-setting type-list-item ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* pass the settings array arround */
        echo '<input type="hidden" name="' . esc_attr( $field_id ) . '_settings_array" id="' . esc_attr( $field_id ) . '_settings_array" value="' . ot_encode( serialize( $field_settings ) ) . '" />';
        
        /** 
         * settings pages have array wrappers like 'option_tree'.
         * So we need that value to create a proper array to save to.
         * This is only for NON metabox settings.
         */
        if ( ! isset( $get_option ) )
          $get_option = '';
          
        /* build list items */
        echo '<ul class="option-tree-setting-wrap' . ( $sortable ? ' option-tree-sortable' : '' ) .'" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-get-option="' . esc_attr( $get_option ) . '" data-type="' . esc_attr( $type ) . '">';
        
        if ( is_array( $field_value ) && ! empty( $field_value ) ) {
        
          foreach( $field_value as $key => $list_item ) {
            
            echo '<li class="ui-state-default list-list-item">';
              ot_list_item_view( $field_id, $key, $list_item, $post_id, $get_option, $field_settings, $type );
            echo '</li>';
            
          }
          
        }
        
        echo '</ul>';
        
        /* button */
        echo '<a href="javascript:void(0);" class="option-tree-list-item-add option-tree-ui-button button button-primary right hug-right" title="' . esc_html__( 'Add New', 'eventstation' ) . '">' . esc_html__( 'Add New', 'eventstation' ) . '</a>';
        
        /* description */
        $list_desc = $sortable ? esc_html__( 'You can re-order with drag & drop, the order will update after saving.', 'eventstation' ) : '';
        echo '<div class="list-item-description">' . apply_filters( 'ot_list_item_description', $list_desc, $field_id ) . '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Measurement option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_measurement' ) ) {
  
  function ot_type_measurement( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-measurement ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        echo '<div class="option-tree-ui-measurement-input-wrap">';
        
          echo '<input type="text" name="' . esc_attr( $field_name ) . '[0]" id="' . esc_attr( $field_id ) . '-0" value="' . ( isset( $field_value[0] ) ? esc_attr( $field_value[0] ) : '' ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        
        echo '</div>';
        
        /* build measurement */
        echo '<select name="' . esc_attr( $field_name ) . '[1]" id="' . esc_attr( $field_id ) . '-1" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
          
          echo '<option value="">' . esc_html__( 'unit', 'eventstation' ) . '</option>';
          
          foreach ( ot_measurement_unit_types( $field_id ) as $unit ) {
            echo '<option value="' . esc_attr( $unit ) . '"' . ( isset( $field_value[1] ) ? selected( $field_value[1], $unit, false ) : '' ) . '>' . esc_attr( $unit ) . '</option>';
          }
          
        echo '</select>';
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Numeric Slider option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.1
 */
if ( ! function_exists( 'ot_type_numeric_slider' ) ) {

  function ot_type_numeric_slider( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    $_options = explode( ',', $field_min_max_step );
    $min = isset( $_options[0] ) ? $_options[0] : 0;
    $max = isset( $_options[1] ) ? $_options[1] : 100;
    $step = isset( $_options[2] ) ? $_options[2] : 1;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-numeric-slider ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        echo '<div class="ot-numeric-slider-wrap">';

          echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="ot-numeric-slider-hidden-input" value="' . esc_attr( $field_value ) . '" data-min="' . esc_attr( $min ) . '" data-max="' . esc_attr( $max ) . '" data-step="' . esc_attr( $step ) . '">';

          echo '<input type="text" class="ot-numeric-slider-helper-input widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" value="' . esc_attr( $field_value ) . '" readonly>';

          echo '<div id="ot_numeric_slider_' . esc_attr( $field_id ) . '" class="ot-numeric-slider"></div>';

        echo '</div>';
      
      echo '</div>';
      
    echo '</div>';
  }

}

/**
 * On/Off option type
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The gallery metabox markup.
 *
 * @access    public
 * @since     2.2.0
 */
if ( ! function_exists( 'ot_type_on_off' ) ) {

  function ot_type_on_off( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        /* Force only two choices, and allowing filtering on the choices value & label */
        $field_choices = array(
          array(
            /**
             * Filter the value of the On button.
             *
             * @since 2.5.0
             *
             * @param string The On button value. Default 'on'.
             * @param string $field_id The field ID.
             * @param string $filter_id For filtering both on/off value with one function.
             */
            'value'   => apply_filters( 'ot_on_off_switch_on_value', 'on', $field_id, 'on' ),
            /**
             * Filter the label of the On button.
             *
             * @since 2.5.0
             *
             * @param string The On button label. Default 'On'.
             * @param string $field_id The field ID.
             * @param string $filter_id For filtering both on/off label with one function.
             */
            'label'   => apply_filters( 'ot_on_off_switch_on_label', esc_html__( 'On', 'eventstation' ), $field_id, 'on' )
          ),
          array(
            /**
             * Filter the value of the Off button.
             *
             * @since 2.5.0
             *
             * @param string The Off button value. Default 'off'.
             * @param string $field_id The field ID.
             * @param string $filter_id For filtering both on/off value with one function.
             */
            'value'   => apply_filters( 'ot_on_off_switch_off_value', 'off', $field_id, 'off' ),
            /**
             * Filter the label of the Off button.
             *
             * @since 2.5.0
             *
             * @param string The Off button label. Default 'Off'.
             * @param string $field_id The field ID.
             * @param string $filter_id For filtering both on/off label with one function.
             */
            'label'   => apply_filters( 'ot_on_off_switch_off_label', esc_html__( 'Off', 'eventstation' ), $field_id, 'off' )
          )
        );

        /**
         * Filter the width of the On/Off switch.
         *
         * @since 2.5.0
         *
         * @param string The switch width. Default '100px'.
         * @param string $field_id The field ID.
         */
        $switch_width = apply_filters( 'ot_on_off_switch_width', '100px', $field_id );

        echo '<div class="on-off-switch"' . ( $switch_width != '100px' ? sprintf( ' style="width:%s"', $switch_width ) : '' ) . '>';

        /* build radio */
        foreach ( (array) $field_choices as $key => $choice ) {
          echo '
            <input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="radio option-tree-ui-radio ' . esc_attr( $field_class ) . '" />
            <label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" onclick="">' . esc_attr( $choice['label'] ) . '</label>';
        }

          echo '<span class="slide-button"></span>';

        echo '</div>';

      echo '</div>';

    echo '</div>';

  }

}

/**
 * Page Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_page_checkbox' ) ) {
  
  function ot_type_page_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-page-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

      /* query pages array */
      $my_posts = get_posts( apply_filters( 'ot_type_page_checkbox_query', array( 'post_type' => array( 'page' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );

      /* has pages */
      if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
        foreach( $my_posts as $my_post ) {
          $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
          echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[$my_post->ID] ) ? checked( $field_value[$my_post->ID], $my_post->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
          echo '</p>';
        }
      } else {
        echo '<p>' . esc_html__( 'No Pages Found', 'eventstation' ) . '</p>';
      }
      
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Page Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_page_select' ) ) {
  
  function ot_type_page_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-page-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build page select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* query pages array */
        $my_posts = get_posts( apply_filters( 'ot_type_page_select_query', array( 'post_type' => array( 'page' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has pages */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          echo '<option value="">-- ' . esc_html__( 'Choose One', 'eventstation' ) . ' --</option>';
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $field_value, $my_post->ID, false ) . '>' . $post_title . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Pages Found', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Post Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_post_checkbox' ) ) {
  
  function ot_type_post_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* query posts array */
        $my_posts = get_posts( apply_filters( 'ot_type_post_checkbox_query', array( 'post_type' => array( 'post' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[$my_post->ID] ) ? checked( $field_value[$my_post->ID], $my_post->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . esc_html__( 'No Posts Found', 'eventstation' ) . '</p>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Post Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_post_select' ) ) {
  
  function ot_type_post_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build page select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* query posts array */
        $my_posts = get_posts( apply_filters( 'ot_type_post_select_query', array( 'post_type' => array( 'post' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          echo '<option value="">-- ' . esc_html__( 'Choose One', 'eventstation' ) . ' --</option>';
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $field_value, $my_post->ID, false ) . '>' . $post_title . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Posts Found', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Radio option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_radio' ) ) {
  
  function ot_type_radio( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build radio */
        foreach ( (array) $field_choices as $key => $choice ) {
          echo '<p><input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="radio option-tree-ui-radio ' . esc_attr( $field_class ) . '" /><label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label></p>';
        }
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Radio Images option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_radio_image' ) ) {
  
  function ot_type_radio_image( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio-image ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /**
         * load the default filterable images if nothing 
         * has been set in the choices array.
         */
        if ( empty( $field_choices ) )
          $field_choices = ot_radio_images( $field_id );
          
        /* build radio image */
        foreach ( (array) $field_choices as $key => $choice ) {
          
          $src = str_replace( 'OT_URL', OT_URL, $choice['src'] );
          $src = str_replace( 'OT_THEME_URL', OT_THEME_URL, $src );
          
          /* make radio image source filterable */
          $src = apply_filters( 'ot_type_radio_image_src', $src, $field_id );
          
          /**
           * Filter the image attributes.
           *
           * @since 2.5.3
           *
           * @param string $attributes The image attributes.
           * @param string $field_id The field ID.
           * @param array $choice The choice.
           */
          $attributes = apply_filters( 'ot_type_radio_image_attributes', '', $field_id, $choice );
          
          echo '<div class="option-tree-ui-radio-images">';
            echo '<p style="display:none"><input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label></p>';
            echo '<img ' . $attributes . ' src="' . esc_url( $src ) . '" alt="' . esc_attr( $choice['label'] ) .'" title="' . esc_attr( $choice['label'] ) .'" class="option-tree-ui-radio-image ' . esc_attr( $field_class ) . ( $field_value == $choice['value'] ? ' option-tree-ui-radio-image-selected' : '' ) . '" />';
          echo '</div>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_select' ) ) {
  
  function ot_type_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* filter choices array */
      $field_choices = apply_filters( 'ot_type_select_choices', $field_choices, $field_id );
    
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
        foreach ( (array) $field_choices as $choice ) {
          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
            echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $field_value, $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
          }
        }
        
        echo '</select>';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Sidebar Select option type.
 *
 * This option type makes it possible for users to select a WordPress registered sidebar 
 * to use on a specific area. By using the two provided filters, 'ot_recognized_sidebars', 
 * and 'ot_recognized_sidebars_{$field_id}' we can be selective about which sidebars are 
 * available on a specific content area.
 *
 * For example, if we create a WordPress theme that provides the ability to change the 
 * Blog Sidebar and we don't want to have the footer sidebars available on this area, 
 * we can unset those sidebars either manually or by using a regular expression if we 
 * have a common name like footer-sidebar-$i.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.1
 */
if ( ! function_exists( 'ot_type_sidebar_select' ) ) {
  
  function ot_type_sidebar_select( $args = array() ) {
  
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-sidebar-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build page select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';

        /* get the registered sidebars */
        global $wp_registered_sidebars;

        $sidebars = array();
        foreach( $wp_registered_sidebars as $id=>$sidebar ) {
          $sidebars[ $id ] = $sidebar[ 'name' ];
        }

        /* filters to restrict which sidebars are allowed to be selected, for example we can restrict footer sidebars to be selectable on a blog page */
        $sidebars = apply_filters( 'ot_recognized_sidebars', $sidebars );
        $sidebars = apply_filters( 'ot_recognized_sidebars_' . $field_id, $sidebars );

        /* has sidebars */
        if ( count( $sidebars ) ) {
          echo '<option value="">-- ' . esc_html__( 'Choose Sidebar', 'eventstation' ) . ' --</option>';
          foreach ( $sidebars as $id => $sidebar ) {
            echo '<option value="' . esc_attr( $id ) . '"' . selected( $field_value, $id, false ) . '>' . esc_attr( $sidebar ) . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Sidebars', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * List Item option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_slider' ) ) {
  
  function ot_type_slider( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-slider ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* pass the settings array arround */
        echo '<input type="hidden" name="' . esc_attr( $field_id ) . '_settings_array" id="' . esc_attr( $field_id ) . '_settings_array" value="' . ot_encode( serialize( $field_settings ) ) . '" />';
        
        /** 
         * settings pages have array wrappers like 'option_tree'.
         * So we need that value to create a proper array to save to.
         * This is only for NON metabox settings.
         */
        if ( ! isset( $get_option ) )
          $get_option = '';
          
        /* build list items */
        echo '<ul class="option-tree-setting-wrap option-tree-sortable" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-get-option="' . esc_attr( $get_option ) . '" data-type="' . esc_attr( $type ) . '">';
        
        if ( is_array( $field_value ) && ! empty( $field_value ) ) {
        
          foreach( $field_value as $key => $list_item ) {
            
            echo '<li class="ui-state-default list-list-item">';
              ot_list_item_view( $field_id, $key, $list_item, $post_id, $get_option, $field_settings, $type );
            echo '</li>';
            
          }
          
        }
        
        echo '</ul>';
        
        /* button */
        echo '<a href="javascript:void(0);" class="option-tree-list-item-add option-tree-ui-button button button-primary right hug-right" title="' . esc_html__( 'Add New', 'eventstation' ) . '">' . esc_html__( 'Add New', 'eventstation' ) . '</a>';
        
        /* description */
        echo '<div class="list-item-description">' . esc_html__( 'You can re-order with drag & drop, the order will update after saving.', 'eventstation' ) . '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Social Links option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.4.0
 */
if ( ! function_exists( 'ot_type_social_links' ) ) {
  
  function ot_type_social_links( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* Load the default social links */
    if ( empty( $field_value ) && apply_filters( 'ot_type_social_links_load_defaults', true, $field_id ) ) {
      
      $field_value = apply_filters( 'ot_type_social_links_defaults', array(
        array(
          'name'    => esc_html__( 'Facebook', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Twitter', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Google+', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'LinkedIn', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Pinterest', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Youtube', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Dribbble', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Github', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Forrst', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Digg', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Delicious', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Tumblr', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Skype', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'SoundCloud', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Vimeo', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'Flickr', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        ),
        array(
          'name'    => esc_html__( 'VK.com', 'eventstation' ),
          'title'   => '',
          'href'    => ''
        )
      ), $field_id );
      
    }
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-social-list-item ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* pass the settings array arround */
        echo '<input type="hidden" name="' . esc_attr( $field_id ) . '_settings_array" id="' . esc_attr( $field_id ) . '_settings_array" value="' . ot_encode( serialize( $field_settings ) ) . '" />';
        
        /** 
         * settings pages have array wrappers like 'option_tree'.
         * So we need that value to create a proper array to save to.
         * This is only for NON metabox settings.
         */
        if ( ! isset( $get_option ) )
          $get_option = '';
          
        /* build list items */
        echo '<ul class="option-tree-setting-wrap option-tree-sortable" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-get-option="' . esc_attr( $get_option ) . '" data-type="' . esc_attr( $type ) . '">';
        
        if ( is_array( $field_value ) && ! empty( $field_value ) ) {
        
          foreach( $field_value as $key => $link ) {
            
            echo '<li class="ui-state-default list-list-item">';
              ot_social_links_view( $field_id, $key, $link, $post_id, $get_option, $field_settings, $type );
            echo '</li>';
            
          }
          
        }
        
        echo '</ul>';
        
        /* button */
        echo '<a href="javascript:void(0);" class="option-tree-social-links-add option-tree-ui-button button button-primary right hug-right" title="' . esc_html__( 'Add New', 'eventstation' ) . '">' . esc_html__( 'Add New', 'eventstation' ) . '</a>';
        
        /* description */
        echo '<div class="list-item-description">' . apply_filters( 'ot_social_links_description', esc_html__( 'You can re-order with drag & drop, the order will update after saving.', 'eventstation' ), $field_id ) . '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Spacing Option Type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.5.0
 */
if ( ! function_exists( 'ot_type_spacing' ) ) {

  function ot_type_spacing( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-spacing ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        /* allow fields to be filtered */
        $ot_recognized_spacing_fields = apply_filters( 'ot_recognized_spacing_fields', array(
          'top',
          'right',
          'bottom',
          'left',
          'unit'
        ), $field_id );

        /* build top spacing */
        if ( in_array( 'top', $ot_recognized_spacing_fields ) ) {

          $top = isset( $field_value['top'] ) ? esc_attr( $field_value['top'] ) : '';

          echo '<div class="ot-option-group"><span class="ot-icon-arrow-up ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[top]" id="' . esc_attr( $field_id ) . '-top" value="' . $top . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'top', 'eventstation' ) . '" /></div>';

        }

        /* build right spacing */
        if ( in_array( 'right', $ot_recognized_spacing_fields ) ) {

          $right = isset( $field_value['right'] ) ? esc_attr( $field_value['right'] ) : '';

          echo '<div class="ot-option-group"><span class="ot-icon-arrow-right ot-option-group--icon"></span></span><input type="text" name="' . esc_attr( $field_name ) . '[right]" id="' . esc_attr( $field_id ) . '-right" value="' . $right . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'right', 'eventstation' ) . '" /></div>';

        }

        /* build bottom spacing */
        if ( in_array( 'bottom', $ot_recognized_spacing_fields ) ) {

          $bottom = isset( $field_value['bottom'] ) ? esc_attr( $field_value['bottom'] ) : '';

          echo '<div class="ot-option-group"><span class="ot-icon-arrow-down ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[bottom]" id="' . esc_attr( $field_id ) . '-bottom" value="' . $bottom . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'bottom', 'eventstation' ) . '" /></div>';

        }

        /* build left spacing */
        if ( in_array( 'left', $ot_recognized_spacing_fields ) ) {

          $left = isset( $field_value['left'] ) ? esc_attr( $field_value['left'] ) : '';

          echo '<div class="ot-option-group"><span class="ot-icon-arrow-left ot-option-group--icon"></span><input type="text" name="' . esc_attr( $field_name ) . '[left]" id="' . esc_attr( $field_id ) . '-left" value="' . $left . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . esc_html__( 'left', 'eventstation' ) . '" /></div>';

        }

      /* build unit dropdown */
      if ( in_array( 'unit', $ot_recognized_spacing_fields ) ) {
        
        echo '<div class="ot-option-group ot-option-group--is-last">';
        
          echo '<select name="' . esc_attr( $field_name ) . '[unit]" id="' . esc_attr( $field_id ) . '-unit" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
  
            echo '<option value="">' . esc_html__( 'unit', 'eventstation' ) . '</option>';
  
            foreach ( ot_recognized_spacing_unit_types( $field_id ) as $unit ) {
              echo '<option value="' . esc_attr( $unit ) . '"' . ( isset( $field_value['unit'] ) ? selected( $field_value['unit'], $unit, false ) : '' ) . '>' . esc_attr( $unit ) . '</option>';
            }
  
          echo '</select>';
        
        echo '</div>';

      }
      
      echo '</div>';

    echo '</div>';

  }

}

/**
 * Tab option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.3.0
 */
if ( ! function_exists( 'ot_type_tab' ) ) {
  
  function ot_type_tab( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tab">';

      echo '<br />';
    
    echo '</div>';
    
  }
  
}

/**
 * Tag Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_tag_checkbox' ) ) {
  
  function ot_type_tag_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tag-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* get tags */
        $tags = get_tags( array( 'hide_empty' => false ) );
        
        /* has tags */
        if ( $tags ) {
          foreach( $tags as $tag ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $tag->term_id ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $tag->term_id ) . '" value="' . esc_attr( $tag->term_id ) . '" ' . ( isset( $field_value[$tag->term_id] ) ? checked( $field_value[$tag->term_id], $tag->term_id, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $tag->term_id ) . '">' . esc_attr( $tag->name ) . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . esc_html__( 'No Tags Found', 'eventstation' ) . '</p>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Tag Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_tag_select' ) ) {
  
  function ot_type_tag_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tag-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build tag select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* get tags */
        $tags = get_tags( array( 'hide_empty' => false ) );
        
        /* has tags */
        if ( $tags ) {
          echo '<option value="">-- ' . esc_html__( 'Choose One', 'eventstation' ) . ' --</option>';
          foreach( $tags as $tag ) {
            echo '<option value="' . esc_attr( $tag->term_id ) . '"' . selected( $field_value, $tag->term_id, false ) . '>' . esc_attr( $tag->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Tags Found', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Taxonomy Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_taxonomy_checkbox' ) ) {
  
  function ot_type_taxonomy_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-taxonomy-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* setup the taxonomy */
        $taxonomy = isset( $field_taxonomy ) ? explode( ',', $field_taxonomy ) : array( 'category' );
        
        /* get taxonomies */
        $taxonomies = get_categories( apply_filters( 'ot_type_taxonomy_checkbox_query', array( 'hide_empty' => false, 'taxonomy' => $taxonomy ), $field_id ) );
        
        /* has tags */
        if ( $taxonomies ) {
          foreach( $taxonomies as $taxonomy ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $taxonomy->term_id ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $taxonomy->term_id ) . '" value="' . esc_attr( $taxonomy->term_id ) . '" ' . ( isset( $field_value[$taxonomy->term_id] ) ? checked( $field_value[$taxonomy->term_id], $taxonomy->term_id, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $taxonomy->term_id ) . '">' . esc_attr( $taxonomy->name ) . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . esc_html__( 'No Taxonomies Found', 'eventstation' ) . '</p>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Taxonomy Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_taxonomy_select' ) ) {
  
  function ot_type_taxonomy_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tag-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build tag select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* setup the taxonomy */
        $taxonomy = isset( $field_taxonomy ) ? explode( ',', $field_taxonomy ) : array( 'category' );
        
        /* get taxonomies */
        $taxonomies = get_categories( apply_filters( 'ot_type_taxonomy_select_query', array( 'hide_empty' => false, 'taxonomy' => $taxonomy ), $field_id ) );
        
        /* has tags */
        if ( $taxonomies ) {
          echo '<option value="">-- ' . esc_html__( 'Choose One', 'eventstation' ) . ' --</option>';
          foreach( $taxonomies as $taxonomy ) {
            echo '<option value="' . esc_attr( $taxonomy->term_id ) . '"' . selected( $field_value, $taxonomy->term_id, false ) . '>' . esc_attr( $taxonomy->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . esc_html__( 'No Taxonomies Found', 'eventstation' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Text option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_text' ) ) {
  
  function ot_type_text( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-text ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build text input */
        echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Textarea option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_textarea' ) ) {
  
  function ot_type_textarea( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textarea ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . ' fill-area">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build textarea */
        wp_editor( 
          $field_value, 
          esc_attr( $field_id ), 
          array(
            'editor_class'  => esc_attr( $field_class ),
            'wpautop'       => apply_filters( 'ot_wpautop', false, $field_id ),
            'media_buttons' => apply_filters( 'ot_media_buttons', true, $field_id ),
            'textarea_name' => esc_attr( $field_name ),
            'textarea_rows' => esc_attr( $field_rows ),
            'tinymce'       => apply_filters( 'ot_tinymce', true, $field_id ),              
            'quicktags'     => apply_filters( 'ot_quicktags', array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ), $field_id )
          ) 
        );
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Textarea Simple option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_textarea_simple' ) ) {
  
  function ot_type_textarea_simple( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textarea simple ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* filter to allow wpautop */
        $wpautop = apply_filters( 'ot_wpautop', false, $field_id );
        
        /* wpautop $field_value */
        if ( $wpautop == true ) 
          $field_value = wpautop( $field_value );
        
        /* build textarea simple */
        echo '<textarea class="textarea ' . esc_attr( $field_class ) . '" rows="' . esc_attr( $field_rows )  . '" cols="40" name="' . esc_attr( $field_name ) .'" id="' . esc_attr( $field_id ) . '">' . esc_textarea( $field_value ) . '</textarea>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Textblock option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_textblock' ) ) {
  
  function ot_type_textblock( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textblock wide-desc">';
      
      /* description */
      echo '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Textblock Titled option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_textblock_titled' ) ) {
  
  function ot_type_textblock_titled( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textblock titled wide-desc">';
      
      /* description */
      echo '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Typography option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_typography' ) ) {
  
  function ot_type_typography( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-typography ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* allow fields to be filtered */
        $ot_recognized_typography_fields = apply_filters( 'ot_recognized_typography_fields', array( 
          'font-color',
          'font-family', 
          'font-size', 
          'font-style', 
          'font-variant', 
          'font-weight', 
          'letter-spacing', 
          'line-height', 
          'text-decoration', 
          'text-transform' 
        ), $field_id );
        
        /* build font color */
        if ( in_array( 'font-color', $ot_recognized_typography_fields ) ) {
          
          /* build colorpicker */  
          echo '<div class="option-tree-ui-colorpicker-input-wrap">';
            
            /* colorpicker JS */      
            echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
            
            /* set background color */
            $background_color = isset( $field_value['font-color'] ) ? esc_attr( $field_value['font-color'] ) : '';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[font-color]" id="' . esc_attr( $field_id ) . '-picker" value="' . esc_attr( $background_color ) . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
          
          echo '</div>';
        
        }
        
        /* build font family */
        if ( in_array( 'font-family', $ot_recognized_typography_fields ) ) {
          $font_family = isset( $field_value['font-family'] ) ? $field_value['font-family'] : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-family]" id="' . esc_attr( $field_id ) . '-font-family" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-family</option>';
            foreach ( ot_recognized_font_families( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_family, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font size */
        if ( in_array( 'font-size', $ot_recognized_typography_fields ) ) {
          $font_size = isset( $field_value['font-size'] ) ? esc_attr( $field_value['font-size'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-size]" id="' . esc_attr( $field_id ) . '-font-size" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-size</option>';
            foreach( ot_recognized_font_sizes( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $font_size, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font style */
        if ( in_array( 'font-style', $ot_recognized_typography_fields ) ) {
          $font_style = isset( $field_value['font-style'] ) ? esc_attr( $field_value['font-style'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-style]" id="' . esc_attr( $field_id ) . '-font-style" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-style</option>';
            foreach ( ot_recognized_font_styles( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_style, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font variant */
        if ( in_array( 'font-variant', $ot_recognized_typography_fields ) ) {
          $font_variant = isset( $field_value['font-variant'] ) ? esc_attr( $field_value['font-variant'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-variant]" id="' . esc_attr( $field_id ) . '-font-variant" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-variant</option>';
            foreach ( ot_recognized_font_variants( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_variant, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font weight */
        if ( in_array( 'font-weight', $ot_recognized_typography_fields ) ) {
          $font_weight = isset( $field_value['font-weight'] ) ? esc_attr( $field_value['font-weight'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-weight]" id="' . esc_attr( $field_id ) . '-font-weight" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-weight</option>';
            foreach ( ot_recognized_font_weights( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_weight, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build letter spacing */
        if ( in_array( 'letter-spacing', $ot_recognized_typography_fields ) ) {
          $letter_spacing = isset( $field_value['letter-spacing'] ) ? esc_attr( $field_value['letter-spacing'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[letter-spacing]" id="' . esc_attr( $field_id ) . '-letter-spacing" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">letter-spacing</option>';
            foreach( ot_recognized_letter_spacing( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $letter_spacing, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build line height */
        if ( in_array( 'line-height', $ot_recognized_typography_fields ) ) {
          $line_height = isset( $field_value['line-height'] ) ? esc_attr( $field_value['line-height'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[line-height]" id="' . esc_attr( $field_id ) . '-line-height" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">line-height</option>';
            foreach( ot_recognized_line_heights( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $line_height, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text decoration */
        if ( in_array( 'text-decoration', $ot_recognized_typography_fields ) ) {
          $text_decoration = isset( $field_value['text-decoration'] ) ? esc_attr( $field_value['text-decoration'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-decoration]" id="' . esc_attr( $field_id ) . '-text-decoration" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-decoration</option>';
            foreach ( ot_recognized_text_decorations( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_decoration, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text transform */
        if ( in_array( 'text-transform', $ot_recognized_typography_fields ) ) {
          $text_transform = isset( $field_value['text-transform'] ) ? esc_attr( $field_value['text-transform'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-transform]" id="' . esc_attr( $field_id ) . '-text-transform" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-transform</option>';
            foreach ( ot_recognized_text_transformations( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_transform, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Upload option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_upload' ) ) {
  
  function ot_type_upload( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* If an attachment ID is stored here fetch its URL and replace the value */
    if ( $field_value && wp_attachment_is_image( $field_value ) ) {
    
      $attachment_data = wp_get_attachment_image_src( $field_value, 'original' );
      
      /* check for attachment data */
      if ( $attachment_data ) {
      
        $field_src = $attachment_data[0];
        
      }
      
    }
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-upload ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build upload */
        echo '<div class="option-tree-ui-upload-parent">';
          
          /* input */
          echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-upload-input ' . esc_attr( $field_class ) . '" />';
          
          /* add media button */
          echo '<a href="javascript:void(0);" class="ot_upload_media option-tree-ui-button button button-primary light" rel="' . $post_id . '" title="' . esc_html__( 'Add Media', 'eventstation' ) . '"><span class="icon ot-icon-plus-circle"></span>' . esc_html__( 'Add Media', 'eventstation' ) . '</a>';
        
        echo '</div>';
        
        /* media */
        if ( $field_value ) {
            
          echo '<div class="option-tree-ui-media-wrap" id="' . esc_attr( $field_id ) . '_media">';
            
            /* replace image src */
            if ( isset( $field_src ) )
              $field_value = $field_src;
              
            if ( preg_match( '/\.(?:jpe?g|png|gif|ico)$/i', $field_value ) )
              echo '<div class="option-tree-ui-image-wrap"><img src="' . esc_url( $field_value ) . '" alt="" /></div>';
            
            echo '<a href="javascript:(void);" class="option-tree-ui-remove-media option-tree-ui-button button button-secondary light" title="' . esc_html__( 'Remove Media', 'eventstation' ) . '"><span class="icon ot-icon-minus-circle"></span>' . esc_html__( 'Remove Media', 'eventstation' ) . '</a>';
            
          echo '</div>';
          
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/* End of file ot-functions-option-types.php */
/* Location: ./includes/ot-functions-option-types.php */
