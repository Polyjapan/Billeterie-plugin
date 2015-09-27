<?php
/*
Plugin Name: BasicTicketting
Plugin URI: 
Description: Plugin de gestion de billeterie en ligne pour événements
Version: 0.2
Author: Fabien Mottier, Tony Clavien
Author URI: www.japan-impact.ch
License: GPL2
*/

class BaTi_Plugin
{	
	// Classe du plugin
	

	public function __construct()
	{
		// Constructeur de la classe

		// Inclusion des classes
		include_once plugin_dir_path( __FILE__ ).'/class/manage_DB.php'; 


		// Inclusion des views
		include_once plugin_dir_path( __FILE__ ).'/views/Admin_HomePage.php'; 
		include_once plugin_dir_path( __FILE__ ).'/views/Admin_Manage.php';
		include_once plugin_dir_path( __FILE__ ).'/views/Admin_Event.php';
		include_once plugin_dir_path( __FILE__ ).'/views/Frontend_FirstPage.php';
		
		// Fonction lancée à l'activation
		register_activation_hook(__FILE__, array('BaTi_Install_Plugin', 'BaTi_install_DB'));

		// Fonction lancée à éa désactivation
		register_deactivation_hook(__FILE__, array('BaTi_Install_Plugin', 'BaTi_uninstall_DB'));

		// Inclusion des css
		add_action('admin_enqueue_scripts', array( $this, 'BaTi_add_admin_css'), false);

		// Ajout du menu
		add_action('admin_menu', array($this, 'BaTi_add_admin_menu'),20);

		add_action('init', array( $this, 'BaTi_create_admin_shortcode'));

	}// END __construct()


	function BaTi_add_admin_menu()
    {
    	// Fonction de la création du menu

		add_menu_page('Homepage', 'BasicTicketting', 'manage_options', 'BaTi_HomePage', 'BaTi_Admin_HomePage');
		add_submenu_page('BaTi_HomePage', 'Manage', 'Gestion', 'manage_options', 'BaTi_Manage', 'BaTi_Admin_Manage');

		// Récupération de la valeur de l'option du nombre d'événements
		// Si le formulaire vient d'être envoyé, la modification dans la bd n'a pas encore été faite
		// donc je récupère la valeur du formulaire
		if (isset($_POST["BaTi_Admin_ManageDB_Nbr_Event_sender"]))
		{

			$NbrEvent = $_POST['BaTi_Admin_ManageDB_Nbr_Event'];

		}
		else
		{
			
			$NbrEvent = get_option('BaTi_Admin_ManageDB_Option_NbrEvent');

		}	

		// Boucle pour créer les menus de chaque événements
		for ($IndexEvent = 1; $IndexEvent <= $NbrEvent; $IndexEvent++)
		{

			//Création du dossier pour les images de l'événement
			mkdir(plugin_dir_path( __FILE__ ).'/img/Evenement'.$IndexEvent,777);
			//Création du dossier pour les images de l'événement
			mkdir(plugin_dir_path( __FILE__ ).'/attachment/Evenement'.$IndexEvent,777);

			add_submenu_page('BaTi_HomePage', 'Event'.$IndexEvent, 'Evénement '.$IndexEvent, 'manage_options', 'BaTi_Event'.$IndexEvent, 'BaTi_Admin_Event');
		
		}

	} // END BaTi_add_admin_menu()

	function BaTi_add_admin_css()
	{
		// Ajouter les fichiers CSS

		wp_register_style('basicticketting-admin-css', plugins_url('/css/Admin.css', __FILE__), false, '1.0.4');
    	wp_enqueue_style('basicticketting-admin-css');

	} // END BaTi_add_admin_css()

	function BaTi_create_admin_shortcode()
	{
		// Création des shortcodes

		if (isset($_POST["BaTi_Admin_ManageDB_Nbr_Event_sender"]))
		{

			$NbrEvent = $_POST['BaTi_Admin_ManageDB_Nbr_Event'];

		}
		else
		{
			
			$NbrEvent = get_option('BaTi_Admin_ManageDB_Option_NbrEvent');

		}	

		// Boucle pour créer les menus de chaque événements
		for ($IndexEvent = 1; $IndexEvent <= $NbrEvent; $IndexEvent++)
		{
		
			add_shortcode('BaTi_Event'.$IndexEvent, 'BaTi_Frontend_FirstPage');

		}
		
	} // END BaTi_create_admin_shortcode()

} // END class BaTi_Plugin

new BaTi_Plugin();
?>