<?php
/**
 * @package    WordPress
 * @subpackage Kassyopea
 */

/**
 * Create the standard set of arguments for creating new sidebar
 *
 * @param string $name         The main name of sidebar
 * @param string $description  (optional) Description of sidebar
 * @param string $widget_class (optional) The widget class
 * @param string $title        (optional) The tag to use for the titles
 *
 * @return array The set of arguments for creating the sidebar
 *
 * @since 1.0
 */
function yiw_sidebar_args( $name, $description = '', $widget_class = 'widget', $title = 'h3' ) {
    $id = strtolower( str_replace( ' ', '-', $name ) );

    return array(
        'name'          => $name,
        'id'            => $id,
        'description'   => $description,
        'before_widget' => '<div id="%1$s" class="' . $widget_class . ' %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<' . $title . '>',
        'after_title'   => '</' . $title . '>',
    );
}

/**
 * Print the url of favicon, choosed on Theme Options
 *
 * @since 1.0
 */
function yiw_favicon() {
    $fav = yiw_get_option( 'favicon' );

    if ( empty( $fav ) ) {
        $fav = get_template_directory_uri() . '/favicon.ico';
    }

    echo esc_url( $fav );
}

/**
 * Print the url of logo, choosed on Theme Options
 *
 * @since 1.0
 */
function yiw_logo() {
    echo yiw_get_option( 'logo' );
}

/**
 * Add the google analytics code
 *
 * @since 1.0
 */
function yiw_ga_code() {
    echo stripslashes( yiw_get_option( 'ga_code' ) );
}

/**
 * Retrieve the layout of current page, set by metabox
 *
 * @since 1.0
 */
function yiw_layout_page() {
    global $yiw_layout;
    return $yiw_layout;
}

/**
 * Retrieve tag image, get from relative path on param (without slash first)
 *
 * @since 1.0
 */
function yiw_get_img( $relative_path, $alt = '', $class = '' ) {
    $url  = get_template_directory_uri() . '/' . $relative_path;
    $path = YIW_THEME_PATH . '/' . $relative_path;

    if ( ! file_exists( $path ) ) {
        return;
    }

    $class = ( $class != '' ) ? " class=\"$class\"" : '';

    if ( function_exists( 'getimagesize' ) ) {
        $img = getimagesize( $path );

        if ( $img ) {
            return "<img src=\"$url\" $img[3] alt=\"$alt\"$class />";
        }
    }
    else {
        return "<img src=\"$url\" alt=\"$alt\"$class />";
    }

    return '';
}

/**
 * Echo tag image, get from relative path on param (without slash first)
 *
 * @since 1.0
 */
function yiw_img( $relative_path, $alt = '', $class = '' ) {
    echo yiw_get_img( $relative_path, $alt, $class );
}

/**
 * Add lightbox to the gallery
 *
 * @since 1.0
 */
function yiw_add_lightbox( $html, $id, $size, $permalink, $icon, $text ) {
    if ( ! $permalink ) {
        return str_replace( '<a', '<a rel="prettyPhoto[gallery]"', $html );
    }
    else {
        return $html;
    }
}

/**
 * Generate a list of options of all icons, retrieved from a folder.
 *
 * @param string $selected The icon name to select
 * @param bool   $echo     If print the html output or only return it.
 *
 * @return string The html output with all <option>
 *
 * @since 1.0
 */
function yiw_list_icons( $selected = '', $echo = TRUE ) {
    $icons_name = yiw_list_files_into( YIW_THEME_PATH . 'images/icons/set_icons/' );

    $html = '';
    foreach ( $icons_name as $name_icon ) {
        list( $icon, $ext ) = explode( '.', $name_icon );

        $html .= '<option value="' . $icon . '"' . selected( $selected, $icon, false ) . '>' . $icon . '</option>' . "\n";
    }

    if ( $echo ) {
        echo $html;
    }
    return $html;
}

/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function yiw_widget_first_last_classes( $params ) {

    global $my_widget_num; // Global a counter array
    $this_id                = $params[0]['id']; // Get the id for the current sidebar we're processing
    $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets  

    if ( ! $my_widget_num ) { // If the counter array doesn't exist, create it
        $my_widget_num = array();
    }

    if ( ! isset( $arr_registered_widgets[$this_id] ) || ! is_array( $arr_registered_widgets[$this_id] ) ) { // Check if the current sidebar has no widgets
        return $params; // No widgets in this sidebar... bail early.
    }

    if ( isset( $my_widget_num[$this_id] ) ) { // See if the counter array has an entry for this sidebar
        $my_widget_num[$this_id] ++;
    }
    else { // If not, create it starting with 1
        $my_widget_num[$this_id] = 1;
    }

    $class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

    if ( $my_widget_num[$this_id] == 1 ) // If this is the first widget
    {
        $class .= 'widget-first ';
    }
    if ( $my_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) ) // If this is the last widget
    {
        $class .= 'widget-last ';
    }

    $params[0]['before_widget'] = str_replace( 'class="', $class, $params[0]['before_widget'] ); // Insert our new classes into "before widget"

    return $params;

}

/**
 * Retrieve the links of the slide, set from Theme Options, for the sliders
 *
 * @param bool   $a     Reference to a flag for say if there is a link
 * @param string $url   Reference to the url of the slide
 * @param array  $slide The slide array, from the Theme Options
 *
 * @return null
 *
 * @since 1.0
 */
function yiw_links_sliders( &$a, &$url, $slide ) {
    switch ( $slide['link_type'] ) {
        case 'page':
            $a   = TRUE;
            $url = get_permalink( $slide['link_page'] );
            break;

        case 'category':
            $a        = TRUE;
            $theCatId = get_category_by_slug( $slide['link_category'] );
            $url      = get_category_link( $theCatId->term_id );
            break;

        case 'url':
            $a   = TRUE;
            $url = $slide['link_url'];
            break;

        case 'none':
            $a   = FALSE;
            $url = '';
            break;
    }
}

/**
 * Retrieve and print the type and content of the slide
 *
 * @param array  $slide     The slide array, from the Theme Options
 * @param string $before    The string before the image
 * @param string $after     The string after the image
 * @param bool   $container If put the image or video into a container
 *
 * @return null
 *
 * @since 1.0
 */
function yiw_featured_content( $slide, $args = array() ) {
    global $link;

    $default = array(
        'before'       => '',
        'after'        => '',
        'container'    => true,
        'video_width'  => 425,
        'video_height' => 356
    );
    $args    = wp_parse_args( $args, $default );

    extract( $args, EXTR_SKIP );

    switch ( $slide['content_type'] ) {

        case 'image' :
            ?>
            <?php if ( $link ) : ?><a href="<?php echo $link_url ?>"><?php endif ?>
            <?php if ( $container ) : ?>
            <div class="featured-image"><?php endif;
            echo $before ?>
            <img src="<?php echo $slide['image_url'] ?>" alt="<?php echo $slide['slide_title'] ?>" /><?php echo $after ?><?php if ( $container ) : ?>
            </div><?php endif; ?>
            <?php if ( $link ) : ?></a><?php endif ?>
            <?php break;

        case 'video' :
            list( $type, $id ) = explode( ':', yiw_video_type_by_url( $slide['url_video'] ) );

            switch ( $type ) :

                case 'youtube' :
                    ?>
                    <div class="video-container">
                        <div id="video-youtube-<?php echo $id ?>"></div>
                    </div>
                    <script type="text/javascript">

                        swfobject.embedSWF("http://www.youtube.com/e/<?php echo $id ?>",
                            "video-youtube-<?php echo $id ?>", "<?php echo $video_width ?>", "<?php echo $video_height ?>", "8", null, null, { allowScriptAccess: "always", wmode: "transparent" }, { id: "video-youtube-<?php echo $id ?>-player" });

                    </script>
                    <?php
                    break;

                case 'vimeo' :
                    ?>
                    <div class="video-container">
                        <div id="video-youtube-<?php echo $id ?>">
                            <object width="<?php echo $video_width ?>" height="<?php echo $video_height ?>">
                                <param name="allowfullscreen" value="true" />
                                <param name="allowscriptaccess" value="always" />
                                <param name="wmode" value="transparent" />
                                <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $id ?>&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1" />
                                <embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $id ?>&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1"
                                       type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="<?php echo $video_width ?>" height="<?php echo $video_height ?>"></embed>
                            </object>
                        </div>
                    </div>
                    <?php
                    break;

            endswitch;

            break;

    }
}

/**
 * Retrieve the type of video, by url
 *
 * @param string $url The video's url
 *
 * @return mixed A string format like this: "type:ID". Return FALSE, if the url isn't a valid video url.
 *
 * @since 1.0
 */
function yiw_video_type_by_url( $url ) {
    $parsed = parse_url( esc_url( $url ) );

    switch ( $parsed['host'] ) :

        case 'www.youtube.com' :
            $id = yiw_get_yt_video_id( $url );
            return "youtube:$id";

        case 'vimeo.com' :
            preg_match( '/http:\/\/(www\.)*vimeo\.com\/(.*)/', $url, $matches );
            $id = $matches[2];
            return "vimeo:$id";

        default :
            return false;

    endswitch;
}

/**
 * Retrieve the id video from youtube url
 *
 * @param string $url The video's url
 *
 * @return string The youtube id video
 *
 * @since 1.0
 */
function yiw_get_yt_video_id( $url ) {
    if ( preg_match( '/http:\/\/youtu.be/', $url, $matches ) ) {
        $url = parse_url( $url, PHP_URL_PATH );
        $url = str_replace( '/', '', $url );
        return $url;

    }
    elseif ( preg_match( '/watch/', $url, $matches ) ) {
        $arr = parse_url( $url );
        $url = str_replace( 'v=', '', $arr['query'] );
        return $url;

    }
    elseif ( preg_match( '/http:\/\/www.youtube.com\/v/', $url, $matches ) ) {
        $arr = parse_url( $url );
        $url = str_replace( '/v/', '', $arr['path'] );
        return $url;

    }
    elseif ( preg_match( '/http:\/\/www.youtube.com\/embed/', $url, $matches ) ) {
        $arr = parse_url( $url );
        $url = str_replace( '/embed/', '', $arr['path'] );
        return $url;

    }
    elseif ( preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=[0-9]/)[^&\n]+|(?<=v=)[^&\n]+#", $url, $matches ) ) {
        return $matches[0];

    }
    else {
        return false;
    }
}


/**
 * Split a string from the words within the brackets
 *
 * E.G.
 * string: my title [with subtitle]
 * return: array(
 *      [title] => 'my title',
 *      [subtitle] => 'with subtitle'
 * )
 *
 * @param string $title   The string to convert
 * @param string $pattern The pattern where decide how split
 *
 * @return array An array with the two string splitted
 *
 * @since 1.0
 */
function yiw_split_title( $title, $pattern = '/(.*)\[(.*)\]/' ) {
    $return = array();

    if ( preg_match( $pattern, $title, $t, PREG_OFFSET_CAPTURE ) ) {
        $return['title']    = $t[1][0];
        $return['subtitle'] = $t[2][0];
    }
    else {
        $return['title']    = $title;
        $return['subtitle'] = '';
    }

    return $return;
}

/**
 * Get the slides from an option of Theme Options
 *
 * @param string $option The name of option
 *
 * @return array The array with all slides, sorted by key 'order'
 *
 * @since 1.0
 */
function yiw_get_slides( $option ) {
    return yiw_subval_sort( maybe_unserialize( yiw_get_option( $option ) ), 'order' );
}

/**
 * Echo the pagination
 *
 * @since 1.0
 */
function yiw_pagination( $pages = '', $range = 10 ) {
    global $paged;
    if ( empty( $paged ) ) {
        $paged = 1;
    }

    $html = '';

    if ( $pages == '' ) {
        global $wp_query;

        if ( isset( $wp_query->max_num_pages ) ) {
            $pages = $wp_query->max_num_pages;
        }

        if ( ! $pages ) {
            $pages = 1;
        }
    }

    if ( 1 != $pages ) {
        $html .= "<div class='general-pagination group'>";
        if ( $paged > 2 ) {
            $html .= "<a href='" . get_pagenum_link( 1 ) . "'>&laquo;</a>";
        }
        if ( $paged > 1 ) {
            $html .= "<a href='" . get_pagenum_link( $paged - 1 ) . "'>&lsaquo;</a>";
        }

        for ( $i = 1; $i <= $pages; $i ++ ) {
            if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $range ) ) {
                $class = ( $paged == $i ) ? " class='selected'" : '';
                $html .= "<a href='" . get_pagenum_link( $i ) . "'$class >$i</a>";
            }
        }

        if ( $paged < $pages ) {
            $html .= "<a href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a>";
        }
        if ( $paged < $pages - 1 ) {
            $html .= "<a href='" . get_pagenum_link( $pages ) . "'>&raquo;</a>";
        }

        $html .= "</div>\n";
    }

    echo apply_filters( 'yiw_pagination', $html );
}

/**
 * Retrieve all slides of accordion slider
 *
 * @since 1.0
 */
function yiw_get_accordion_slides( $key = false ) {
    $return = array();

    if ( $post_types = yiw_get_option( 'accordion_sliders' ) ) {
        foreach ( unserialize( $post_types ) as $id => $value ) {
            switch ( $key ) {
                case 'name' :
                    $return[] = $value;
                    break;

                case 'slug' :
                    $return[] = strtolower( str_replace( ' ', '_', $value ) );
                    break;

                case FALSE :
                    $return[$id]['name'] = $value;
                    $return[$id]['slug'] = strtolower( str_replace( ' ', '_', $value ) );
                    break;
            }
        }
    }
    else {
        $return = array();
    }

    return $return;
}

/**
 * Detect the browser used by the user
 */
function yiw_browser_body_class( $classes ) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $yiw_mobile;

    if ( $is_lynx ) {
        $classes[] = 'lynx';
    }
    elseif ( $is_gecko ) {
        $classes[] = 'gecko';
    }
    elseif ( $is_opera ) {
        $classes[] = 'opera';
    }
    elseif ( $is_NS4 ) {
        $classes[] = 'ns4';
    }
    elseif ( $is_safari ) {
        $classes[] = 'safari';
    }
    elseif ( $is_chrome ) {
        $classes[] = 'chrome';
    }
    elseif ( $is_IE ) {
        $classes[] = 'ie';
    }
    else {
        $classes[] = 'unknown';
    }

    if ( $yiw_mobile->isMobile() ) {

        $classes[] = 'isMobile';
        if ( $yiw_mobile->isAndroid() ) {
            $classes[] = 'android';
        }
        elseif ( $yiw_mobile->isAndroidtablet() ) {
            $classes[] = 'android-tablet';
        }
        elseif ( $yiw_mobile->isIphone() ) {
            $classes[] = 'iphone';
        }
        elseif ( $yiw_mobile->isIpad() ) {
            $classes[] = 'ipad';
        }
        elseif ( $yiw_mobile->isBlackberry() ) {
            $classes[] = 'blackberry';
        }
        elseif ( $yiw_mobile->isBlackberrytablet() ) {
            $classes[] = 'blackberry-tablet';
        }
        elseif ( $yiw_mobile->isWindows() ) {
            $classes[] = 'windows';
        }
        elseif ( $yiw_mobile->isWindowsphone() ) {
            $classes[] = 'windows-phone';
        }
        elseif ( $yiw_mobile->isGeneric() ) {
            $classes[] = 'generic';
        }

    }

    return $classes;
}

/**
 * Detect the internet explorer version
 */
function yiw_ieversion() {

    if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
        return - 1;
    }
    preg_match( '/MSIE ([0-9]+\.[0-9])/', $_SERVER['HTTP_USER_AGENT'], $reg );

    if ( ! isset( $reg[1] ) ) // IE 11 FIX
    {
        preg_match( '/rv:([0-9]+\.[0-9])/', $_SERVER['HTTP_USER_AGENT'], $reg );
        if ( ! isset( $reg[1] ) ) {
            return - 1;
        }
        else {
            return floatval( $reg[1] );
        }
    }
    else {
        return floatval( $reg[1] );
    }

}

/**
 * Return the page breadcrumbs
 *
 */
function yiw_breadcrumb( $delimiter = ' &rsaquo; ' ) {

    $home   = apply_filters( 'yiw_home_text_breadcrumb', __( 'Home Page', 'yiw' ) ); // text for the 'Home' link
    $before = '<a class="no-link current" href="#">'; // tag before the current crumb
    $after  = '</a>'; // tag after the current crumb


    echo '<p id="crumbs" class="theme_breadcumb">';

    global $post;
    $homeLink = site_url();
    if ( ! is_home() && ! is_front_page() ) {
        echo '<a class="home" href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
    }

    if ( is_category() ) {
        global $wp_query;
        $cat_obj   = $wp_query->get_queried_object();
        $thisCat   = $cat_obj->term_id;
        $thisCat   = get_category( $thisCat );
        $parentCat = get_category( $thisCat->parent );
        if ( $thisCat->parent != 0 ) {
            echo get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ' );
        }
        echo $before . 'Archive by category "' . single_cat_title( '', false ) . '"' . $after;

    }
    elseif ( is_day() ) {
        echo '<a class="no-link" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
        echo '<a class="no-link" href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
        echo $before . get_the_time( 'd' ) . $after;

    }
    elseif ( is_month() ) {
        echo '<a class="no-link" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
        echo $before . get_the_time( 'F' ) . $after;

    }
    elseif ( is_year() ) {
        echo $before . get_the_time( 'Y' ) . $after;

    }
    elseif ( is_single() && ! is_attachment() ) {
        if ( get_post_type() != 'post' ) {
            $post_type = get_post_type_object( get_post_type() );
            $slug      = $post_type->rewrite;
            echo '<a class="no-link" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        }
        else {
            $cat = get_the_category();
            $cat = $cat[0];
            echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
            echo $before . get_the_title() . $after;
        }
    }
    elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
        $post_type = get_post_type_object( get_post_type() );
        echo $before . $post_type->labels->singular_name . $after;

    }
    elseif ( is_attachment() ) {
        $parent = get_post( $post->post_parent );
        $cat    = get_the_category( $parent->ID );
        $cat    = $cat[0];
        echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
        echo '<a class="no-link" href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;

    }
    elseif ( is_page() && ! $post->post_parent ) {
        echo $before . ucfirst( strtolower( get_the_title() ) ) . $after;

    }
    elseif ( is_page() && $post->post_parent ) {
        $parent_id   = $post->post_parent;
        $breadcrumbs = array();

        while ( $parent_id ) {
            $page          = get_page( $parent_id );
            $breadcrumbs[] = '<a class="no-link" href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
            $parent_id     = $page->post_parent;
        }

        $breadcrumbs = array_reverse( $breadcrumbs );
        foreach ( $breadcrumbs as $crumb ) {
            echo $crumb . ' ' . $delimiter . ' ';
        }
        echo $before . get_the_title() . $after;

    }
    elseif ( is_search() ) {
        echo $before . 'Search results for "' . get_search_query() . '"' . $after;

    }
    elseif ( is_tag() ) {
        echo $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;

    }
    elseif ( is_author() ) {
        global $author;
        $userdata = get_userdata( $author );
        echo $before . 'Articles posted by ' . $userdata->display_name . $after;

    }
    elseif ( is_404() ) {
        echo $before . 'Error 404' . $after;
    }

    if ( get_query_var( 'paged' ) ) {
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
            echo ' (';
        }
        echo $before . __( 'Page', 'yiw' ) . ' ' . get_query_var( 'paged' ) . $after;
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
            echo ')';
        }
    }
    echo '</p>';

}

/**
 * Retrieve the search form
 */
function yiw_search_form( $label = false, $submit_label = false, $post_type = false ) {

    global $yith_wcas;

    if ( isset( $yith_wcas ) ) {
        echo do_shortcode( '[yith_woocommerce_ajax_search]' );
    }
    else {
        if ( $label != false ) {
            $label_cb = create_function( '', "return '$label';" );
            add_filter( 'yiw_searchform_label', $label_cb );
        }

        if ( $submit_label != false ) {
            $submit_label_cb = create_function( '', "return '$submit_label';" );
            add_filter( 'yiw_searchform_submit_label', $submit_label_cb );
        }

        if ( $post_type != false ) {
            $post_type_cb = create_function( '', "return '$post_type';" );
            add_filter( 'yiw_searchform_post_type', $post_type_cb );
        }

        get_search_form();

        if ( $label != false ) {
            remove_filter( 'yiw_searchform_label', $label_cb );
        }
        if ( $submit_label != false ) {
            remove_filter( 'yiw_searchform_submit_label', $submit_label_cb );
        }
        if ( $post_type != false ) {
            remove_filter( 'yiw_searchform_post_type', $post_type_cb );
        }
    }

}

/**
 * Retrive the icon from the database and return it in a <i> tag.
 *
 * @param $icon_name
 * @param $return_tag
 *
 * @return string
 */
function yiw_get_icon( $icon_name, $default = false, $return_tag = false ) {
    $icon = maybe_unserialize( yiw_get_option( $icon_name, $default ) );

    if ( ! $return_tag ) {
        return $icon['icon'];
    }

    if ( ! empty( $icon['custom'] ) ) {
        return '<img src="' . $icon['custom'] . '" alt="' . $icon['icon'] . '" />';
    }
    else {
        return '<i class="' . $icon['icon'] . '"></i>';
    }
}

function yiw_get_fonticon( $icon_name ) {
    return yiw_get_icon( $icon_name, false );
}

function yiw_qtranslate_compatibility() {
    global $yiw_theme_options;

    if ( ! function_exists( 'qtrans_useCurrentLanguageIfNotFoundShowAvailable' ) ) {
        return;
    }

    $yiw_theme_options = yiw_qtranslate_option_walk( $yiw_theme_options );
}

add_action( 'wp_head', 'yiw_qtranslate_compatibility', 1 );

function yiw_qtranslate_option_walk( $option ) {
    if ( is_serialized( $option ) ) {
        $serialized = true;
    }
    else {
        $serialized = false;
    }

    $option = maybe_unserialize( $option );

    if ( is_array( $option ) ) {
        foreach ( $option as $id => $val ) {
            $option[$id] = yiw_qtranslate_option_walk( $val );
        }
        if ( $serialized ) {
            $option = serialize( $option );
        }
    }
    else {
        $option = preg_replace( '/\[([a-z]{2})\]/', '<!--:$1-->', $option );
        $option = preg_replace( '/\[\/([a-z]{2})\]/', '<!--:-->', $option );
        $option = qtrans_useCurrentLanguageIfNotFoundShowAvailable( $option );
    }
    return $option;
}

function yiw_translate( $string ) {
    if ( ! function_exists( 'qtrans_useCurrentLanguageIfNotFoundShowAvailable' ) ) {
        return $string;
    }

    $string = preg_replace( '/\[([a-z]{2})\]/', '<!--:$1-->', $string );
    $string = preg_replace( '/\[\/([a-z]{2})\]/', '<!--:-->', $string );
    $string = qtrans_useCurrentLanguageIfNotFoundShowAvailable( $string );

    return $string;
}

/*
 *  Twitter API
 */
if ( ! function_exists( 'buildBaseString' ) ) {
    function buildBaseString( $baseURI, $method, $params ) {
        $r = array();
        ksort( $params );
        foreach ( $params as $key => $value ) {
            $r[] = "$key=" . rawurlencode( $value );
        }

        return $method . "&" . rawurlencode( $baseURI ) . '&' . rawurlencode( implode( '&', $r ) ); //return complete base string
    }
}

if ( ! function_exists( 'buildAuthorizationHeader' ) ) {
    function buildAuthorizationHeader( $oauth ) {
        $r      = 'Authorization: OAuth ';
        $values = array();
        foreach ( $oauth as $key => $value ) {
            $values[] = "$key=\"" . rawurlencode( $value ) . "\"";
        }

        $r .= implode( ', ', $values );
        return $r;
    }
}

if ( ! function_exists( 'yit_get_tweets' ) ) {
    function yit_get_tweets( $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret, $limit ) {

        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $oauth = array( 'oauth_consumer_key'     => $consumer_key,
                        'oauth_nonce'            => time(),
                        'oauth_signature_method' => 'HMAC-SHA1',
                        'oauth_token'            => $oauth_access_token,
                        'oauth_timestamp'        => time(),
                        'count'                  => $limit,
                        'oauth_version'          => '1.0' );

        $base_info                = buildBaseString( $url, 'GET', $oauth );
        $composite_key            = rawurlencode( $consumer_secret ) . '&' . rawurlencode( $oauth_access_token_secret );
        $oauth_signature          = base64_encode( hash_hmac( 'sha1', $base_info, $composite_key, true ) );
        $oauth['oauth_signature'] = $oauth_signature;


        $header  = array( buildAuthorizationHeader( $oauth ), 'Expect:' );
        $options = array( CURLOPT_HTTPHEADER     => $header,
                          CURLOPT_HEADER         => false,
                          CURLOPT_URL            => $url . '?count=' . $limit,
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_SSL_VERIFYPEER => false );

        $feed = curl_init();

        curl_setopt_array( $feed, $options );
        $json = curl_exec( $feed );
        curl_close( $feed );
        return json_decode( $json );
    }
}

if ( !function_exists( "get_slider_mobile_hide_class" ) ) {

    function yit_slider_mobile_hide_class() {

        if ( yiw_get_option( 'slider_responsive' ) != 'leave' ) {
            return "not-for-mobile";
        }

    }
}


if( !function_exists( 'yiw_print_mobile_favicons' ) ) {
    /**
     * Print the html for mobile devices favicons.
     *
     * @return string
     * @author Andrea Frascaspata    <andrea.frascaspata@yithems.com>
     * @since 1.0.0
     */
    function yiw_print_mobile_favicons() {

        // 144: For iPad3 with retina display:
        // 114: for first- and second-generation iPad
        //  72: For first- and second-generation iPad
        //  57: For non-Retina iPhone, iPod Touch, and Android 2.1+ devices

        $size_list = array(144,114,72,57);

        $favicon_base_url =  yiw_get_option( 'general-favicon-touch' );

        //yit default favicons
        if ( $favicon_base_url===false || empty( $favicon_base_url ) || $favicon_base_url == get_template_directory_uri() . '/apple-touch-icon-144x.png' ) {

            foreach ( $size_list as $size ) {
                $favicon_url = get_template_directory_uri() . '/apple-touch-icon-'.$size.'x.png';
                if ( is_ssl() ) {
                    $favicon_url = str_replace( 'http://', 'https://', $favicon_url );
                }
                echo '<link rel="apple-touch-icon-precomposed" sizes="' . $size . 'x' . $size . '" href="' . $favicon_url . '" />';
            }

        }
        //custom favicon
        else {

            foreach ( $size_list as $size ) {

                $size_name = 'favicon_' . $size;

                add_image_size( $size_name, $size, $size, true );

                $args['src']  = $favicon_base_url;
                $args['output'] = 'url';
                $args['size'] = $size_name;

                $url = yit_image( $args, false );

                echo '<link rel="apple-touch-icon-precomposed" sizes="' . $size . 'x' . $size . '" href="' . $url . '" />';
            }

        }

    }
}

?>