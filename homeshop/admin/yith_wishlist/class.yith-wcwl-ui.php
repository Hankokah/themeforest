<?php
/**
 * Shortcodes class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 1.0.0
 */
 
if ( !defined( 'YITH_WCWL' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WCWL_UI' ) ) {
    class YITH_WCWL_UI {
        
        /**
         * Build the popup message HTML/jQuery.
         * 
         * @return string
         * @static
         * @since 1.0.0
         */
        public static function popup_message() {
          
		   ob_start() ?>
		   
            <script type="text/javascript">
            // if( !jQuery( '#yith-wcwl-popup-message' ).length ) {
                // jQuery( 'body' ).prepend('<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>');
            // }
            </script>
			
            <?php
            return ob_get_clean();
        }
        
        /**
         * Build the "Add to Wishlist" HTML
         * 
         * @param string $url
         * @param string $product_type
         * @param bool $exists
         * @return string
         * @static
         * @since 1.0.0
         */
        public static function add_to_wishlist_button( $url, $product_type, $exists ) { 

		
            global $yith_wcwl, $product;
                     
            $label = apply_filters( 'yith_wcwl_button_label', get_option( 'yith_wcwl_add_to_wishlist_text' ) );
            $icon = get_option( 'yith_wcwl_add_to_wishlist_icon' ) != 'none' ? '<i class="' . get_option( 'yith_wcwl_add_to_wishlist_icon' ) . '"></i>' : ''; 
            
            $classes = get_option( 'yith_wcwl_use_button' ) == 'yes' ? 'class="add_to_wishlist single_add_to_wishlist alt"' : 'class="add_to_wishlist"';
            
            $html  = ''; 
                $html .= '<span class="add-to-favorites yith-wcwl-add-button" ';
                
                $html .= $exists ? ' style="display:none;"' : '';
                
                $html .= '><a href="' . $yith_wcwl->get_addtowishlist_url() . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' ><span class="action-wrapper">
                                        <i class="icons icon-heart-empty"></i><span class="action-name">' . $label . '</span></span></a>';
                $html .= '<img src="' . esc_url( admin_url( 'images/wpspin_light.gif' ) ) . '" class="ajax-loading" id="add-items-ajax-loading" alt="" style="visibility:hidden" />';
                $html .= '</span>';
            
            $html .= '<span class="add-to-favorites yith-wcwl-wishlistaddedbrowse" style="display:none;"><a href="' . $url . '"><span class="action-wrapper">
                                                            <i class="icons icon-heart-empty"></i>
                                                            <span class="action-name">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'View Wishlist', 'homeshop' ) ) . '</span></span></a></span>';
            $html .= '<span class="add-to-favorites yith-wcwl-wishlistexistsbrowse" style="display:' . ( $exists ? 'table-cell' : 'none' ) . '"><a href="' . $url . '"><span class="action-wrapper">
                                                            <i class="icons icon-heart-empty"></i>
                                                            <span class="action-name">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'View Wishlist', 'homeshop' ) ) . '</span></span></a></span>';
           
            
            
            $html .= '';
            
            return $html;
        }
        
        /**
         * Build the "Add to cart" HTML.
         * 
         * @param string $url
         * @param string $stock_status
         * @param string $type
         * @return string
         * @static
         * @since 1.0.0
         */
        public static function add_to_cart_button( $product_id, $stock_status ) {
            global $yith_wcwl;
            
            $product = new WC_Product( $product_id );
            $url = $yith_wcwl->get_addtocart_url( $product_id );
    		$label = $product->product_type == 'variable' ? apply_filters( 'variable_add_to_cart_text', __('Select options', 'homeshop') ) : apply_filters( 'yith_wcwl_add_to_cart_label', get_option( 'yith_wcwl_add_to_cart_text' ) );
            $icon = get_option( 'yith_wcwl_add_to_cart_icon' ) != 'none' ? '<i class="' . get_option( 'yith_wcwl_add_to_cart_icon' ) . '"></i>' : '';
            
    		$cartlink = '';
    		$redirect_to_cart = get_option( 'yith_wcwl_redirect_cart' ) == 'yes' && $product->product_type != 'variable' ? 'true' : 'false';
    		$style = ''; //indicates the style (background-color and font color)
    		
      		    if( get_option( 'yith_wcwl_use_button' ) == 'yes' ) {    			
        			$cartlink .= '<a class="add_to_cart button alt" onclick="check_for_stock(\'' . $url . '\',\'' . $stock_status . '\',\'' . $redirect_to_cart . '\');"';    			
        			$cartlink .= $style . '>' . $icon . $label . '</a>';
        		} else {
        			$cartlink .= '<a class="add_to_cart" href="javascript:void(0);" onclick="check_for_stock(\'' . $url . '\',\'' . $stock_status . '\',\'' . $redirect_to_cart . '\');">
					<span class="add-to-cart">
                                                <span class="action-wrapper">
                                                    <i class="icons icon-basket-2"></i>
                                                    <span class="action-name">'. $label .'</span>
                                                </span>
                                            </span></a>';
        		}
    		
    		return $cartlink;
    	}
        
        /**
         * Build share HTML.
         * 
         * @param string $url
         * @return $string
         * @static
         * @since 1.0.0
         */
        public static function get_share_links( $url ) {
            $normal_url = $url;
            $url = urlencode( $url );
            $title = urlencode( get_option( 'yith_wcwl_socials_title' ) );
            $twitter_summary = str_replace( '%wishlist_url%', '', get_option( 'yith_wcwl_socials_text' ) );
            $summary = urlencode( str_replace( '%wishlist_url%', $normal_url, get_option( 'yith_wcwl_socials_text' ) ) );
            $imageurl = urlencode( get_option( 'yith_wcwl_socials_image_url' ) );
            
            $html  = '<div class="yith-wcwl-share">';
            $html .= apply_filters( 'yith_wcwl_socials_share_title', '<h4>' . __( 'Share on:', 'homeshop' ) . '</h4>' );
                $html .= '<ul>';
                
                if( get_option( 'yith_wcwl_share_fb' ) == 'yes' )
                    { $html .= '<li style="list-style-type: none; display: inline-block;"><a target="_blank" class="facebook" href="https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $url . '&amp;p[summary]=' . $summary . '&amp;p[images][0]=' . $imageurl . '" title="' . __( 'Facebook', 'homeshop' ) . '"></a></li>'; }
                
                if( get_option( 'yith_wcwl_share_twitter' ) == 'yes' )
                    { $html .= '<li style="list-style-type: none; display: inline-block;"><a target="_blank" class="twitter" href="https://twitter.com/share?url=' . $url . '&amp;text=' . $twitter_summary . '" title="' . __( 'Twitter', 'homeshop' ) . '"></a></li>'; }
                
                if( get_option( 'yith_wcwl_share_pinterest' ) == 'yes' )
                    { $html .= '<li style="list-style-type: none; display: inline-block;"><a target="_blank" class="pinterest" href="http://pinterest.com/pin/create/button/?url=' . $url . '&amp;description=' . $summary . '&media=' . $imageurl . '" onclick="window.open(this.href); return false;"></a></li>'; }
                
                $html .= '</ul>';
            $html .= '</div>';	
            
            return $html;			
    	}
    }
}