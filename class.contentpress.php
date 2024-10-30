<?php

class Contentpress {

    public static function init() {
       // add_action('admin_menu', 'contentpress_admin_menu');  
       add_shortcode( 'contentpress', array( 'Contentpress', 'handler_shortcode' ) );
       
        if (!function_exists('getfirstimage')) {
            function getfirstimage($content) {
                preg_match_all('/<\s*img [^\>]*src\s*=\s*[\""\']?([^\""\'\s>]*)/i', $content, $images);
                return isset($images[1][0])?$images[1][0]:"";
            }
        }  
       
    }

    public static function file_path($file) {
        return ABSPATH.'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).$file;
    }  
    
    function contentpress_style() {
        wp_enqueue_style('contentpress_style', plugins_url('/css/style.css',__FILE__ ));
        wp_enqueue_script( 'contentpress_scripts', plugins_url('/js/jquery.masonry.min.js', __FILE__), array( 'jquery' ) );
        wp_enqueue_script( 'contentpress_custom_scripts', plugins_url('/js/contentpress.js', __FILE__), array( 'jquery' ) );
    }
      
    
    public function handler_shortcode($att)
    {    
        if (isset($att['name']) && $att['name'] == 'list')
        {
            return Contentpress::contentpress_display_list($att['name']);
        }
        else
        {
            return Contentpress::contentpress_display_blog($att['name']);  
        }
    }
    
    public function contentpress_display_list($preset_name)
    {  
        $options = get_option('contentpress-options'); 
        $options_cat = get_option('params_category'); 
        $options_year = get_option('params_year'); 
        include(self::file_path('view/list.php'));  
    }
    
    public function contentpress_display_blog($preset_name)
    {
        $options = get_option('contentpress-options'); 
        $options_cat = get_option('params_category'); 
        $options_year = get_option('params_year'); 
        include(self::file_path('view/blog.php'));  
    }

    function plugin_activation() {

        global $wpdb;

        $the_page_title = 'Contentpress';
        $the_page_name = 'contentpress';

        // the menu entry...
        delete_option("contentpress_page_title");
        add_option("contentpress_page_title", $the_page_title, '', 'yes');
        // the slug...
        delete_option("contentpress_page_name");
        add_option("contentpress_page_name", $the_page_name, '', 'yes');
        // the id...
        delete_option("contentpress_page_id");
        add_option("contentpress_page_id", '0', '', 'yes');

        $the_page = get_page_by_title( $the_page_title );

        if ( ! $the_page ) {

            // Create post object
            $_p = array();
            $_p['post_title'] = $the_page_title;
            $_p['post_content'] = '[contentpress name="list"]';
            $_p['post_status'] = 'publish';
            $_p['post_type'] = 'page';
            $_p['comment_status'] = 'closed';
            $_p['ping_status'] = 'closed';
            $_p['post_category'] = array(1); // the default 'Uncatrgorised'

            // Insert the post into the database
            $the_page_id = wp_insert_post( $_p );

        }
        else {
            // the plugin may have been previously active and the page may just be trashed...

            $the_page_id = $the_page->ID;

            //make sure the page is not trashed...
            $the_page->post_status = 'publish';
            $the_page_id = wp_update_post( $the_page );

        }
         
        delete_option( 'contentpress_page_id' );
        add_option( 'contentpress_page_id', $the_page_id );
    }

    function plugin_deactivation() {

        global $wpdb;

        $the_page_title = get_option( "contentpress_page_title" );
        $the_page_name = get_option( "contentpress_page_name" );

        //  the id of our page...
        $the_page_id = get_option( 'contentpress_page_id' );
        if( $the_page_id ) {

            wp_delete_post( $the_page_id ); // this will trash, not delete

        }

        delete_option("contentpress_page_title");
        delete_option("contentpress_page_name");
        delete_option("contentpress_page_id");

    }

    function filter_query( $where = '' ) {
        global $wpdb;
        $years= $_POST["y"]; 
        $search = $_POST["filter-search"];
        $authors = $_POST["fauthor"];
        $alphabet = isset($_POST["falphabet"])?$_POST["falphabet"]:'all';
        
        if($alphabet != 'all') $where .= " AND post_title LIKE '".$alphabet."%'";
        if($search != '') $where .= " AND post_title LIKE '%".$search."%'";
        if((int)$authors > 0) $where .= $wpdb->prepare( " AND post_author = %s", $authors); 
        if((int)$years > 0) $where .= $wpdb->prepare( " AND post_date >= %s AND post_date <= %s", $years.'-01-01 00:00:00', $years.'-12-31 00:00:00');
        else $where .= $wpdb->prepare( " AND post_date >= %s AND post_date <= %s", '00-00-00 00:00:00', current_time( 'mysql' ));  
        return $where;
    }  

}