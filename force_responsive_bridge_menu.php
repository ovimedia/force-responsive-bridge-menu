<?php
/*
Plugin Name: Force Responsive Bridge Menu
Description: Plugin que fuerza a mostrar el menú en versión responsive al ancho especificado.
Author: Ovi García - ovimedia.es
Author URI: http://www.ovimedia.es/
Text Domain: force_responsive_bridge_menu
Version: 0.1
Plugin URI: http://www.ovimedia.es/
*/


if ( ! class_exists( 'force_responsive_bridge_menu' ) ) 
{
	class force_responsive_bridge_menu 
    {
        function __construct() 
        {   
            add_action( "wp_head", array( $this,  "frbm_head_style"), 10  );
            add_action( 'admin_init', array( $this, 'frbm_register_options') );
            add_action( 'admin_menu', array( $this, 'wype_admin_menu' ));
        }

        public function wype_admin_menu() 
        {	
            add_submenu_page('themes.php', 'Force Responsive Bridge Menu', 'Force Responsive Bridge Menu', 'manage_options',  
                'frbm_options', array( $this,'frbm_form'));
        }  

        
        public function frbm_register_options() 
        {
            register_setting( 'frbm_data_options', 'frbm_value' );
        }

        public function frbm_form()
        {
            ?>

            <div class="frbm_options_form">

            <form method="post" action="options.php">

                <h3><?php echo translate( 'Insert the width of screen to force responsive menu:', 'wp-private-posts' ); ?></h3>

                <?php

                    settings_fields( 'frbm_data_options' ); 
                    do_settings_sections( 'frbm_data_options' ); 

                ?>

                    <input type="number" id="frbm_value" name="frbm_value" placeholder="Screen Width" value="<?php echo get_option("frbm_value"); ?>" />

                <?php submit_button(); ?>

            </form>

            </div>

            <?php
        }

        public function frbm_head_style()
        {
            echo "<style>@media screen and (min-width: 1000px) and (max-width: ".get_option("frbm_value")."px){";

            echo "#menu-menu{display: none !important;}";
            echo ".mobile_menu{display: block !important;margin-top: 40px !important;}";
            echo ".mobile_menu_button{display: table !important;float: right !important;}";
            echo ".header_inner_left {position: relative !important; width: 100% !important;}";
            echo "}</style>";
        }
    }
    

    
}

$GLOBALS['force_responsive_bridge_menu'] = new force_responsive_bridge_menu();   
    
?>
