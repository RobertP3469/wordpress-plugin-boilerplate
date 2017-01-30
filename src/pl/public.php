<?php if ( ! defined('WP_CONTENT_DIR')) exit('No direct script access allowed'); ?>
<?php

class RDP_WPB {
    private $_version;
    private $_options = array();

    public function __construct($version,$options){
        $this->_version = $version;
        $this->_options = $options;
        add_action( 'wp_head', array( $this, 'enqueue_scripts' ), 997 );
		    add_action( 'wp_head', array( $this, 'enqueue_styles' ), 998 );        
    }//__construct
    
    public function enqueue_scripts(){

        // GLOBAL FRONTEND SCRIPTS
        wp_enqueue_script( 
            'rdp-wpb', 
            plugins_url( 'js/script.js' , __FILE__ ), 
            array( 'jquery' ), 
            $this->_version, 
            TRUE
          );        

        $params = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'site_url' => get_site_url()
        );      

        wp_localize_script( 'rdp-wpb', 'rdp_wpb', $params );   

    }//scriptsEnqueue    
    
    public function enqueue_styles(){
        wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/style.css',
                array(),
                $this->version,
                'all'
        );    
    }//enqueue_styles
    
}//RDP_WPB
