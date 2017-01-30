<?php if ( ! defined('WP_CONTENT_DIR')) exit('No direct script access allowed'); ?>
<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @author Robert D Payne
 */
class RDP_WPB_ADMIN {
    private $version;
    private $plugin_name;
    protected $_admin_view_page = null;    

    public function __construct($plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ), 998 ); 
      
        // Add the options page and menu item.
        add_action( 'admin_menu', array( &$this, 'add_plugin_admin_menu' ) );   

        add_action( 'current_screen', array( &$this, 'view_handler' ) );
    }//__construct
    
    
    /**
     * Instantiate appropriate settings page for this plugin. Otherwise, bail if request
     * is none of our concern.
     *
     * @since    1.0.0
     * 
     * @return void
     */
    public function view_handler() {
        $screen = get_current_screen();
        $optionPage = RDP_WPB_UTILITIES::globalRequest('option_page');
        
        if(false === strpos($screen->id, $this->plugin_name) && $optionPage != RDP_WPB_PLUGIN::PLUGIN_OPTIONS_NAME) return;
        
        $page = RDP_WPB_UTILITIES::globalRequest('page');
        
        switch ($page) {
            case $this->plugin_name:
                include_once( 'admin_page1.php' );
                $this->_admin_view_page = RDP_WPB_ADMIN_PAGE_1::get_instance();
                break;

            default:
                include_once( 'admin_page2.php' );
                $this->_admin_view_page = RDP_WPB_ADMIN_PAGE_2::get_instance();
                $this->_admin_view_page->page_init();                
                
                break;
        }
    }//view_handler
    
    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     * 
     * @return void
     */
    public function add_plugin_admin_menu() {
        if ( !current_user_can('activate_plugins') ) return;
        add_menu_page( 
                __( 'RDP WordPress Plugin Boilerplate (Page 1)', $this->plugin_name ), 
                __( 'RDP WP Boilerplate', $this->plugin_name ), 
                'publish_posts', 
                RDP_WPB_PLUGIN::PLUGIN_SLUG, 
                array( $this, 'display_plugin_admin_page' ),
                'dashicons-randomize', 90 );

        add_submenu_page( 
                RDP_WPB_PLUGIN::PLUGIN_SLUG, 
                __('RDP WordPress Plugin Boilerplate (Page 1)',  RDP_WPB_PLUGIN::PLUGIN_SLUG), 
                __('Page 1',  RDP_WPB_PLUGIN::PLUGIN_SLUG), 
                "publish_posts", 
                RDP_WPB_PLUGIN::PLUGIN_SLUG, 
                array( $this, 'display_plugin_admin_page' ) );   
        
        add_submenu_page( 
                RDP_WPB_PLUGIN::PLUGIN_SLUG, 
                __('RDP WordPress Plugin Boilerplate (Page 2)',  RDP_WPB_PLUGIN::PLUGIN_SLUG), 
                __('Page 2',  RDP_WPB_PLUGIN::PLUGIN_SLUG),
                'publish_posts', 
                RDP_WPB_PLUGIN::PLUGIN_SLUG.'-page-2', 
                array( $this, 'display_plugin_admin_page' ));
    }//add_plugin_admin_menu 
    
    
    /**
    * Render the settings page for this plugin.
    *
    * @since    1.0.0
    */
    public function display_plugin_admin_page() {
        $this->_admin_view_page->display();
    }//display_plugin_admin_page
    
    /**
    * Enqueue admin styles for this plugin.
    *
    * @since    1.0.0
    */
    public function enqueue_styles() {
        wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/admin-style.css',
                array(),
                $this->version,
                'all'
        );
    }//stylesEnqueue    


    
}//RDP_WPB_ADMIN


