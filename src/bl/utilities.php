
<?php if ( ! defined('WP_CONTENT_DIR')) exit('No direct script access allowed'); ?>
<?php

class RDP_WPB_UTILITIES {
    static function abortExecution(){
        $rv = false;
        $wp_action = self::globalRequest('action');
        if($wp_action == 'heartbeat')$rv = true;
        $isScriptStyleImg = self::isScriptStyleImgRequest();
        if($isScriptStyleImg)$rv = true;           
        return $rv;
    }//abortExecution        
    
    public static function globalRequest( $name, $default = '' ) {
        $RV = '';
        $array = $_GET;

        if ( isset( $array[ $name ] ) ) {
                $RV = $array[ $name ];
        }else{
            $array = $_POST;
            if ( isset( $array[ $name ] ) ) {
                    $RV = $array[ $name ];
            }                
        }
        
        if(empty($RV) && !empty($default)) return $default;
        return $RV;
    }    
    
    static function isScriptStyleImgRequest(){
        $url = (isset($_SERVER['REQUEST_URI']))? $_SERVER['REQUEST_URI'] : '';        
        $exts = array("js", "css","gif", "jpg", "jpeg", "png", "tiff", "tif", "bmp");
        $url_parts = parse_url($url);        
        $path = (empty($url_parts["path"]))? '' : $url_parts["path"];
        $urlExt = pathinfo($path, PATHINFO_EXTENSION);
        return in_array($urlExt, $exts);
    }//isScriptStyleImgRequest      
    
    public static function rgempty( $name, $array = null ) {
        if ( is_array( $name ) ) {
                return empty( $name );
        }

        if ( ! $array ) {
                $array = $_POST;
        }

        $val = self::rgar( $array, $name );

        return empty( $val );
    }//rgempty
    
    public static function rgget( $name, $array = null ) {
        if ( ! isset( $array ) ) {
                $array = $_GET;
        }

        if ( isset( $array[ $name ] ) ) {
                return $array[ $name ];
        }

        return '';
    }    

    public static function rgpost( $name, $do_stripslashes = true ) {
        if ( isset( $_POST[ $name ] ) ) {
                return $do_stripslashes ? stripslashes_deep( $_POST[ $name ] ) : $_POST[ $name ];
        }

        return '';
    }    
    
    public static function rgar( $array, $name ) {
        if ( isset( $array[ $name ] ) ) {
                return $array[ $name ];
        }

        return '';
    }//rgar  
        
}//RDP_WPB_UTILITIES
