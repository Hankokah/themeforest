<?php
namespace Hashmag\Modules\Shortcodes\Button;

use Hashmag\Modules\Shortcodes\Lib\ShortcodeInterface;


/**
 * Class Button that represents button shortcode
 * @package Hashmag\Modules\Shortcodes\Button
 */
class Button implements ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    /**
     * Sets base attribute and registers shortcode with Visual Composer
     */
    public function __construct() {
        $this->base = 'mkdf_button';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base attribute
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Maps shortcode to Visual Composer
     */
    public function vcMap() {
        vc_map(array(
            'name'                      => esc_html__('Mikado Button', 'hashmag'),
            'base'                      => $this->base,
            'category'                  => 'by MIKADO',
            'admin_enqueue_css' => array(hashmag_mikado_get_skin_uri().'/assets/css/mkdf-vc-extend.css'),
            'icon'                      => 'icon-wpb-button extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'params'                    => array_merge(
                array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => 'Size',
                        'param_name'  => 'size',
                        'value'       => array(
                            'Default'                => '',
                            'Small'                  => 'small',
                            'Medium'                 => 'medium',
                            'Large'                  => 'large',
                            'Full Width'            => 'huge'
                        ),
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => 'Type',
                        'param_name'  => 'type',
                        'value'       => array(
                            'Default' => '',
                            'Outline' => 'outline',
                            'Solid'   => 'solid',
                        ),
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Text',
                        'param_name'  => 'text',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Link',
                        'param_name'  => 'link',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => 'Link Target',
                        'param_name'  => 'target',
                        'value'       => array(
                            'Self'  => '_self',
                            'Blank' => '_blank'
                        ),
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Custom CSS class',
                        'param_name'  => 'custom_class',
                        'admin_label' => true
                    )
                ),
                hashmag_mikado_icon_collections()->getVCParamsArray(array(), '', true),
                array(
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Color',
                        'param_name'  => 'color',
                        'group'       => 'Design Options',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Hover Color',
                        'param_name'  => 'hover_color',
                        'group'       => 'Design Options',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Background Color',
                        'param_name'  => 'background_color',
                        'admin_label' => true,
                        'dependency'  => array('element' => 'type', 'value' => array('solid','')),
                        'group'       => 'Design Options'
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Hover Background Color',
                        'param_name'  => 'hover_background_color',
                        'admin_label' => true,
                        'group'       => 'Design Options'
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Border Color',
                        'param_name'  => 'border_color',
                        'admin_label' => true,
                        'group'       => 'Design Options'
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Hover Border Color',
                        'param_name'  => 'hover_border_color',
                        'admin_label' => true,
                        'group'       => 'Design Options'
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Font Size (px)',
                        'param_name'  => 'font_size',
                        'admin_label' => true,
                        'group'       => 'Design Options'
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => 'Font Weight',
                        'param_name'  => 'font_weight',
                        'value'       => array_flip(hashmag_mikado_get_font_weight_array(true)),
                        'admin_label' => true,
                        'group'       => 'Design Options',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Margin',
                        'param_name'  => 'margin',
                        'description' => esc_html__('Insert margin in format: 0px 0px 1px 0px', 'hashmag'),
                        'admin_label' => true,
                        'group'       => 'Design Options'
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Background Color',
                        'param_name'  => 'icon_background_color',
                        'admin_label' => true,
                        'dependency'  => array('element' => 'icon_pack', 'not_empty' => true),
                        'group'       => 'Icon Options',
                        'description' => 'Will not influence outline type'
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => 'Hover Background Color',
                        'param_name'  => 'icon_hover_background_color',
                        'admin_label' => true,
                        'dependency'  => array('element' => hashmag_mikado_icon_collections()->iconPackParamName, 'not_empty' => true),
                        'group'       => 'Icon Options',
                        'description' => 'Will not influence outline type'
                    ),
                )
            ) //close array_merge
        ));
    }

    /**
     * Renders HTML for button shortcode
     *
     * @param array $atts
     * @param null $content
     *
     * @return string
     */
    public function render($atts, $content = null) {
        $default_atts = array(
            'size'                   => '',
            'type'                   => '',
            'text'                   => '',
            'link'                   => '',
            'target'                 => '',
            'color'                  => '',
            'hover_color'            => '',
            'background_color'       => '',
            'hover_background_color' => '',
            'border_color'           => '',
            'hover_border_color'     => '',
            'font_size'              => '',
            'font_weight'            => '',
            'margin'                 => '',
            'icon_background_color'  => '',
            'icon_hover_background_color'  => '',
            'custom_class'           => '',
            'html_type'              => 'anchor',
            'input_name'             => '',
            'hover_animation'        => '',
            'custom_attrs'           => array()
        );

        $default_atts = array_merge($default_atts, hashmag_mikado_icon_collections()->getShortcodeParams());
        $params       = shortcode_atts($default_atts, $atts);

        if($params['html_type'] !== 'input') {
            $iconPackName   = hashmag_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
            $params['icon'] = $iconPackName ? $params[$iconPackName] : '';
        }

        $params['size'] = !empty($params['size']) ? $params['size'] : 'medium';
        $params['type'] = !empty($params['type']) ? $params['type'] : 'solid';


        $params['link']   = !empty($params['link']) ? $params['link'] : '#';
        $params['target'] = !empty($params['target']) ? $params['target'] : '_self';

        //prepare params for template
        $params['button_classes']      = $this->getButtonClasses($params);
        $params['button_custom_attrs'] = !empty($params['custom_attrs']) ? $params['custom_attrs'] : array();
        $params['button_styles']       = $this->getButtonStyles($params);
        $params['button_data']         = $this->getButtonDataAttr($params);

        return hashmag_mikado_get_shortcode_module_template_part('templates/'.$params['html_type'], 'button', $params['hover_animation'], $params);
    }

    /**
     * Returns array of button styles
     *
     * @param $params
     *
     * @return array
     */
    private function getButtonStyles($params) {
        $styles = array();

        if(!empty($params['color'])) {
            $styles[] = 'color: '.$params['color'];
        }

        if(!empty($params['background_color']) && $params['type'] !== 'outline') {
            $styles[] = 'background-color: '.$params['background_color'];
        }

        if(!empty($params['border_color'])) {
            $styles[] = 'border: 1px solid '.$params['border_color'];
        }

        if(!empty($params['font_size'])) {
            $styles[] = 'font-size: '.hashmag_mikado_filter_px($params['font_size']).'px';
        }

        if(!empty($params['font_weight'])) {
            $styles[] = 'font-weight: '.$params['font_weight'];
        }

        if(!empty($params['margin'])) {
            $styles[] = 'margin: '.$params['margin'];
        }

        return $styles;
    }

    /**
     *
     * Returns array of button data attr
     *
     * @param $params
     *
     * @return array
     */
    private function getButtonDataAttr($params) {
        $data = array();

        if(!empty($params['hover_background_color'])) {
            $data['data-hover-bg-color'] = $params['hover_background_color'];
        }

        if(!empty($params['hover_color'])) {
            $data['data-hover-color'] = $params['hover_color'];
        }

        if(!empty($params['hover_color'])) {
            $data['data-hover-color'] = $params['hover_color'];
        }

        if(!empty($params['hover_border_color'])) {
            $data['data-hover-border-color'] = $params['hover_border_color'];
        }

        if(!empty($params['icon_hover_background_color'])) {
            $data['data-icon-bg-color'] = $params['icon_background_color'];
        }

        if(!empty($params['icon_hover_background_color'])) {
            $data['data-icon-hover-bg-color'] = $params['icon_hover_background_color'];
        }

        return $data;
    }

    /**
     * Returns array of HTML classes for button
     *
     * @param $params
     *
     * @return array
     */
    private function getButtonClasses($params) {
        $buttonClasses = array(
            'mkdf-btn',
            'mkdf-btn-'.$params['size'],
            'mkdf-btn-'.$params['type']
        );

        if(!empty($params['hover_background_color'])) {
            $buttonClasses[] = 'mkdf-btn-custom-hover-bg';
        }

        if(!empty($params['hover_border_color'])) {
            $buttonClasses[] = 'mkdf-btn-custom-border-hover';
        }

        if(!empty($params['hover_color'])) {
            $buttonClasses[] = 'mkdf-btn-custom-hover-color';
        }

        if(!empty($params['icon'])) {
            $buttonClasses[] = 'mkdf-btn-icon';
        }

        if(!empty($params['custom_class'])) {
            $buttonClasses[] = $params['custom_class'];
        }

        if(!empty($params['hover_animation'])) {
            $buttonClasses[] = 'mkdf-btn-'.$params['hover_animation'];
        }

        return $buttonClasses;
    }
}