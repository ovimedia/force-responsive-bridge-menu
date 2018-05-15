<?php
/*
Plugin Name: Force Responsive Bridge Menu
Description: Force to show the menu in responsive version below the specified width.
Author: Ovi García - ovimedia.es
Author URI: http://www.ovimedia.es/
Text Domain: force-responsive-bridge-menu
Version: 0.3
Plugin URI: http://www.ovimedia.es/
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

if ( ! class_exists( 'force_responsive_bridge_menu' ) ) 
{
	class force_responsive_bridge_menu 
    {
        function __construct() 
        {   
            add_action( 'init', array( $this, 'frbm_load_languages') );
            add_action( "wp_head", array( $this,  "frbm_head_style"), 10  );
            add_action( 'customize_register', array( $this, 'frbm_customize_register') );
            add_filter( 'plugin_action_links_'.plugin_basename( plugin_dir_path( __FILE__ ) . 'force_responsive_bridge_menu.php'), array( $this, 'frbm_plugin_settings_link' ) );
        }

        public function frbm_load_languages() 
        {
            load_plugin_textdomain( 'force-responsive-bridge-menu', false, '/'.basename( dirname( __FILE__ ) ) . '/languages/' ); 
        }

        public function frbm_head_style()
        {
            if(get_option("frbm_value") != "")
            {
                echo "<style>@media screen and (min-width: 1000px) and (max-width: ".get_option("frbm_value")."px){";
                echo "#menu-menu, .main_menu.left_side,.main_menu.right_side{display: none !important;}";
                echo ".mobile_menu{display: block !important;}";
                echo ".mobile_menu_button{display: table !important;float: right !important;}";
                echo ".header_inner_left {position: relative !important; width: 100% !important;}";
                echo "}</style>";
            }
        }

        public function frbm_customize_register( $wp_customize ) 
        {
            $wp_customize->add_section('force_responsive_bridge_menu', array(
                'priority' => 100,
                'title' => translate( 'Responsive Menu' , 'force-responsive-bridge-menu' )
            ));
        
            $wp_customize->add_setting('frbm_value', array(
                'default' => get_option("frbm_value"),
                'type' => "option"
            ));
        
            $wp_customize->add_control('frbm_value', array(
                'label'   =>  translate( 'Force responsive menu for screens below (without px):', 'force-responsive-bridge-menu' ),
                'section' => 'force_responsive_bridge_menu',
                'type'    => 'number',
            ));
        }

        public function frbm_plugin_settings_link( $links ) 
        { 
            $settings_link = '<a href="'.admin_url().'/customize.php">'.translate( 'Configure', 'force-responsive-bridge-menu' ).'</a>';
            array_unshift( $links, $settings_link ); 
            return $links; 
        }
    }  
}

$GLOBALS['force_responsive_bridge_menu'] = new force_responsive_bridge_menu();   
    
?>
