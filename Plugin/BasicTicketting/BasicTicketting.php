<?php
/*
Plugin Name: BasicTicketting
Plugin URI: 
Description: Management of the ticketing system used in Japan Impact
Version: 0.1
Author: Fabien Mottier, Tony Clavien
Author URI: www.japan-impact.ch
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// class inclusion
require_once plugin_dir_path( __FILE__ ).'/db/database.php'; 
require_once plugin_dir_path( __FILE__ ).'/menus/admin-menu.php';
require_once plugin_dir_path( __FILE__ ).'/core/core.php';

// hooks
	// At the activation
	register_activation_hook(__FILE__, array('BaTi_Install_Plugin', 'BaTi_install_DB'));

	// At the uninstallation
	register_uninstall_hook(__FILE__, array('BaTi_Install_Plugin', 'BaTi_uninstall_DB'));
		
	/* Register the admin menu action hook */
	add_action( 'admin_menu','BaTi_create_admin_menu');
	
	/* Register the shortcode */
	add_shortcode('Ticketing','BaTi_getBasicTicketting');
	
	function BaTi_frontend_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
	}
	add_action('wp_enqueue_scripts', 'BaTi_frontend_scripts');
	
	/**
	*	Arguments List
	*	Types of tickets
	*	Name of Events
	*	Origins
	*	"Image of pdf"
	*	View List
		List of client
	*/

	