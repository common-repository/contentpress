<?php
/*
Plugin Name: Contentpress
Plugin URI: https://www.omegatheme.com/
Description:  Content Press is a plugin for wordpress that helps to shows the list of content as the table that included with the filter by: Defined Categories, Defined years and Alphabet filter.
Author: Omegatheme
Version: 1.2.2
Company: XIPAT Flexible Solutions 
Author URI: http://www.omegatheme.com
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'CONTENTPRESS_VERSION', '1.2.1' );
define( 'CONTENTPRESS__MINIMUM_WP_VERSION', '4.0' );
define( 'CONTENTPRESS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CONTENTPRESS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CONTENTPRESS_DELETE_LIMIT', 100000 );
define('PhpThumbFactoryLoaded', 1);  

register_activation_hook( __FILE__, array( 'Contentpress', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Contentpress', 'plugin_deactivation' ) );

require_once( CONTENTPRESS__PLUGIN_DIR . 'class.contentpress.php' );
//require_once (CONTENTPRESS__PLUGIN_DIR . '/libraries/phpthumb/ThumbLib.inc.php');
add_action( 'init', array( 'Contentpress', 'init' ) );
add_action( 'init', array( 'Contentpress', 'contentpress_style' ) );
if ( is_admin() ) {
	require_once( CONTENTPRESS__PLUGIN_DIR . 'class.contentpress-admin.php' );
	add_action( 'init', array( 'Contentpress_Admin', 'init' ) );
    add_action('admin_init', array('Contentpress_Admin', 'register_contentpress'));  
}

function contentpress_e($text, $params=null) {
    if (!is_array($params)) {
        $params = func_get_args();
        $params = array_slice($params, 1);
    }
    return vsprintf(__($text, 'contentpress'), $params);
}


