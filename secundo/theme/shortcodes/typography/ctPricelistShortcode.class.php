<?php
/**
 * Pricelist shortcode
 */
class ctPricelistShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Pricelist';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'pricelist';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		//style
		switch ($style) {
			case 'basic':
				$class = '';
				break;
			case 'distinctive':
				$class = ' spec';
				break;
			default:
				$class = '';
		}

		//content
		$content = $content ? ($content . '<hr>') : '';

		//button
		$buttonHtml = $buttonlabel ? ('<a href="' . $buttonlink . '" class="btn vorange vlarge">' . $buttonlabel . '</a>') : '';

		return do_shortcode('<div class="priceBox' . $class .  '">
			                    <div class="wallp">
			                        <h3 class="vmedium">' . $title . '</h3>
			                        <hr>
			                        <h4><sup>' . $currency . '</sup>' . $price . '</h4>
			                        <span class="forTime">' . $subprice . '</span>
			                        <hr>' . $content . $buttonHtml . '
			                    </div>
			                </div>');
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input'),
			'currency' => array('label' => __('currency', 'ct_theme'), 'default' => __('$', 'ct_theme'), 'type' => 'input'),
			'price' => array('label' => __('price', 'ct_theme'), 'default' => '', 'type' => 'input','example'=>'456,50'),
			'subprice' => array('label' => __('subprice', 'ct_theme'), 'default' => '', 'type' => 'input'),
			'buttonlabel' => array('default' => '', 'type' => 'input', 'label' => __("button label", 'ct_theme')),
			'buttonlink' => array('default' => '#', 'type' => 'input', 'label' => __("button link", 'ct_theme')),
			'style' => array('label' => __('style', 'ct_theme'), 'default' => 'basic', 'type' => 'select', 'choices' => array('basic' => __('basic', 'ct_theme'), 'distinctive' => __('distinctive', 'ct_theme')), 'help' => __('Section style', 'ct_theme'),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
			));

	}
}

new ctPricelistShortcode();
