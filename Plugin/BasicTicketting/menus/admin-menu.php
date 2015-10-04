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
		
		//call register settings function
		add_action( 'admin_init', 'register_settings' );
	}
	
	/**
	*	Home page for the menu
	*/
	function BaTi_Admin_HomePage()
	{
		//must check that the user has the required capability 
		if (!current_user_can('manage_options'))
		{
		  wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		echo '<div>
			<h1>
				Admin Home Page
			</h1>
		</div>';
	}
	
	/**
	* Sub menu
	*/
	function BaTi_Admin_Manage() 
	{
		$TBillet = "BaTi_tblTypeBillet";
		$TEvents = "BaTi_tblEvent";
		$TOrigine = "BaTi_tblOrigine";
		
		$DEV = true;
		
		if($DEV == true)
		{
			?>
			<div class="wrap-selection">
					<h2> In construction</h2>
					<p> If you want to edit some data, ask the webmaster ;) </p>
			</div>
			<?php
		}
		else
		{
		
			?>
		
			<div class="wrap-selection">
				<h2> BasicTicketting Management</h2>
				<form method="post" action="#">
					<select name="BaTi_choice">
						<option value="<?php echo $TBillet; ?>"><?php echo $TBillet; ?></option>
						<option value="<?php echo $TEvents; ?>"><?php echo $TEvents; ?></option>
						<option value="<?php echo $TOrigine; ?>"><?php echo $TOrigine; ?></option>
					</select>
					<input type="submit" class="BaTi_Admin_submit" name="BaTi_Choice_Sender" value="Selectionner" />
				</form>
			</div>
			</hr>
			<?php
		}
		
		if (isset($_POST["BaTi_Choice_Sender"])) // if a value was selected
		{
			BaTi_Create_Form($_POST["BaTi_choice"]);
		/*
			switch($_POST["BaTi_choice"]) // we show the corresponding menu
			{
				case $TBillet:
					BaTi_managing_TypeBillet();
					break;
				case $TEvents:
					BaTi_managing_Events();
					break;
				case $TOrigine:
					BaTi_managing_Origine();
					break;
			}*/
		}
		/* Get stuff ----------------------------------*/
		if(isset($_GET["src"]))
		{
			switch($_GET["src"])
			{
				case "Origine" :
					echo 'a';
					break;
				case "Events" :
					echo 'b';
					break;
				case "TypeBillet" :
					echo 'c';
					break;
			}
		}
					
		
		/* Origin adding stuff --------------------------------------------------*/
		if (isset($_POST["Bati_New_Origine"])) // if a value from Origin management is added
		{
			global $wpdb;
			$wpdb->insert($wpdb->prefix.'BaTi_tblOrigine',array('oriNom' => $_POST['BaTi_New_Origine_Name']));
			BaTi_managing_Origine();
		}
		
		
		
		
	}
	
	function BaTi_managing_TypeBillet()
	{
		?>
			<h2>Gestion des Types de Billet</h2>
		<?php
	}
	function BaTi_managing_Events()
	{
		?>
			<h2>Gestion des Events</h2>
		<?php
	}
	function BaTi_managing_Origine()
	{
		?>
			<h2>Gestion des Origines</h2>
			<form method="post" action="#">
				<table>
					<tr>
						<th>ID</th>
						<th>Origine</th>
						<th></th>
					</tr>

		<?php
		// get the elements of the table
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}BaTi_tblOrigine");
		foreach($results as $row)
		{
			echo "<tr>";
				echo "<td>";
					echo $row->PKOrigine;
				echo "</td>";
				echo "<td>";
					echo '<input type="text" name="BaTi_Update_Origine_Text" value="'.$row->oriNom.'">';
				echo "</td>";
				echo "<td>";
					echo '<a href=#?src=Origine&action=update&item='.$row->PKOrigine.'&value='.$row->oriNom.'>update</a>';
				echo "</td>";
				echo "<td>";
					echo '<a href=#?src=Origine&action=delete&item='.$row->PKOrigine.'>delete</a>';
				echo "</td>";
			echo "</tr>";
		}
		?>
					<tr>
					<td></td>
					<td><input type="text" name="BaTi_New_Origine_Name"></td>
					<td><input type="submit" value="ajouter" name="Bati_New_Origine" ></td>
					</table>
			</form>
		<?php
	}
	
	function BaTi_Create_Form($tablename)
	{
		?>
		<h2>Gestion de <?php echo $tablename; ?></h2>
			<form method="post" action="#">
				<table>
				<tr>
		<?php
		// get all the elements of the table
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}".$tablename);
		$header = array_keys(get_object_vars ($results['0']));
		$columns = count($header);
		foreach($header as $head)
		{
			echo "<th>".$head."</th>";
		}
		echo "</tr>";
		foreach($results as $object)
		{
			$row = get_object_vars($object);
			$first = true;
			$id = -1;
			foreach($header as $head)
			{
				if($first)
				{
					$first = false;
					$id = $row[$head];
					echo "<td>";
						echo $id;
					echo "</td>";
				}
				else
				{
					echo "<td>";
						echo '<input type="text" name="BaTi_Update_'.$tablename.'_Text" value="'.$row[$head].'">';
					echo "</td>";
				}
			}
			echo "<td>";
					echo '<a href="#?src='.$tablename.'&action=update&item='.$id.'">update</a>';
				echo "</td>";
				echo "<td>";
					echo '<a href="#?src='.$tablename.'&action=delete&item='.$id.'">delete</a>';
				echo "</td>";
			echo "</tr>";
		}
		echo "<tr>";
			echo "<td>";
			echo "</td>";
			for ($i = 2; $i <= $columns; $i++) {
				echo "<td>";
					echo '<input type="text" name="BaTi_New_'.$tablename.'_Text">';
				echo "</td>";
			}
			echo '<td><input type="submit" value="ajouter" name="Bati_New_Origine" ></td>';
		echo "</tr>";
		echo "</table>";
	}
	
	function register_settings() {
		register_setting('myoptions','BaTi_Type_Billet');
		register_setting('myoptions','BaTi_Events');
		register_setting('myoptions','BaTi_Origines');
	}