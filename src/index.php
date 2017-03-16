<?php 
/*
Plugin Name: WordPress Plugin Boilerplate
Plugin URI: http://robert-d-payne.com/
Description: An object oriented boilerplate for developing a WordPress plugin
Version: 1.0.0
Text Domain: wordpress-plugin-boilerplate
Author: Robert D Payne
Author URI: http://robert-d-payne.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

// Turn off all error reporting
//error_reporting(E_ALL^ E_WARNING);
define('RDP_WPB_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('RDP_WPB_PLUGIN_BASEDIR', plugin_dir_path( __FILE__ ));
define('RDP_WPB_PLUGIN_BASEURL', plugins_url( null, __FILE__ ) );
include_once 'bl/utilities.php';

if (!class_exists('RDP_WPB_PLUGIN', FALSE)) {
    /**
    * Main plugin declaration
    *
    * @since      1.0.0
    * @package    RDP_WORDPRESS_PLUGIN_BOILERPLATE
    * @author     Robert D Payne 
    */
    class RDP_WPB_PLUGIN {
        const PLUGIN_VERSION = '1.0.0';
        const PLUGIN_SLUG = 'rdp-wordpress-plugin-boilerplate';
        const PLUGIN_OPTIONS_NAME = 'rdp_wpb_options'; 

        private $_options = array();        
        private static $_instance = NULL;
        
		
        /**
         * Constructor
         *
         * @since    1.0.0		 
         * @access   private
         */		
        private function __construct() {
            // prevent running code unnecessarily
            if(RDP_WPB_UTILITIES::abortExecution())return;
            
            // run the plugin
            add_action('wp_loaded',array( $this, 'run'),1);             
        }//__construct
            
			
        /**
         * Retrieve singleton class instance
         *
         * @since   1.0.0
         * @return 	instance reference to plugin		 
         */
        public static function get_instance(){
            if (NULL === self::$_instance) self::$_instance = new self();
            return self::$_instance;
        } //get_instance 
        
		
        /**
         * Run the plugin
         *
         * @since   1.0.0		 
         * @return 	void
         */		
        public function run() {
              $options = get_option( RDP_WPB_PLUGIN::PLUGIN_OPTIONS_NAME );
              if(empty($options)) $options = self::default_settings();
              if(is_array($options))$this->_options = $options;        
              $this->load_dependencies();   
              $this->define_front_hooks();
              $this->define_admin_hooks();
              $this->define_ajax_hooks();
        } //run 

		
        /**
         * Retrieve default settings
         *
         * @since   1.0.0		 
         * @return 	array of default options settings for the plugin
         */		
        public static function default_settings(){

            return [];

        }//default_settings
		
        
        /**
         * Include necessary code files of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */		
        private function load_dependencies() {
            
            if (is_admin()){
                include_once 'pl/admin.php' ;
            } else {
                include_once 'pl/public.php';
            }		
         
        }//load_dependencies  

        /**
         * Register all of the hooks related to the public area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */		
        private function define_front_hooks(){
            if(defined( 'DOING_AJAX' ))return;
            if(is_admin())return;
            $plugin = new RDP_WPB(RDP_WPB_PLUGIN::PLUGIN_SLUG ,RDP_WPB_PLUGIN::PLUGIN_VERSION, $this->_options);
        }//define_front_hooks

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_admin_hooks() {
            if(!is_admin())return;
            if(defined( 'DOING_AJAX' ))return;            
            $plugin_admin = new RDP_WPB_ADMIN(RDP_WPB_PLUGIN::PLUGIN_SLUG ,RDP_WPB_PLUGIN::PLUGIN_VERSION );
        }//define_admin_hooks     

        /**
         * Register all of the AJAX hooks of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */		
        private function define_ajax_hooks() {
            if(!defined( 'DOING_AJAX' ))return;
        }//define_ajax_hooks		       
        
    } //RDP_WPB_PLUGIN    
}

$RDP_WPB_PLUGIN = RDP_WPB_PLUGIN::get_instance();

