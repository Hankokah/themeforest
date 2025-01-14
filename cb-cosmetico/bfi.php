<?php
/*
 * bfi_thumb - WP Image Resizer v1.1.1
 *
 * (c) 2013 Benjamin F. Intal / Gambit
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/** Uses WP's Image Editor Class to resize and filter images
 *
 * @param $url string the local image URL to manipulate
 * @param $params array the options to perform on the image. Keys and values supported:
 *          'width' int pixels
 *          'height' int pixels
 *          'opacity' int 0-100
 *          'color' string hex-color #000000-#ffffff
 *          'grayscale' bool
 *          'negate' bool
 *          'crop' bool
 * @param $single boolean, if false then an array of data will be returned
 * @return string|array containing the url of the resized modofied image
 */
function bfi_thumb($url, $params = array(), $single = true) {
	return BFI_Thumb::thumb($url, $params, $single);
}


// Change the default image editors
add_filter('wp_image_editors', 'bfi_wp_image_editor');

// Instead of using the default image editors, use our extended ones
function bfi_wp_image_editor($editorArray) {
	return array('BFI_Image_Editor_GD', 'BFI_Image_Editor_Imagick');
}

require_once ABSPATH . WPINC . '/class-wp-image-editor.php';
require_once ABSPATH . WPINC . '/class-wp-image-editor-imagick.php';
require_once ABSPATH . WPINC . '/class-wp-image-editor-gd.php';


/*
 * Enhanced Imagemagick Image Editor
 */
class BFI_Image_Editor_Imagick extends WP_Image_Editor_Imagick {

	/** Changes the opacity of the image
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @param float $opacity (0.0-1.0)
	 * @return boolean|WP_Error
	 */
	public function opacity($opacity) {
		$opacity /= 100;

		try {
			// From: http://stackoverflow.com/questions/3538851/php-imagick-setimageopacity-destroys-transparency-and-does-nothing
			// preserves transparency
			//$this->image->setImageOpacity($opacity);
			return $this->image->evaluateImage(Imagick::EVALUATE_MULTIPLY, $opacity, Imagick::CHANNEL_ALPHA);
		} catch ( Exception $e ) {
			return new WP_Error( 'image_opacity_error', $e->getMessage() );
		}
	}

	/** Tints the image a different color
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @param string hex color e.g. #ff00ff
	 * @return boolean|WP_Error
	 */
	public function colorize($hexColor) {
		try {
			return $this->image->colorizeImage($hexColor, 1.0);
		} catch (Exception $e) {
			return new WP_Error( 'image_colorize_error', $e->getMessage() );
		}
	}

	/** Makes the image grayscale
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @return boolean|WP_Error
	 */
	public function grayscale() {
		try {
			return $this->image->modulateImage(100,0,100);
		} catch (Exception $e) {
			return new WP_Error( 'image_grayscale_error', $e->getMessage() );
		}
	}

	/** Negates the image
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @return boolean|WP_Error
	 */
	public function negate() {
		try {
			return $this->image->negateImage(false);
		} catch (Exception $e) {
			return new WP_Error( 'image_negate_error', $e->getMessage() );
		}
	}
}



/*
 * Enhanced GD Image Editor
 */
class BFI_Image_Editor_GD extends WP_Image_Editor_GD {
	/** Rotates current image counter-clockwise by $angle.
	 * Ported from image-edit.php
	 * Added presevation of alpha channels
	 *
	 * @since 3.5.0
	 * @access public
	 *
	 * @param float $angle
	 * @return boolean|WP_Error
	 */
	public function rotate( $angle ) {
		if ( function_exists('imagerotate') ) {
			$rotated = imagerotate( $this->image, $angle, 0 );

			// Add alpha blending
			imagealphablending($rotated, true);
			imagesavealpha($rotated, true);

			if ( is_resource( $rotated ) ) {
				imagedestroy( $this->image );
				$this->image = $rotated;
				$this->update_size();
				return true;
			}
		}
		return new WP_Error( 'image_rotate_error', __('Image rotate failed.','cb-cosmetico'), $this->file );
	}

	/** Changes the opacity of the image
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @param float $opacity (0.0-1.0)
	 * @return boolean|WP_Error
	 */
	public function opacity($opacity) {
		$opacity /= 100;

		$filtered = $this->_opacity($this->image, $opacity);

		if (is_resource($filtered)) {
			// imagedestroy($this->image);
			$this->image = $filtered;
			return true;
		}

		return new WP_Error( 'image_opacity_error', __('Image opacity change failed.','cb-cosmetico'), $this->file );
	}

	// from: http://php.net/manual/en/function.imagefilter.php
	// params: image resource id, opacity (eg. 0.0-1.0)
	protected function _opacity($image, $opacity) {
		if (!function_exists('imagealphablending') ||
		!function_exists('imagecolorat') ||
		!function_exists('imagecolorallocatealpha') ||
		!function_exists('imagesetpixel')) return false;

		//get image width and height
		$w = imagesx( $image );
		$h = imagesy( $image );

		//turn alpha blending off
		imagealphablending( $image, false );

		//find the most opaque pixel in the image (the one with the smallest alpha value)
		$minalpha = 127;
		for ($x = 0; $x < $w; $x++) {
			for ($y = 0; $y < $h; $y++) {
				$alpha = (imagecolorat($image, $x, $y) >> 24 ) & 0xFF;
				if( $alpha < $minalpha ) {
					$minalpha = $alpha;
				}
			}
		}

		//loop through image pixels and modify alpha for each
		for ( $x = 0; $x < $w; $x++ ) {
			for ( $y = 0; $y < $h; $y++ ) {
				//get current alpha value (represents the TANSPARENCY!)
				$colorxy = imagecolorat( $image, $x, $y );
				$alpha = ( $colorxy >> 24 ) & 0xFF;
				//calculate new alpha
				if ( $minalpha !== 127 ) {
					$alpha = 127 + 127 * $opacity * ( $alpha - 127 ) / ( 127 - $minalpha );
				} else {
					$alpha += 127 * $opacity;
				}
				//get the color index with new alpha
				$alphacolorxy = imagecolorallocatealpha( $image, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha );
				//set pixel with the new color + opacity
				if(!imagesetpixel($image, $x, $y, $alphacolorxy)) {
					return false;
				}
			}
		}

		imagesavealpha($image, true);

		return $image;
	}

	/** Tints the image a different color
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @param string hex color e.g. #ff00ff
	 * @return boolean|WP_Error
	 */
	public function colorize($hexColor) {
		if (function_exists('imagefilter') &&
		function_exists('imagesavealpha') &&
		function_exists('imagealphablending')) {
			$hexColor = preg_replace('#^\##', '', $hexColor);
			$r = hexdec (substr ($hexColor, 0, 2));
			$g = hexdec (substr ($hexColor, 2, 2));
			$b = hexdec (substr ($hexColor, 2, 2));

			imagealphablending( $this->image, false );
			if (imagefilter($this->image, IMG_FILTER_COLORIZE, $r, $g, $b, 0)) {
				imagesavealpha($this->image, true);
				return true;
			}
		}
		return new WP_Error( 'image_colorize_error', __('Image color change failed.','cb-cosmetico'), $this->file );
	}

	/** Makes the image grayscale
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @return boolean|WP_Error
	 */
	public function grayscale() {
		if (function_exists('imagefilter')) {
			if (imagefilter($this->image, IMG_FILTER_GRAYSCALE)) {
				return true;
			}
		}
		return new WP_Error( 'image_grayscale_error', __('Image grayscale failed.','cb-cosmetico'), $this->file );
	}

	/** Negates the image
	 *
	 * @supports 3.5.1
	 * @access public
	 *
	 * @return boolean|WP_Error
	 */
	public function negate() {
		if (function_exists('imagefilter')) {
			if (imagefilter($this->image, IMG_FILTER_NEGATE)) {
				return true;
			}
		}
		return new WP_Error( 'image_negate_error', __('Image negate failed.','cb-cosmetico'), $this->file );
	}
}





class BFI_Thumb {
	/** Uses WP's Image Editor Class to resize and filter images
	 * Inspired by: https://github.com/sy4mil/Aqua-Resizer/blob/master/aq_resizer.php
	 *
	 * @param $url string the local image URL to manipulate
	 * @param $params array the options to perform on the image. Keys and values supported:
	 *          'width' int pixels
	 *          'height' int pixels
	 *          'opacity' int 0-100
	 *          'color' string hex-color #000000-#ffffff
	 *          'grayscale' bool
	 *          'crop' bool
	 *          'negate' bool
	 * @param $single boolean, if false then an array of data will be returned
	 * @return string|array
	 */
	public static function thumb($url, $params = array(), $single = true) {
		extract($params);

		//validate inputs
		if(!$url) return false;

		//define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		$theme_url = get_template_directory_uri();
		$theme_dir = get_template_directory();

		// find the path of the image. Perform 2 checks:
		// #1 check if the image is in the uploads folder
		if(strpos( $url, $upload_url ) !== false) {
			$rel_path = str_replace( $upload_url, '', $url);
			$img_path = $upload_dir . $rel_path;

			// #2 check if the image is in the current theme folder
		} else if (strpos($url, $theme_url) !== false) {
			$rel_path = str_replace( $theme_url, '', $url);
			$img_path = $theme_dir . $rel_path;
		}

		// Fail if we can't find the image in our WP local directory

			

		//check if img path exists, and is an image indeed
		if( !@file_exists($img_path) OR !getimagesize($img_path) OR  !isset($img_path)) $img_path =  $theme_dir.'/img/test_bg.jpg';

		// This is the filename
		$basename = basename($img_path);

		//get image info
		$info = pathinfo($img_path);
		$ext = $info['extension'];
		list($orig_w,$orig_h) = getimagesize($img_path);

		// The only purpose of this is to detemine the final width and height
		// without performing any actual image manipulation, which will be used
		// to check whether a resize was previously done.
		if (isset($width)) {
			//get image size after cropping
			$dims = image_resize_dimensions($orig_w, $orig_h, $width, isset($height) ? $height : null, isset($crop) ? $crop : false);
			$dst_w = $dims[4];
			$dst_h = $dims[5];
		}

		// create the suffix for the saved file
		// we can use this to check whether we need to create a new file or just use an existing one.
		$suffix = (string)filemtime($img_path) .
		(isset($dst_w) ? str_pad((string)$dst_w, 5, '0', STR_PAD_LEFT) : str_pad((string)$orig_w, 5, '0', STR_PAD_LEFT)) .
		(isset($dst_h) ? str_pad((string)$dst_h, 5, '0', STR_PAD_LEFT) : str_pad((string)$orig_h, 5, '0', STR_PAD_LEFT)) .
		(isset($opacity) ? str_pad((string)$opacity, 3, '0', STR_PAD_LEFT) : '100') .
		(isset($color) ? str_pad(preg_replace('#^\##', '', $color), 8, '0', STR_PAD_LEFT) : '00000000') .
		(isset($grayscale) ? ($grayscale ? '1' : '0') : '0') .
		(isset($crop) ? ($crop ? '1' : '0') : '0') .
		(isset($negate) ? ($negate ? '1' : '0') : '0');
		$suffix = self::base_convert_arbitrary($suffix, 10, 36);

		// use this to check if cropped image already exists, so we can return that instead
		$dst_rel_path = str_replace( '.'.$ext, '', basename($img_path));

		// If opacity is set, change the image type to png
		if (isset($opacity)) $ext = 'png';

		// desination paths and urls
		$destfilename = "{$upload_dir}/{$dst_rel_path}-{$suffix}.{$ext}";
		$img_url = "{$upload_url}/{$dst_rel_path}-{$suffix}.{$ext}";

		// if file exists, just return it

		if (@file_exists($destfilename) && getimagesize($destfilename)) {
			//if (2<1) {
		} else {
			// perform resizing and other filters
			$editor = wp_get_image_editor($img_path);

			if (is_wp_error( $editor )) return false;

			/*
			 * Perform image manipulations
			 */
			if(!isset($width)) $width=''; if(!isset($height)) $height='';
			if ( ( isset( $width ) && $width ) || ( isset( $height ) && $height ) ) {
				if ( is_wp_error( $editor->resize( $width, isset( $height ) ? $height : null, isset( $crop ) ? $crop : false ) ) ) {
					return false;
				}
			}

			if ( isset( $negate ) ) {
				if ( $negate ) {
					if ( is_wp_error( $editor->negate() ) ) {
						return false;
					}
				}
			}

			if ( isset( $opacity ) ) {
				if ( is_wp_error( $editor->opacity( $opacity ) ) ) {
					return false;
				}
			}

			if ( isset( $grayscale ) ) {
				if ( $grayscale ) {
					if ( is_wp_error( $editor->grayscale() ) ) {
						return false;
					}
				}
			}

			if ( isset( $color ) ) {
				if ( is_wp_error( $editor->colorize( $color ) ) ) {
					return false;
				}
			}

			// save our new image
			$mime_type = isset( $opacity ) ? 'image/png' : null;
			$resized_file = $editor->save($destfilename, $mime_type);
		}

		//return the output
		if($single) {
			$image = $img_url;
		} else {
			//array return
			$image = array (
			0 => $img_url,
			1 => isset($dst_w) ? $dst_w : $orig_w,
			2 => isset($dst_h) ? $dst_h : $orig_h,
			);
		}

		return $image;
	}

	/** Shortens a number into a base 36 string
	 *
	 * @param $number string a string of numbers to convert
	 * @param $fromBase starting base
	 * @param $toBase base to convert the number to
	 * @return string base converted characters
	 */
	protected static function base_convert_arbitrary($number, $fromBase, $toBase) {
		$digits = '0123456789abcdefghijklmnopqrstuvwxyz';
		$length = strlen($number);
		$result = '';

		$nibbles = array();
		for ($i = 0; $i < $length; ++$i) {
			$nibbles[$i] = strpos($digits, $number[$i]);
		}

		do {
			$value = 0;
			$newlen = 0;
			for ($i = 0; $i < $length; ++$i) {
				$value = $value * $fromBase + $nibbles[$i];
				if ($value >= $toBase) {
					$nibbles[$newlen++] = (int)($value / $toBase);
					$value %= $toBase;
				}
				else if ($newlen > 0) {
					$nibbles[$newlen++] = 0;
				}
			}
			$length = $newlen;
			$result = $digits[$value].$result;
		}
		while ($newlen != 0);
		return $result;
	}
}

// don't use the default resizer since we want to allow resizing to larger sizes (than the original one)
// Parts are copied from media.php
// Crop is always applied (just like timthumb)
add_filter('image_resize_dimensions', 'bfi_image_resize_dimensions', 10, 5);
function bfi_image_resize_dimensions($payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop = false) {
	$aspect_ratio = $orig_w / $orig_h;

	$new_w = $dest_w;
	$new_h = $dest_h;

	if ( !$new_w ) {
		$new_w = intval($new_h * $aspect_ratio);
	}

	if ( !$new_h ) {
		$new_h = intval($new_w / $aspect_ratio);
	}

	$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

	$crop_w = round($new_w / $size_ratio);
	$crop_h = round($new_h / $size_ratio);
	$s_x = floor( ($orig_w - $crop_w) / 2 );
	$s_y = floor( ($orig_h - $crop_h) / 2 );

	// the return array matches the parameters to imagecopyresampled()
	// int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
	return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );

}
