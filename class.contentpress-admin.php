<?php

class Contentpress_Admin {

	public static function init() { 
        add_action( 'admin_menu', array( 'Contentpress_Admin', 'contentpress_admin_menu' ) );   
	} 
    
    function register_contentpress() {        
      register_setting( 'contentpress-options', 'contentpress-options' );
      register_setting( 'contentpress-options', 'params_category' );
      register_setting( 'contentpress-options', 'params_year' );                 
    }   

    public static function file_path($file) {
        return ABSPATH.'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).$file;
    }    
    
    function contentpress_admin_menu() {
        add_options_page('Contentpress', 'Contentpress', 'administrator',
        'contentpress', array( 'Contentpress_Admin', 'contentpress_html_page' ));  
    }    

    function contentpress_html_page() {
        include(self::file_path('options.php'));        
    }   
    
}