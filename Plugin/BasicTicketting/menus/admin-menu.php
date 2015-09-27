<?php
/**
		admin menu building code
	*/
	function BaTi_create_admin_menu() 
	{
		/**Adding a top level menus */
		add_menu_page('Homepage', 'BasicTicketting', 'manage_options', 'BaTi_HomePage', 'BaTi_Admin_HomePage');
		/** Adding a sub menu */
		add_submenu_page('BaTi_HomePage', 'Manage', 'Gestion', 'manage_options', 'BaTi_Manage', 'BaTi_Admin_Manage');
	}
	
	/**
	*	Home page for the menu
	*/
	function BaTi_Admin_HomePage()
	{
		echo '<div>
			<h1>
				Admin Home Page
			</h1>
		</div>';
	}
	
	/**
	*
	*/
	function BaTi_Admin_Manage() 
	{
		echo '<div>
			<h1>
				Manage Page
			</h1>
		</div>';
	}