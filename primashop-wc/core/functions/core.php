<?php
/**
 * Core functions of PrimaThemes framework.
 *
 * WARNING: This file is part of the core PrimaThemes framework.
 * DO NOT edit this file under any circumstances. 
 *
 * @category   PrimaThemes
 * @package    Framework
 * @subpackage Functions
 * @author     PrimaThemes
 * @link       http://www.primathemes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add "add_post_type_support"-like function, but for taxonomy.
 *
 * @since PrimaThemes 2.0
 */
function prima_add_taxonomy_support( $taxonomy, $feature ) {
	global $_prima_taxonomy_features;
	$features = (array) $feature;
	foreach ($features as $feature) {
		if ( func_num_args() == 2 )
			$_prima_taxonomy_features[$taxonomy][$feature] = true;
		else
			$_prima_taxonomy_features[$taxonomy][$feature] = array_slice( func_get_args(), 2 );
	}
}

/**
 * Add "remove_post_type_support"-like function, but for taxonomy.
 *
 * @since PrimaThemes 2.0
 */
function prima_remove_taxonomy_support( $taxonomy, $feature ) {
	global $_prima_taxonomy_features;
	if ( !isset($_prima_taxonomy_features[$taxonomy]) )
		return;
	if ( isset($_prima_taxonomy_features[$taxonomy][$feature]) )
		unset($_prima_taxonomy_features[$taxonomy][$feature]);
}

/**
 * Add "post_type_supports"-like function, but for taxonomy.
 *
 * @since PrimaThemes 2.0
 */
function prima_taxonomy_supports( $taxonomy, $feature ) {
	global $_prima_taxonomy_features;
	if ( !isset( $_prima_taxonomy_features[$taxonomy][$feature] ) )
		return false;
	if ( func_num_args() <= 2 )
		return true;
	return true;
}

/**
 * Return formatted setting from options database.
 *
 * @since PrimaThemes 2.0
 */
function prima_get_setting( $option = '', $field = null, $format = '' ) {
	global $prima;
	$field = $field ? $field : PRIMA_THEME_SETTINGS;
	if ( !$option )
		return false;
	$pre_setting = apply_filters('prima_get_setting_'.$option, false, $field);
	if ( false !== $pre_setting ) {
		if ( is_ssl() ) 
			$pre_setting = str_replace("http://", "https://", $pre_setting);
		return $pre_setting;
	}
	$settings = get_option( $field );
	if ( !array_key_exists($option, (array) $settings) )
		return false;
	$output = wp_kses_stripslashes( $settings[$option] );
	if ( !$output ) 
		return false;
	if ( is_ssl() ) 
		$output = str_replace("http://", "https://", $output);
	if ( !$format ) 
		return $output;
	else return str_replace("%setting%", $output, $format);
}

/**
 * Echo formatted setting from options database.
 *
 * @since PrimaThemes 2.0
 */
function prima_setting( $option, $field = null, $format = '' ) {
	echo prima_get_setting( $option, $field, $format );
}

/**
 * Return formatted post meta.
 *
 * @since PrimaThemes 2.0
 */
function prima_get_post_meta( $meta, $postid = '', $format = '' ) {
	if ( !$postid ) { 
		global $post;
		if ( null === $post ) 
			return false;
		else 
			$postid = $post->ID;
	}
	$meta_value = get_post_meta($postid, $meta, true);
	if ( !$meta_value ) 
		return false;
	$meta_value = wp_kses_stripslashes( wp_kses_decode_entities( $meta_value ) );
	if ( is_ssl() ) 
		$meta_value = str_replace("http://", "https://", $meta_value);
	if ( !$format ) 
		return $meta_value;
	else return str_replace("%meta%", $meta_value, $format);
}

/**
 * Echo formatted post meta.
 *
 * @since PrimaThemes 2.0
 */
function prima_post_meta( $meta, $postid = '', $format = '' ) {
	echo prima_get_post_meta( $meta, $postid, $format );
}

/**
 * Return formatted taxonomy meta.
 *
 * @since PrimaThemes 2.0
 */
function prima_get_tax_meta( $meta, $term_id, $taxonomy ) {
	$tax_meta = (array) get_option( 'prima_taxonomy_meta' );
	if ( isset($tax_meta[$taxonomy][$term_id][$meta]) ) {
		$meta_value = $tax_meta[$taxonomy][$term_id][$meta];
		if ( is_ssl() ) 
			$meta_value = str_replace("http://", "https://", $meta_value);
		return $meta_value;
	}
	else {
		return false;
	}
}

/**
 * Echo formatted taxonomy meta.
 *
 * @since PrimaThemes 2.0
 */
function prima_tax_meta( $meta, $term_id, $taxonomy ) {
	echo prima_get_tax_meta( $meta, $term_id, $taxonomy );
}

/**
 * Return file path from child theme (if exist) or parent theme.
 *
 * @since PrimaThemes 2.0
 */
function prima_childtheme_file($file) {
	if ( ( PRIMA_DIR != THEME_DIR ) && file_exists(trailingslashit(THEME_DIR).$file) ) 
		$url = trailingslashit(THEME_URI).$file;
	else 
		$url = trailingslashit(PRIMA_URI).$file;
	return $url;
}
