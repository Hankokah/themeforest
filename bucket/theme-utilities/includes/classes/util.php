<?php
/**
 * util.php
 *
 * util.php is a library of helper functions for common tasks such as
 * formatting bytes as a string or displaying a date in terms of how long ago
 * it was in human readable terms (E.g. 4 minutes ago). The library is entirely
 * contained within a single file and hosts no dependencies. The library is
 * designed to avoid any possible conflicts.
 *
 * @author Brandon Wamboldt <brandon.wamboldt@gmail.com>
 * @link   http://github.com/brandonwamboldt/utilphp/ Official Documentation
 */
class util
{
	const SECONDS_IN_A_MINUTE = 60;
	const SECONDS_IN_A_HOUR   = 3600;
	const SECONDS_IN_AN_HOUR  = 3600;
	const SECONDS_IN_A_DAY    = 86400;
	const SECONDS_IN_A_WEEK   = 604800;
	const SECONDS_IN_A_MONTH  = 2592000;
	const SECONDS_IN_A_YEAR   = 31536000;

	/**
	 * A collapse icon, used in the dump_var function to allow collapsing an
	 * array or object
	 *
	 * @var string
	 */
	static $icon_collapse = 'iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAMAAADXT/YiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MjlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFNzFDNDQyNEMyQzkxMUUxOTU4MEM4M0UxRDA0MUVGNSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFNzFDNDQyM0MyQzkxMUUxOTU4MEM4M0UxRDA0MUVGNSIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3NDlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo3MjlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PuF4AWkAAAA2UExURU9t2DBStczM/1h16DNmzHiW7iNFrypMvrnD52yJ4ezs7Onp6ejo6P///+Tk5GSG7D9h5SRGq0Q2K74AAAA/SURBVHjaLMhZDsAgDANRY3ZISnP/y1ZWeV+jAeuRSky6cKL4ryDdSggP8UC7r6GvR1YHxjazPQDmVzI/AQYAnFQDdVSJ80EAAAAASUVORK5CYII=';

	/**
	 * A collapse icon, using in the dump_var function to allow collapsing an
	 * array or object
	 *
	 * @var string
	 */
	static $icon_expand = 'iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAMAAADXT/YiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFQzZERTJDNEMyQzkxMUUxODRCQzgyRUNDMzZEQkZFQiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFQzZERTJDM0MyQzkxMUUxODRCQzgyRUNDMzZEQkZFQiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3MzlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo3MTlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PkmDvWIAAABIUExURU9t2MzM/3iW7ubm59/f5urq85mZzOvr6////9ra38zMzObm5rfB8FZz5myJ4SNFrypMvjBStTNmzOvr+mSG7OXl8T9h5SRGq/OfqCEAAABKSURBVHjaFMlbEoAwCEPRULXF2jdW9r9T4czcyUdA4XWB0IgdNSybxU9amMzHzDlPKKu7Fd1e6+wY195jW0ARYZECxPq5Gn8BBgCr0gQmxpjKAwAAAABJRU5ErkJggg==';

	/** Limit words for a string */

	static function limit_words($string, $word_limit, $more_text = ' [&hellip;]') {
		$words = explode(" ",$string);
		$output = implode(" ",array_splice($words,0,$word_limit));
		
		//check if we actually cut something
		if (count($words) > $word_limit) {
			$output .= $more_text;
		}
		
		return $output;
	}

	static function get_latest_twelve_monts( $start_month = '' ){

		if (!empty($start_month)) {
			$month = $start_month;
		} else {
			$month = (int) date('m');
		}

		$return = array();
		$count = 1;
		while ( $count <= 12  ) {
			if ( $month < 1 ) {
				$month = 12;
			}
			$return[$month] = $month;
			$month--;
			$count++;
		}

		return $return;
	}

	/**
	 * Access an array index, retrieving the value stored there if it
	 * exists or a default if it does not. This function allows you to
	 * concisely access an index which may or may not exist without
	 * raising a warning
	 *
	 * @param   array   $var      Array to access
	 * @param   string  $field    Index to access in the array
	 * @param   mixed   $default  Default value to return if the key is not
	 *                            present in the array
	 * @return  mixed
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_get( & $var, $default = NULL )
	{
		if ( isset( $var ) ) {
			return $var;
		} else {
			return $default;
		}
	}

	/**
	 * Display a variable's contents using nice HTML formatting and will
	 * properly display the value of booleans as true or false
	 *
	 * @param   mixed  $var  The variable to dump
	 * @return  string
	 *
	 * @see     var_dump_plain()
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function var_dump( $var, $return = FALSE )
	{
		$html = '<pre style="margin-bottom: 18px;' .
			'background: #f7f7f9;' .
			'border: 1px solid #e1e1e8;' .
			'padding: 8px;' .
			'border-radius: 4px;' .
			'-moz-border-radius: 4px;' .
			'-webkit-border radius: 4px;' .
			'display: block;' .
			'font-size: 12.05px;' .
			'white-space: pre-wrap;' .
			'word-wrap: break-word;' .
			'color: #333;' .
			'font-family: Menlo,Monaco,Consolas,\'Courier New\',monospace;">';
		$html .= self::var_dump_plain( $var );
		$html .= '</pre>';

		if ( ! $return ) {
			echo $html;
		} else {
			return $html;
		}
	}

	/**
	 * Display a variable's contents using nice HTML formatting (Without
	 * the <pre> tag) and will properly display the values of variables
	 * like booleans and resources. Supports collapsable arrays and objects
	 * as well.
	 *
	 * @param   mixed  $var  The variable to dump
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function var_dump_plain( $var )
	{
		$html = '';

		if ( is_bool( $var ) ) {
			$html .= '<span style="color:#588bff;">bool</span><span style="color:#999;">(</span><strong>' . ( ( $var ) ? 'true' : 'false' ) . '</strong><span style="color:#999;">)</span>';
		} else if ( is_int( $var ) ) {
			$html .= '<span style="color:#588bff;">int</span><span style="color:#999;">(</span><strong>' . $var . '</strong><span style="color:#999;">)</span>';
		} else if ( is_float( $var ) ) {
			$html .= '<span style="color:#588bff;">float</span><span style="color:#999;">(</span><strong>' . $var . '</strong><span style="color:#999;">)</span>';
		} else if ( is_string( $var ) ) {
			$html .= '<span style="color:#588bff;">string</span><span style="color:#999;">(</span>' . strlen( $var ) . '<span style="color:#999;">)</span> <strong>"' . self::htmlentities( $var ) . '"</strong>';
		} else if ( is_null( $var ) ) {
			$html .= '<strong>NULL</strong>';
		} else if ( is_resource( $var ) ) {
			$html .= '<span style="color:#588bff;">resource</span>("' . get_resource_type( $var ) . '") <strong>"' . $var . '"</strong>';
		} else if ( is_array( $var ) ) {
			$uuid = 'include-php-' . uniqid();

			$html .= '<span style="color:#588bff;">array</span>(' . count( $var ) . ')';

			if ( ! empty( $var ) ) {
				$html .= '<br /><span id="' . $uuid . '-collapsable">[<br />';

				$indent = 4;
				$longest_key = 0;

				foreach( $var as $key => $value ) {
					if ( is_string( $key ) ) {
						$longest_key = max( $longest_key, strlen( $key ) + 2 );
					} else {
						$longest_key = max( $longest_key, strlen( $key ) );
					}
				}

				foreach ( $var as $key => $value ) {
					if ( is_numeric( $key ) ) {
						$html .= str_repeat( ' ', $indent ) . str_pad( $key, $longest_key, ' ');
					} else {
						$html .= str_repeat( ' ', $indent ) . str_pad( '"' . self::htmlentities( $key ) . '"', $longest_key, ' ' );
					}

					$html .= ' => ';

					$value = explode( '<br />', self::var_dump_plain( $value ) );

					foreach ( $value as $line => $val ) {
						if ( $line != 0 ) {
							$value[$line] = str_repeat( ' ', $indent * 2 ) . $val;
						}
					}

					$html .= implode( '<br />', $value ) . '<br />';
				}

				$html .= ']</span>';

				$html .= preg_replace( '/ +/', ' ', '<script type="text/javascript">(function() {
				var img = document.getElementById("' . $uuid . '");
				img.onclick = function() {
					if ( document.getElementById("' . $uuid . '-collapsable").style.display == "none" ) {
						document.getElementById("' . $uuid . '-collapsable").style.display = "inline";
						img.src = img.getAttribute("data-collapse");
						var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;

						while ( previousSibling != null && ( previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br" ) ) {
							previousSibling = previousSibling.previousSibling;
						}

						if ( previousSibling != null && previousSibling.tagName.toLowerCase() == "br" ) {
							previousSibling.style.display = "inline";
						}
					} else {
						document.getElementById("' . $uuid . '-collapsable").style.display = "none";
						img.setAttribute( "data-collapse", img.getAttribute("src") );
						img.src = img.getAttribute("data-expand");
						var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;

						while ( previousSibling != null && ( previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br" ) ) {
							previousSibling = previousSibling.previousSibling;
						}

						if ( previousSibling != null && previousSibling.tagName.toLowerCase() == "br" ) {
							previousSibling.style.display = "none";
						}
					}
				};
				})();
				</script>' );
			}
		} else if ( is_object( $var ) ) {
			$uuid = 'include-php-' . uniqid();

			$html .= '<span style="color:#588bff;">object</span>(' . get_class( $var ) . ') <img id="' . $uuid . '" data-expand="data:image/png;base64,' . self::$icon_expand . '" style="position:relative;left:-5px;top:-1px;cursor:pointer;" src="data:image/png;base64,' . self::$icon_collapse . '" /><br /><span id="' . $uuid . '-collapsable">[<br />';

			$original = $var;
			$var = (array) $var;

			$indent = 4;
			$longest_key = 0;

			foreach( $var as $key => $value ) {
				if ( substr( $key, 0, 2 ) == "\0*" ) {
					unset( $var[$key] );
					$key = 'protected:' . substr( $key, 2 );
					$var[$key] = $value;
				} else if ( substr( $key, 0, 1 ) == "\0" ) {
					unset( $var[$key] );
					$key = 'private:' . substr( $key, 1, strpos( substr( $key, 1 ), "\0" ) ) . ':' . substr( $key, strpos( substr( $key, 1 ), "\0" ) + 1 );
					$var[$key] = $value;
				}

				if ( is_string( $key ) ) {
					$longest_key = max( $longest_key, strlen( $key ) + 2 );
				} else {
					$longest_key = max( $longest_key, strlen( $key ) );
				}
			}

			foreach ( $var as $key => $value ) {
				if ( is_numeric( $key ) ) {
					$html .= str_repeat( ' ', $indent ) . str_pad( $key, $longest_key, ' ');
				} else {
					$html .= str_repeat( ' ', $indent ) . str_pad( '"' . self::htmlentities( $key ) . '"', $longest_key, ' ' );
				}

				$html .= ' => ';

				$value = explode( '<br />', self::var_dump_plain( $value ) );

				foreach ( $value as $line => $val ) {
					if ( $line != 0 ) {
						$value[$line] = str_repeat( ' ', $indent * 2 ) . $val;
					}
				}

				$html .= implode( '<br />', $value ) . '<br />';
			}

			$html .= ']</span>';

			$html .= preg_replace( '/ +/', ' ', '<script type="text/javascript">(function() {
			var img = document.getElementById("' . $uuid . '");
			img.onclick = function() {
				if ( document.getElementById("' . $uuid . '-collapsable").style.display == "none" ) {
					document.getElementById("' . $uuid . '-collapsable").style.display = "inline";
					img.src = img.getAttribute("data-collapse");
					var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;

					while ( previousSibling != null && ( previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br" ) ) {
						previousSibling = previousSibling.previousSibling;
					}

					if ( previousSibling != null && previousSibling.tagName.toLowerCase() == "br" ) {
						previousSibling.style.display = "inline";
					}
				} else {
					document.getElementById("' . $uuid . '-collapsable").style.display = "none";
					img.setAttribute( "data-collapse", img.getAttribute("src") );
					img.src = img.getAttribute("data-expand");
					var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;

					while ( previousSibling != null && ( previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br" ) ) {
						previousSibling = previousSibling.previousSibling;
					}

					if ( previousSibling != null && previousSibling.tagName.toLowerCase() == "br" ) {
						previousSibling.style.display = "none";
					}
				}
			};
			})();
			</script>' );
		}

		return $html;
	}

	/**
	 * Converts any accent characters to their equivalent normal characters
	 * and converts any other non-alphanumeric characters to dashes, then
	 * converts any sequence of two or more dashes to a single dash. This
	 * function generates slugs safe for use as URLs, and if you pass TRUE
	 * as the second parameter, it will create strings safe for use as CSS
	 * classes or IDs
	 *
	 * @param   string  $string    A string to convert to a slug
	 * @param   bool    $css_mode  Whether or not to generate strings safe
	 *                             for CSS classes/IDs (Default to false)
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function slugify( $string, $css_mode = FALSE )
	{
		$slug = preg_replace( '/([^a-z0-9]+)/', '-', strtolower( self::remove_accents( $string ) ) );

		if ( $css_mode ) {
			$digits = array( 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine' );

			if ( is_numeric( substr( $slug, 0, 1 ) ) ) {
				$slug = $digits[substr( $slug, 0, 1 )] . substr( $slug, 1 );
			}
		}

		return $slug;
	}

	/**
	 * Checks to see if a string is utf8 encoded.
	 *
	 * NOTE: This function checks for 5-Byte sequences, UTF8
	 *       has Bytes Sequences with a maximum length of 4.
	 *
	 * @param   string  $string  The string to be checked
	 * @return  bool
	 *
	 * @link    https://github.com/facebook/libphutil/blob/master/src/utils/utf8.php
	 *
	 * @access  public
	 * @author  bmorel@ssi.fr
	 * @since   1.0.000
	 * @static
	 */
	static function seems_utf8( $string )
	{
		if ( function_exists( 'mb_check_encoding' ) ) {
			// If mbstring is available, this is significantly faster than
			// using PHP regexps.
			return mb_check_encoding( $string, 'UTF-8' );
		}

		$regex = '/(
| [\xF8-\xFF] # Invalid UTF-8 Bytes
| [\xC0-\xDF](?![\x80-\xBF]) # Invalid UTF-8 Sequence Start
| [\xE0-\xEF](?![\x80-\xBF]{2}) # Invalid UTF-8 Sequence Start
| [\xF0-\xF7](?![\x80-\xBF]{3}) # Invalid UTF-8 Sequence Start
| (?<=[\x0-\x7F\xF8-\xFF])[\x80-\xBF] # Invalid UTF-8 Sequence Middle
| (?<![\xC0-\xDF]|[\xE0-\xEF]|[\xE0-\xEF][\x80-\xBF]|[\xF0-\xF7]|[\xF0-\xF7][\x80-\xBF]|[\xF0-\xF7][\x80-\xBF]{2})[\x80-\xBF] # Overlong Sequence
| (?<=[\xE0-\xEF])[\x80-\xBF](?![\x80-\xBF]) # Short 3 byte sequence
| (?<=[\xF0-\xF7])[\x80-\xBF](?![\x80-\xBF]{2}) # Short 4 byte sequence
| (?<=[\xF0-\xF7][\x80-\xBF])[\x80-\xBF](?![\x80-\xBF]) # Short 4 byte sequence (2)
)/x';

		return ! preg_match( $regex, $string );
	}

	/**
	 * Nice formatting for computer sizes (Bytes)
	 *
	 * @param   int  $bytes     The number in bytes to format
	 * @param   int  $decimals  The number of decimal points to include
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function size_format( $bytes, $decimals = 0 )
	{
		$bytes = floatval( $bytes );

		if ( $bytes < 1024 ) {
			return $bytes . ' B';
		} else if ( $bytes < pow( 1024, 2 ) ) {
			return number_format( $bytes / 1024, $decimals, '.', '' ) . ' KiB';
		} else if ( $bytes < pow( 1024, 3 ) ) {
			return number_format( $bytes / pow( 1024, 2 ), $decimals, '.', '' ) . ' MiB';
		} else if ( $bytes < pow( 1024, 4 ) ) {
			return number_format( $bytes / pow( 1024, 3 ), $decimals, '.', '' ) . ' GiB';
		} else if ( $bytes < pow( 1024, 5 ) ) {
			return number_format( $bytes / pow( 1024, 4 ), $decimals, '.', '' ) . ' TiB';
		} else if ( $bytes < pow( 1024, 6 ) ) {
			return number_format( $bytes / pow( 1024, 5 ), $decimals, '.', '' ) . ' PiB';
		} else {
			return number_format( $bytes / pow( 1024, 5 ), $decimals, '.', '' ) . ' PiB';
		}
	}

	/**
	 * Serialize data, if needed.
	 *
	 * @param   mixed  $data  Data that might need to be serialized
	 * @return  mixed
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/maybe_serialize
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function maybe_serialize( $data )
	{
		if ( is_array( $data ) || is_object( $data ) ) {
			return serialize( $data );
		}

		return $data;
	}

	/**
	 * Unserialize value only if it is serialized
	 *
	 * @param   string $data A variable that may or may not be serialized
	 * @return  mixed
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/maybe_unserialize
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function maybe_unserialize( $data )
	{
		 // Don't attempt to unserialize data that isn't serialized
		if ( self::is_serialized( $data ) ) {
			return @unserialize( $data );
		}

		return $data;
	}

	/**
	 * Check value to find if it was serialized.
	 *
	 * If $data is not an string, then returned value will always be false.
	 * Serialized data is always a string.
	 *
	 * @param   mixed  $data  Value to check to see if was serialized
	 * @return  bool
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/is_serialized
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function is_serialized( $data )
	{
		// If it isn't a string, it isn't serialized
		if ( ! is_string( $data ) ) {
			return FALSE;
		}

		$data = trim( $data );

		if ( 'N;' == $data ) {
			return TRUE;
		}

		$length = strlen( $data );

		if ( $length < 4 ) {
			return FALSE;
		}

		if ( ':' !== $data[1] ) {
			return FALSE;
		}

		$lastc = $data[$length - 1];

		if ( ';' !== $lastc && '}' !== $lastc ) {
			return FALSE;
		}

		$token = $data[0];

		switch ( $token ) {
			case 's' :
				if ( '"' !== $data[$length-2] ) {
					return FALSE;
				}
			case 'a' :
			case 'O' :
				return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
			case 'b' :
			case 'i' :
			case 'd' :
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;\$/", $data );
		}

		return FALSE;
	}

	/**
	 * Checks to see if the page is being server over SSL or not
	 *
	 * @return  bool
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function is_https()
	{
		if ( isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Retrieve a modified URL query string.
	 *
	 * You can rebuild the URL and append a new query variable to the URL
	 * query by using this function. You can also retrieve the full URL
	 * with query data.
	 *
	 * Adding a single key & value or an associative array. Setting a key
	 * value to an empty string removes the key. Omitting oldquery_or_uri
	 * uses the $_SERVER value. Additional values provided are expected
	 * to be encoded appropriately with urlencode() or rawurlencode().
	 *
	 * @param   mixed  $newkey          Either newkey or an associative
	 *                                  array
	 * @param   mixed  $newvalue        Either newvalue or oldquery or uri
	 * @param   mixed  $oldquery_or_uri Optionally the old query or uri
	 * @return  string
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/add_query_arg
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function add_query_arg()
	{
		$ret = '';

		// Was an associative array of key => value pairs passed?
		if ( is_array( func_get_arg( 0 ) ) ) {

			// Was the URL passed as an argument?
			if ( func_num_args() == 2 && func_get_arg( 1 ) ) {
				$uri = func_get_arg( 1 );
			} else if ( func_num_args() == 3 && func_get_arg( 2 ) ) {
				$uri = func_get_arg( 2 );
			} else {
				$uri = $_SERVER['REQUEST_URI'];
			}
		} else {

			// Was the URL passed as an argument?
			if ( func_num_args() == 3 && func_get_arg( 2 ) ) {
				$uri = func_get_arg( 2 );
			} else {
				$uri = $_SERVER['REQUEST_URI'];
			}
		}

		// Does the URI contain a fragment section (The part after the #)
		if ( $frag = strstr( $uri, '#' ) ) {
			$uri = substr( $uri, 0, -strlen( $frag ) );
		} else {
			$frag = '';
		}

		// Get the URI protocol if possible
		if ( preg_match( '|^https?://|i', $uri, $matches ) ) {
			$protocol = $matches[0];
			$uri = substr( $uri, strlen( $protocol ) );
		} else {
			$protocol = '';
		}

		// Does the URI contain a query string?
		if ( strpos( $uri, '?' ) !== FALSE ) {
			$parts = explode( '?', $uri, 2 );

			if ( 1 == count( $parts ) ) {
				$base  = '?';
				$query = $parts[0];
			} else {
				$base  = $parts[0] . '?';
				$query = $parts[1];
			}
		} else if ( ! empty( $protocol ) || strpos( $uri, '=' ) === FALSE ) {
			$base  = $uri . '?';
			$query = '';
		} else {
			$base  = '';
			$query = $uri;
		}

		// Parse the query string into an array
		parse_str( $query, $qs );

		// This re-URL-encodes things that were already in the query string
		$qs = self::array_map_deep( $qs, 'urlencode' );

		if ( is_array( func_get_arg( 0 ) ) ) {
			$kayvees = func_get_arg( 0 );
			$qs = array_merge( $qs, $kayvees );
		} else {
			$qs[func_get_arg( 0 )] = func_get_arg( 1 );
		}

		foreach ( (array) $qs as $k => $v ) {
			if ( $v === false )
				unset( $qs[$k] );
		}

		$ret = http_build_query( $qs );
		$ret = trim( $ret, '?' );
		$ret = preg_replace( '#=(&|$)#', '$1', $ret );
		$ret = $protocol . $base . $ret . $frag;
		$ret = rtrim( $ret, '?' );
		return $ret;
	}

	/**
	 * Removes an item or list from the query string.
	 *
	 * @param   string|array  $keys  Query key or keys to remove.
	 * @param   bool          $uri   When false uses the $_SERVER value
	 * @return  string
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/remove_query_arg
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function remove_query_arg( $keys, $uri = FALSE )
	{
		if ( is_array( $keys ) ) {
			foreach ( $keys as $key ) {
				$uri = self::add_query_arg( $key, FALSE, $uri );
			}

			return $uri;
		}

		return self::add_query_arg( $keys, FALSE, $uri );
	}

	/**
	 * Converts many english words that equate to true or false to boolean
	 *
	 * Supports 'y', 'n', 'yes', 'no' and a few other variations
	 *
	 * @param   string  $string   The string to convert to boolean
	 * @param   bool    $default  The value to return if we can't match any
	 *                            yes/no words
	 * @return  bool
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function str_to_bool( $string, $default = FALSE )
	{
		$yes_words = 'affirmative|all right|aye|indubitably|most assuredly|ok|of course|okay|sure thing|y|yes+|yea|yep|sure|yeah|true|t|on|1';
		$no_words = 'no*|no way|nope|nah|na|never|absolutely not|by no means|negative|never ever|false|f|off|0';

		if ( preg_match( '/^(' . $yes_words . ')$/i', $string ) ) {
			return TRUE;
		} else if ( preg_match( '/^(' . $no_words . ')$/i', $string ) ) {
			return FALSE;
		} else {
			return $default;
		}
	}

	/**
	 * Convert entities, while preserving already-encoded entities
	 *
	 * @param   string  $string  The text to be converted
	 * @return  string
	 *
	 * @link    http://ca2.php.net/manual/en/function.htmlentities.php#90111
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function htmlentities( $string, $preserve_encoded_entities = FALSE )
	{
		if ( $preserve_encoded_entities ) {
			$translation_table = get_html_translation_table( HTML_ENTITIES, ENT_QUOTES, mb_internal_encoding() );
			$translation_table[chr(38)] = '&';
			return preg_replace( '/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/', '&amp;', strtr( $string, $translation_table ) );
		} else {
			return htmlentities( $string, ENT_QUOTES, mb_internal_encoding() );
		}
	}

	/**
	 * Convert >, <, ', " and & to html entities, but preserves entities
	 * that are already encoded
	 *
	 * @param   string  $string  The text to be converted
	 * @return  string
	 *
	 * @link    http://ca2.php.net/manual/en/function.htmlentities.php#90111
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function htmlspecialchars( $string, $preserve_encoded_entities = FALSE  )
	{
		if ( $preserve_encoded_entities ) {
			$translation_table            = get_html_translation_table( HTML_SPECIALCHARS, ENT_QUOTES, mb_internal_encoding() );
			$translation_table[chr( 38 )] = '&';

			return preg_replace( '/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/', '&amp;', strtr( $string, $translation_table ) );
		} else {
			return htmlentities( $string, ENT_QUOTES, mb_internal_encoding() );
		}
	}

	/**
	 * Converts all accent characters to ASCII characters
	 *
	 * If there are no accent characters, then the string given is just
	 * returned
	 *
	 * @param   string  $string  Text that might have accent characters
	 * @return  string  Filtered string with replaced "nice" characters
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/remove_accents
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function remove_accents( $string )
	{
		if ( ! preg_match( '/[\x80-\xff]/', $string ) ) {
			return $string;
		}

		if ( self::seems_utf8( $string ) ) {
			$chars = array(

				// Decompositions for Latin-1 Supplement
				chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
				chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
				chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
				chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
				chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
				chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
				chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
				chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
				chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
				chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
				chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
				chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
				chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
				chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
				chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
				chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
				chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
				chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
				chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
				chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
				chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
				chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
				chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
				chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
				chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
				chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
				chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
				chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
				chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
				chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
				chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
				chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',

				// Decompositions for Latin Extended-A
				chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
				chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
				chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
				chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
				chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
				chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
				chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
				chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
				chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
				chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
				chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
				chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
				chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
				chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
				chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
				chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
				chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
				chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
				chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
				chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
				chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
				chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
				chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
				chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
				chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
				chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
				chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
				chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
				chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
				chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
				chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
				chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
				chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
				chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
				chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
				chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
				chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
				chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
				chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
				chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
				chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
				chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
				chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
				chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
				chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
				chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
				chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
				chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
				chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
				chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
				chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
				chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
				chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
				chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
				chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
				chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
				chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
				chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
				chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
				chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
				chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
				chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
				chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
				chr(197).chr(190) => 'z', chr(197).chr(191) => 's',

				// Decompositions for Latin Extended-B
				chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
				chr(200).chr(154) => 'T', chr(200).chr(155) => 't',

				// Euro Sign
				chr(226).chr(130).chr(172) => 'E',
				// GBP (Pound) Sign
				chr(194).chr(163) => ''
			);

			$string = strtr( $string, $chars );
		} else {

			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				 .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				 .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				 .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				 .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				 .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				 .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				 .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				 .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				 .chr(252).chr(253).chr(255);

			$chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

			$string = strtr( $string, $chars['in'], $chars['out'] );
			$double_chars['in'] = array( chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254) );
			$double_chars['out'] = array( 'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th' );
			$string = str_replace( $double_chars['in'], $double_chars['out'], $string );
		}

		return $string;
	}

	/**
	 * Pads a given string with zeroes on the left
	 *
	 * @param   int  $number  The number to pad
	 * @param   int  $length  The total length of the desired string
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function zero_pad( $number, $length )
	{
		return str_pad( $number, $length, '0', STR_PAD_LEFT );
	}

	/**
	 * Converts a unix timestamp to a relative time string, such as "3 days
	 * ago" or "2 weeks ago"
	 *
	 * @param   int     $from    The date to use as a starting point
	 * @param   int     $to      The date to compare to. Defaults to the
	 *                           current time
	 * @param   string  $suffix  The string to add to the end, defaults to
	 *                           " ago"
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function human_time_diff( $from, $to = '', $as_text = FALSE, $suffix = ' ago' )
	{
		if ( $to == '' ) {
			$to = time();
		}

		$from = new DateTime( date( 'Y-m-d H:i:s', $from ) );
		$to   = new DateTime( date( 'Y-m-d H:i:s', $to ) );
		$diff = $from->diff( $to );

		if ( $diff->y > 1 ) {
			$text = $diff->y . ' years';
		} else if ( $diff->y == 1 ) {
			$text = '1 year';
		} else if ( $diff->m > 1 ) {
			$text = $diff->m . ' months';
		} else if ( $diff->m == 1 ) {
			$text = '1 month';
		} else if ( $diff->d > 7 ) {
			$text = ceil( $diff->d / 7 ) . ' weeks';
		} else if ( $diff->d == 7 ) {
			$text = '1 week';
		} else if ( $diff->d > 1 ) {
			$text = $diff->d . ' days';
		} else if ( $diff->d == 1 ) {
			$text = '1 day';
		} else if ( $diff->h > 1 ) {
			$text = $diff->h . ' hours';
		} else if ( $diff->h == 1 ) {
			$text = ' 1 hour';
		} else if ( $diff->i > 1 ) {
			$text = $diff->i . ' minutes';
		} else if ( $diff->i == 1 ) {
			$text = '1 minute';
		} else if ( $diff->s > 1 ) {
			$text = $diff->s . ' seconds';
		} else {
			$text = '1 second';
		}

		if ( $as_text ) {
			$text = explode( ' ', $text, 2 );
			$text = self::number_to_word( $text[0] ) . ' ' . $text[1];
		}

		return trim( $text ) . $suffix;
	}

	/**
	 * Converts a number into the text equivalent. For example, 456 becomes
	 * four hundred and fifty-six
	 *
	 * @param   int|float  $number  The number to convert into text
	 * @return  string
	 *
	 * @link    http://bloople.net/num2text
	 *
	 * @access  public
	 * @author  Brenton Fletcher
	 * @since   1.0.000
	 * @static
	 */
	static function number_to_word( $number )
	{
		$number = (string) $number;

		if ( strpos( $number, '.' ) !== FALSE ) {
			list( $number, $decimal ) = explode( '.', $number );
		} else {
			$number = $number;
			$decimal = FALSE;
		}

		$output = '';

		if ( $number[0] == '-' ) {
			$output = 'negative ';
			$number = ltrim( $number, '-' );
		} else if ( $number[0] == '+' ) {
			$output = 'positive ';
			$number = ltrim( $number, '+' );
		}

		if ( $number[0] == '0' ) {
			$output .= 'zero';
		} else {
			$number = str_pad( $number, 36, '0', STR_PAD_LEFT );
			$group  = rtrim( chunk_split( $number, 3, ' ' ), ' ' );
			$groups = explode( ' ', $group );

			$groups2 = array();

			foreach ( $groups as $group ) {
				$groups2[] = self::_number_to_word_three_digits( $group[0], $group[1], $group[2] );
			}

			for ( $z = 0; $z < count( $groups2 ); $z++ ) {
				if ( $groups2[$z] != '' ) {
					$output .= $groups2[$z] . self::_number_to_word_convert_group( 11 - $z );
					$output .= ( $z < 11 && ! array_search( '', array_slice( $groups2, $z + 1, -1 ) ) && $groups2[11] != '' && $groups[11][0] == '0' ? ' and ' : ', ' );
				}
			}

			$output = rtrim( $output, ', ' );
		}

		if ( $decimal > 0 ) {
			$output .= ' point';

			for ( $i = 0; $i < strlen( $decimal ); $i++ ) {
				$output .= ' ' . self::_number_to_word_convert_digit( $decimal[$i] );
			}
		}

		return $output;
	}

	protected static function _number_to_word_convert_group( $index )
	{
		switch( $index ) {
			case 11:
				return ' decillion';
			case 10:
				return ' nonillion';
			case 9:
				return ' octillion';
			case 8:
				return ' septillion';
			case 7:
				return ' sextillion';
			case 6:
				return ' quintrillion';
			case 5:
				return ' quadrillion';
			case 4:
				return ' trillion';
			case 3:
				return ' billion';
			case 2:
				return ' million';
			case 1:
				return ' thousand';
			case 0:
				return '';
		}
	}

	protected static function _number_to_word_three_digits( $digit1, $digit2, $digit3 )
	{
		$output = '';

		if ( $digit1 == '0' && $digit2 == '0' && $digit3 == '0') {
			return '';
		}

		if ( $digit1 != '0' ) {
			$output .= self::_number_to_word_convert_digit( $digit1 ) . ' hundred';

			if ( $digit2 != '0' || $digit3 != '0' ) {
				$output .= ' and ';
			}
		}

		if ( $digit2 != '0') {
			$output .= self::_number_to_word_two_digits( $digit2, $digit3 );
		} else if( $digit3 != '0' ) {
			$output .= self::_number_to_word_convert_digit( $digit3 );
		}

		return $output;
	}

	protected static function _number_to_word_two_digits( $digit1, $digit2 )
	{
		if ( $digit2 == '0' ) {
			switch ( $digit2 ) {
				case '1':
					return 'ten';
				case '2':
					return 'twenty';
				case '3':
					return 'thirty';
				case '4':
					return 'forty';
				case '5':
					return 'fifty';
				case '6':
					return 'sixty';
				case '7':
					return 'seventy';
				case '8':
					return 'eighty';
				case '9':
					return 'ninety';
			}
		} else if ( $digit1 == '1' ) {
			switch ( $digit2 ) {
				case '1':
					return 'eleven';
				case '2':
					return 'twelve';
				case '3':
					return 'thirteen';
				case '4':
					return 'fourteen';
				case '5':
					return 'fifteen';
				case '6':
					return 'sixteen';
				case '7':
					return 'seventeen';
				case '8':
					return 'eighteen';
				case '9':
					return 'nineteen';
			}
		} else {
			$second_digit = self::_number_to_word_convert_digit( $digit2 );

			switch ( $digit1 ) {
				case '2':
					return "twenty-{$second_digit}";
				case '3':
					return "thirty-{$second_digit}";
				case '4':
					return "forty-{$second_digit}";
				case '5':
					return "fifty-{$second_digit}";
				case '6':
					return "sixty-{$second_digit}";
				case '7':
					return "seventy-{$second_digit}";
				case '8':
					return "eighty-{$second_digit}";
				case '9':
					return "ninety-{$second_digit}";
			}
		}
	}

	protected static function _number_to_word_convert_digit( $digit )
	{
		switch ( $digit ) {
			case '0':
				return 'zero';
			case '1':
				return 'one';
			case '2':
				return 'two';
			case '3':
				return 'three';
			case '4':
				return 'four';
			case '5':
				return 'five';
			case '6':
				return 'six';
			case '7':
				return 'seven';
			case '8':
				return 'eight';
			case '9':
				return 'nine';
		}
	}

	/**
	 * Transmit UTF-8 content headers if the headers haven't already been
	 * sent
	 *
	 * @param   string  $content_type  The content type to send out,
	 *                                 defaults to text/html
	 * @return  bool
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function utf8_headers( $content_type = 'text/html' )
	{
		if ( ! headers_sent() ) {
			header( 'Content-type: ' . $content_type . '; charset=utf-8' );

			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Transmit headers that force a browser to display the download file
	 * dialog. Cross browser compatible. Only fires if headers have not
	 * already been sent.
	 *
	 * @param   string  $filename  The name of the filename to display to
	 *                             browsers
	 * @param   string  $content   The content to output for the download.
	 *                             If you don't specify this, just the
	 *                             headers will be sent
	 * @return  bool
	 *
	 * @link    http://www.php.net/manual/en/function.header.php#102175
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function force_download( $filename, $content = FALSE )
	{
		if ( ! headers_sent() ) {
			// Required for some browsers
			if ( ini_get( 'zlib.output_compression' ) ) {
				@ini_set( 'zlib.output_compression', 'Off' );
			}

			header( 'Pragma: public' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );

			// Required for certain browsers
			header( 'Cache-Control: private', FALSE );

			header( 'Content-Disposition: attachment; filename="' . basename( str_replace( '"', '', $filename ) ) . '";' );
			header( 'Content-Type: application/force-download' );
			header( 'Content-Transfer-Encoding: binary' );

			if ( $content ) {
			   header( 'Content-Length: ' . strlen( $content ) );
			}

			ob_clean();
			flush();

			if ( $content ) {
				echo $content;
			}

			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Sets the headers to prevent caching for the different browsers
	 *
	 * Different browsers support different nocache headers, so several
	 * headers must be sent so that all of them get the point that no
	 * caching should occur
	 *
	 * @return  bool
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function nocache_headers()
	{
		if ( ! headers_sent() ) {
			header( 'Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
			header( 'Pragma: no-cache' );

			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Generates a string of random characters
	 *
	 * @param   int   $length              The length of the string to
	 *                                     generate
	 * @param   bool  $human_friendly      Whether or not to make the
	 *                                     string human friendly by
	 *                                     removing characters that can be
	 *                                     confused with other characters (
	 *                                     O and 0, l and 1, etc)
	 * @param   bool  $include_symbols     Whether or not to include
	 *                                     symbols in the string. Can not
	 *                                     be enabled if $human_friendly is
	 *                                     true
	 * @param   bool  $no_duplicate_chars  Whether or not to only use
	 *                                     characters once in the string.
	 * @return  string
	 *
	 * @throws  LengthException  If $length is bigger than the available
	 *                           character pool and $no_duplicate_chars is
	 *                           enabled
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function random_string( $length, $human_friendly = TRUE, $include_symbols = FALSE, $no_duplicate_chars = FALSE )
	{
		$nice_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefhjkmnprstuvwxyz23456789';
		$all_an     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
		$symbols    = '!@#$%^&*()~_-=+{}[]|:;<>,.?/"\'\\`';
		$string     = '';

		// Determine the pool of available characters based on the given parameters
		if ( $human_friendly ) {
			$pool = $nice_chars;
		} else {
			$pool = $all_an;

			if ( $include_symbols ) {
				$pool .= $symbols;
			}
		}

		// Don't allow duplicate letters to be disabled if the length is
		// longer than the available characters
		if ( $no_duplicate_chars && strlen( $pool ) < $length ) {
			throw new LengthException( '$length exceeds the size of the pool and $no_duplicate_chars is enabled' );
		}

		// Convert the pool of characters into an array of characters and
		// shuffle the array
		$pool = str_split( $pool );
		shuffle( $pool );

		// Generate our string
		for ( $i = 0; $i < $length; $i++ ) {
			if ( $no_duplicate_chars ) {
				$string .= array_shift( $pool );
			} else {
				$string .= $pool[0];
				shuffle( $pool );
			}
		}

		return $string;
	}

	/**
	 * Validate an email address
	 *
	 * @param   string  $possible_email  An email address to validate
	 * @return  bool
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function validate_email( $possible_email )
	{
		return (bool) filter_var( $possible_email, FILTER_VALIDATE_EMAIL );
	}

	/**
	 * Return the URL to a user's gravatar
	 *
	 * @param   string  $email  The email of the user
	 * @param   int     $size   The size of the gravatar
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function get_gravatar( $email, $size = 32 )
	{
		if ( self::is_https() ) {
			$url = 'https://secure.gravatar.com/';
		} else {
			$url = 'http://www.gravatar.com/';
		}

		$url .= 'avatar/' . md5( $email ) . '?s=' . (int) abs( $size );

		return $url;
	}

	static function get_avatar_url($email, $size = 32){
		$get_avatar = get_avatar($email, $size);
		
		preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $get_avatar, $matches);
		if (isset($matches[1])) {
			return $matches[1];
		} else {
			return '';
		}

	}

	/**
	 * Turns all of the links in a string into HTML links
	 *
	 * @param   string  $text  The string to parse
	 * @return  string
	 *
	 * @link    https://github.com/jmrware/LinkifyURL
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function linkify( $text )
	{
		$text = preg_replace( '/&apos;/', '&#39;', $text ); // IE does not handle &apos; entity!
		$section_html_pattern = '%# Rev:20100913_0900 github.com/jmrware/LinkifyURL
			# Section text into HTML <A> tags  and everything else.
			  (                              # $1: Everything not HTML <A> tag.
				[^<]+(?:(?!<a\b)<[^<]*)*     # non A tag stuff starting with non-"<".
			  |      (?:(?!<a\b)<[^<]*)+     # non A tag stuff starting with "<".
			  )                              # End $1.
			| (                              # $2: HTML <A...>...</A> tag.
				<a\b[^>]*>                   # <A...> opening tag.
				[^<]*(?:(?!</a\b)<[^<]*)*    # A tag contents.
				</a\s*>                      # </A> closing tag.
			  )                              # End $2:
			%ix';

		return preg_replace_callback( $section_html_pattern, array( __CLASS__, '_linkify_callback' ), $text );
	}

	/**
	 * Callback for the preg_replace in the linkify() method
	 *
	 * @param   array  $matches  Matches from the preg_ function
	 * @return  string
	 *
	 * @link    https://github.com/jmrware/LinkifyURL
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function _linkify( $text )
	{
		$url_pattern = '/# Rev:20100913_0900 github.com\/jmrware\/LinkifyURL
			# Match http & ftp URL that is not already linkified.
			# Alternative 1: URL delimited by (parentheses).
			(\() # $1 "(" start delimiter.
			((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+) # $2: URL.
			(\)) # $3: ")" end delimiter.
			| # Alternative 2: URL delimited by [square brackets].
			(\[) # $4: "[" start delimiter.
			((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+) # $5: URL.
			(\]) # $6: "]" end delimiter.
			| # Alternative 3: URL delimited by {curly braces}.
			(\{) # $7: "{" start delimiter.
			((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+) # $8: URL.
			(\}) # $9: "}" end delimiter.
			| # Alternative 4: URL delimited by <angle brackets>.
			(<|&(?:lt|\#60|\#x3c);) # $10: "<" start delimiter (or HTML entity).
			((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+) # $11: URL.
			(>|&(?:gt|\#62|\#x3e);) # $12: ">" end delimiter (or HTML entity).
			| # Alternative 5: URL not delimited by (), [], {} or <>.
			( # $13: Prefix proving URL not already linked.
			(?: ^ # Can be a beginning of line or string, or
			| [^=\s\'"\]] # a non-"=", non-quote, non-"]", followed by
			) \s*[\'"]? # optional whitespace and optional quote;
			| [^=\s]\s+ # or... a non-equals sign followed by whitespace.
			) # End $13. Non-prelinkified-proof prefix.
			( \b # $14: Other non-delimited URL.
			(?:ht|f)tps?:\/\/ # Required literal http, https, ftp or ftps prefix.
			[a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]+ # All URI chars except "&" (normal*).
			(?: # Either on a "&" or at the end of URI.
			(?! # Allow a "&" char only if not start of an...
			&(?:gt|\#0*62|\#x0*3e); # HTML ">" entity, or
			| &(?:amp|apos|quot|\#0*3[49]|\#x0*2[27]); # a [&\'"] entity if
			[.!&\',:?;]? # followed by optional punctuation then
			(?:[^a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]|$) # a non-URI char or EOS.
			) & # If neg-assertion true, match "&" (special).
			[a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]* # More non-& URI chars (normal*).
			)* # Unroll-the-loop (special normal*)*.
			[a-z0-9\-_~$()*+=\/#[\]@%] # Last char can\'t be [.!&\',;:?]
			) # End $14. Other non-delimited URL.
			/imx';

		$url_replace = '$1$4$7$10$13<a href="$2$5$8$11$14">$2$5$8$11$14</a>$3$6$9$12';
		return preg_replace( $url_pattern, $url_replace, $text );
	}

	/**
	 * Callback for the preg_replace in the linkify() method
	 *
	 * @param   array  $matches  Matches from the preg_ function
	 * @return  string
	 *
	 * @link    https://github.com/jmrware/LinkifyURL
	 *
	 * @access  public
	 * @since    1.0.000
	 * @static
	 */
	static function _linkify_callback( $matches )
	{
		if ( isset( $matches[2] ) ) {
			return $matches[2];
		}

		return self::_linkify( $matches[1] );
	}

	/**
	 * Return the current URL
	 *
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function get_current_url()
	{
		$url = '';

		// Check to see if it's over https
		if ( self::is_https() ) {
			$url .= 'https://';
		} else {
			$url .= 'http://';
		}

		// Was a username or password passed?
		if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
			$url .= $_SERVER['PHP_AUTH_USER'];

			if ( isset( $_SERVER['PHP_AUTH_PW'] ) ) {
				$url .= ':' . $_SERVER['PHP_AUTH_PW'];
			}

			$url .= '@';
		}


		// We want the user to stay on the same host they are currently on,
		// but beware of security issues
		// see http://shiflett.org/blog/2006/mar/server-name-versus-http-host
		$url .= $_SERVER['HTTP_HOST'];

		// Is it on a non standard port?
		if ( $_SERVER['SERVER_PORT'] != 80 ) {
			$url .= ':' . $_SERVER['SERVER_PORT'];
		}

		// Get the rest of the URL
		if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {

			// Microsoft IIS doesn't set REQUEST_URI by default
			$url .= substr( $_SERVER['PHP_SELF'], 1 );

			if ( isset( $_SERVER['QUERY_STRING'] ) ) {
				$url .= '?' . $_SERVER['QUERY_STRING'];
			}
		} else {
			$url .= $_SERVER['REQUEST_URI'];
		}

		return $url;
	}

	/**
	 * Returns the IP address of the client
	 *
	 * @param   bool  $trust_proxy_headers  Whether or not to trust the
	 *                                      proxy headers HTTP_CLIENT_IP
	 *                                      and HTTP_X_FORWARDED_FOR. ONLY
	 *                                      use if your server is behind a
	 *                                      proxy that sets these values
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function get_client_ip( $trust_proxy_headers = FALSE )
	{
		if ( ! $trust_proxy_headers ) {
			return $_SERVER['REMOTE_ADDR'];
		}

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	/**
	 * Truncate a string to a specified length without cutting a word off
	 *
	 * @param   string  $string  The string to truncate
	 * @param   int     $length  The length to truncate the string to
	 * @param   string  $append  Text to append to the string IF it gets
	 *                           truncated, defaults to '...'
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function safe_truncate( $string, $length, $append = '...' )
	{
		$ret        = substr( $string, 0, $length );
		$last_space = strrpos( $ret, ' ' );

		if ( $last_space !== FALSE && $string != $ret ) {
			$ret     = substr( $ret, 0, $last_space );
		}

		if ( $ret != $string ) {
			$ret .= $append;
		}

		return $ret;
	}

	/**
	 * Returns the ordinal version of a number (appends th, st, nd, rd)
	 *
	 * @param   string  $number  The number to append an ordinal suffix to
	 * @return  string
	 *
	 * @link    http://phpsnips.com/snippet.php?id=37
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function ordinal( $number )
	{
		$test_c = abs ($number ) % 10;

		$ext = ( ( abs( $number ) % 100 < 21 && abs( $number ) % 100 > 4 ) ? 'th' : ( ( $test_c < 4 ) ? ( $test_c < 3 ) ? ( $test_c < 2 ) ? ( $test_c < 1 ) ? 'th' : 'st' : 'nd' : 'rd' : 'th' ) );

		return $number . $ext;
	}

	/**
	 * Returns the file permissions as a nice string, like -rw-r--r--
	 *
	 * @param   string  $file  The name of the file to get permissions form
	 * @return  string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function full_permissions( $file )
	{
		$perms = fileperms( $file );

		if ( ( $perms & 0xC000 ) == 0xC000 ) {
			// Socket
			$info = 's';
		} else if ( ( $perms & 0xA000 ) == 0xA000 ) {
			// Symbolic Link
			$info = 'l';
		} else if ( ( $perms & 0x8000 ) == 0x8000 ) {
			// Regular
			$info = '-';
		} else if ( ( $perms & 0x6000 ) == 0x6000 ) {
			// Block special
			$info = 'b';
		} else if ( ( $perms & 0x4000 ) == 0x4000 ) {
			// Directory
			$info = 'd';
		} else if ( ( $perms & 0x2000 ) == 0x2000 ) {
			// Character special
			$info = 'c';
		} else if ( ( $perms & 0x1000 ) == 0x1000 ) {
			// FIFO pipe
			$info = 'p';
		} else {
			// Unknown
			$info = 'u';
		}

		// Owner
		$info .= ( ( $perms & 0x0100 ) ? 'r' : '-' );
		$info .= ( ( $perms & 0x0080 ) ? 'w' : '-' );
		$info .= ( ( $perms & 0x0040 ) ?
					( ( $perms & 0x0800 ) ? 's' : 'x' ) :
					( ( $perms & 0x0800 ) ? 'S' : '-' ) );

		// Group
		$info .= ( ( $perms & 0x0020 ) ? 'r' : '-' );
		$info .= ( ( $perms & 0x0010 ) ? 'w' : '-' );
		$info .= ( ( $perms & 0x0008 ) ?
					( ( $perms & 0x0400 ) ? 's' : 'x' ) :
					( ( $perms & 0x0400 ) ? 'S' : '-' ) );

		// World
		$info .= ( ( $perms & 0x0004 ) ? 'r' : '-' );
		$info .= ( ( $perms & 0x0002 ) ? 'w' : '-' );
		$info .= ( ( $perms & 0x0001 ) ?
					( ( $perms & 0x0200 ) ? 't' : 'x' ) :
					( ( $perms & 0x0200 ) ? 'T' : '-' ) );

		return $info;
	}

	/**
	 * Returns the first element in an array
	 *
	 * @param   array  $array  The array
	 * @return  mixed
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_first( array $array )
	{
		return reset( $array );
	}

	/**
	 * Returns the last element in an array
	 *
	 * @param   array  $array  The array
	 * @return  mixed
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_last( array $array )
	{
		return end( $array );
	}

	/**
	 * Returns the first key in an array
	 *
	 * @param   array  $array  The array
	 * @return  int|string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_first_key( array $array )
	{
		reset( $array );

		return key( $array );
	}

	/**
	 * Returns the last key in an array
	 *
	 * @param   array  $array  The array
	 * @return  int|string
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_last_key( array $array )
	{
		end( $array );

		return key( $array );
	}

	/**
	 * Flattens a potentially multi-dimensional array into a one
	 * dimensional array
	 *
	 * @param   array  $array         The array to flatten
	 * @param   bool   preserve_keys  Whether or not to preserve array
	 *                                keys. Keys from deeply nested arrays
	 *                                will overwrite keys from shallowy
	 *                                nested arrays
	 * @return  array
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_flatten( array $array, $preserve_keys = TRUE )
	{
		$flattened = array();

		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$flattened = array_merge( $flattened, self::array_flatten( $value, $preserve_keys ) );
			} else {
				if ( $preserve_keys ) {
					$flattened[$key] = $value;
				} else {
					$flattened[] = $value;
				}
			}
		}

		return $flattened;
	}

	/**
	 * Accepts an array, and returns an array of values from that array as
	 * specified by $field. For example, if the array is full of objects
	 * and you call util::array_pluck( $array, 'name' ), the function will
	 * return an array of values from $array[]->name
	 *
	 * @param   array   $array             An array
	 * @param   string  $field             The field to get values from
	 * @param   bool    $preserve_keys     Whether or not to preserve the
	 *                                     array keys
	 * @param   bool    $remove_nomatches  If the field doesn't appear to
	 *                                     be set, remove it from the array
	 * @return  array
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/wp_list_pluck
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_pluck( array $array, $field, $preserve_keys = TRUE, $remove_nomatches = TRUE )
	{
		$new_list = array();

		foreach ( $array as $key => $value ) {
			if ( is_object( $value ) ) {
				if ( isset( $value->{$field} ) ) {
					if ( $preserve_keys ) {
						$new_list[$key] = $value->{$field};
					} else {
						$new_list[] = $value->{$field};
					}
				} else if ( ! $remove_nomatches ) {
					$new_list[$key] = $value;
				}
			} else {
				if ( isset( $value[$field] ) ) {
					if ( $preserve_keys ) {
						$new_list[$key] = $value[$field];
					} else {
						$new_list[] = $value[$field];
					}
				} else if ( ! $remove_nomatches ) {
					$new_list[$key] = $value;
				}
			}
		}

		return $new_list;
	}

	/**
	 * Searches for a given value in an array of arrays, objects and scalar
	 * values. You can optionally specify a field of the nested arrays and
	 * objects to search in
	 *
	 * @param   array   $array   The array to search
	 * @param   scalar  $search  The value to search for
	 * @param   string  $field   The field to search in, if not specified
	 *                           all fields will be searched
	 * @return  bool|scalar      False on failure or the array key on
	 *                           success
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_search_deep( array $array, $search, $field = FALSE )
	{
		// *grumbles* stupid PHP type system
		$search = (string) $search;

		foreach ( $array as $key => $elem ) {

			// *grumbles* stupid PHP type system
			$key = (string) $key;

			if ( $field ) {
				if ( is_object( $elem ) && $elem->{$field} === $search ) {
					return $key;
				} else if ( is_array( $elem ) && $elem[$field] === $search ) {
					return $key;
				} else if ( is_scalar( $elem ) && $elem === $search ) {
					return $key;
				}
			} else {
				if ( is_object( $elem ) ) {
					$elem = (array) $elem;

					if ( in_array( $search, $elem ) ) {
						return $key;
					}
				} else if ( is_array( $elem ) && in_array( $search, $elem ) ) {
					return array_search( $search, $elem );
				} else if ( is_scalar( $elem ) && $elem === $search ) {
					return $key;
				}
			}
		}

		return FALSE;
	}

	/**
	 * Returns an array containing all the elements of arr1 after applying
	 * the callback function to each one
	 *
	 * @param   string  $callback      Callback function to run for each
	 *                                 element in each array
	 * @param   array   $array         An array to run through the callback
	 *                                 function
	 * @param   bool    $on_nonscalar  Whether or not to call the callback
	 *                                 function on nonscalar values
	 *                                 (Objects, resources, etc)
	 * @return  array
	 *
	 * @access  public
	 * @since   1.0.000
	 * @static
	 */
	static function array_map_deep( array $array, $callback, $on_nonscalar = FALSE )
	{
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$args = array( $value, $callback, $on_nonscalar );
				$array[$key] = call_user_func_array( array( __CLASS__, __FUNCTION__ ), $args );
			} else if ( is_scalar( $value ) || $on_nonscalar ) {
				$array[$key] = call_user_func( $callback, $value );
			}
		}

		return $array;
	}
   
}