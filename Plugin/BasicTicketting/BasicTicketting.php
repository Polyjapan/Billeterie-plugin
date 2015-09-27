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

class BaTi_Plugin
{
	public function __construct()
	{
		// class inclusion
		require_once plugin_dir_path( __FILE__ ).'/db/database.php'; 
		
		// hooks
		// At the activation
		register_activation_hook(__FILE__, array('BaTi_Install_Plugin', 'BaTi_install_DB'));

		// At the uninstallation
		register_uninstall_hook(__FILE__, array('BaTi_Install_Plugin', 'BaTi_uninstall_DB'));
	}
}
