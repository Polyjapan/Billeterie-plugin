<?php

	function BaTi_Admin_Manage()
	{
		// Vue ppur la page de gestion de la base de données

		// Création du token de la page
		$nonce = wp_create_nonce('BaTi_Admin_ManageDB_token');


		// Retour formulaire d'ajout d'événements
		if (isset($_POST["BaTi_Admin_ManageDB_Add_Event_sender"]))
		{
			
			// Test de sécurité
			if (!wp_verify_nonce($_POST["BaTi_Admin_ManageDB_noncename"], 'BaTi_Admin_ManageDB_token'))
			{
				
				die('Token non valide');

			}
			else
			{
				// Test si l'utilisateur a rentré une valeur
				if (!empty($_POST["BaTi_Admin_ManageDB_Add_Event"]))
				{

					BaTi_AddEvent();

				}
				else
				{
					
					$ErrorInput = new WP_Error('Event','Le nom de l\'événement ne doit pas être vide.');
				
				}
			}

		}

		// Retour formulaire d'ajout de types de billet
		else if (isset($_POST["BaTi_Admin_ManageDB_Add_Type_Prix_sender"]))
		{
			
			// Test de sécurité
			if (!wp_verify_nonce($_POST["BaTi_Admin_ManageDB_noncename"], 'BaTi_Admin_ManageDB_token'))
			{
				
				die('Token non valide');

			}
			else
			{
				
				// Test si l'utilisateur a rentré une valeur 
				if (!empty($_POST["BaTi_Admin_ManageDB_Add_Type_Name"]))
				{
					
					// Test si la valeur est numérique
					if (is_numeric($_POST["BaTi_Admin_ManageDB_Add_Type_Prix"]))
					{
						
						BaTi_AddType();

					}
					else
					{
						
						$ErrorInput = new WP_Error('TypeBillet','Le prix doit être un nombre.');
					
					}
				}
				else
				{
					
					$ErrorInput = new WP_Error('TypeBillet','Le nom de billet ne doit pas être vide.');

				}
			}
		}

		// Retour formulaire du nombre d'événements
		else if (isset($_POST["BaTi_Admin_ManageDB_Nbr_Event_sender"]))
		{

			// Test de sécurité
			if (!wp_verify_nonce($_POST["BaTi_Admin_ManageDB_noncename"], 'BaTi_Admin_ManageDB_token'))
			{
				
				die('Token non valide');

			}
			else
			{

				// Test si l'option possède une valeur
				if (empty($_POST["BaTi_Admin_ManageDB_Nbr_Event"]))
				{

					delete_option('BaTi_Admin_ManageDB_Option_NbrEvent');

				}
				// Test si la valeur est numérique
				else if (is_numeric($_POST["BaTi_Admin_ManageDB_Nbr_Event"]))
				{

					// Test si le nombre est positif
					if ((int)$_POST["BaTi_Admin_ManageDB_Nbr_Event"] > 0)
					{

						// Test si on a enlevé des événements
						if (get_option('BaTi_Admin_ManageDB_Option_NbrEvent',0) > $_POST['BaTi_Admin_ManageDB_Nbr_Event'])
						{

							BaTi_DeleteOptions();

						}

						// Modifie ou crée l'option
						update_option('BaTi_Admin_ManageDB_Option_NbrEvent',$_POST['BaTi_Admin_ManageDB_Nbr_Event']);

					}
					else
					{

						$ErrorInput = new WP_Error('NbrEvent','Il faut rentrer un nombre positif');

					}

				}
				else
				{
					$ErrorInput = new WP_Error('NbrEvent','Il faut rentrer des uniquement des chiffres pour le nombre d\'événements.');
				}
			}				
		}

		//Formulaire d'ajout d'événements
?>
		<h1>Gestion de la base de données</h1>

		<form method="post" action="#">
			<p>
				Créer un événement: <input type="text" name="BaTi_Admin_ManageDB_Add_Event" class="BaTi_Admin_textbox" />
			<input type="submit" class="BaTi_Admin_submit" name="BaTi_Admin_ManageDB_Add_Event_sender" value="Créer" />
			</p>
			<input type="hidden" name="BaTi_Admin_ManageDB_noncename" value="<?php echo $nonce; ?>" />
		</form>
		<br />

<?php
		
		// Gestion d'erreur
		if( is_wp_error( $ErrorInput ) ) {
    		
    		echo '<div class="BaTi_Admin_div" id="BaTi_Admin_ManageDB_InputDB_Error">'.$ErrorInput->get_error_message('Event').'</div>';
		}

		// Formulaire d'ajout de type de billets
?>
		<form method="post" action="#">
			<p>
				Créer un type de billet: <input type="text" name="BaTi_Admin_ManageDB_Add_Type_Name" class="BaTi_Admin_textbox" />
				Prix: <input type="text" name="BaTi_Admin_ManageDB_Add_Type_Prix" class="BaTi_Admin_textbox" /> CHF
				<input type="submit" name="BaTi_Admin_ManageDB_Add_Type_Prix_sender" class="BaTi_Admin_submit" value="Créer" />
			</p>
			<input type="hidden" name="BaTi_Admin_ManageDB_noncename" value="<?php echo $nonce; ?>" />
		</form>
<?php

		// Gestion d'erreur
		if( is_wp_error( $ErrorInput ) ) {
    		
    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorInput->get_error_message('TypeBillet').'</div>';
		}

		// Option gérant le nombre d'événement
?>
		<h1>Gestion des événements</h1>

		<form method="post" action="#">
			<p>
				Nombre d'événements disponibles: <input type="text" name="BaTi_Admin_ManageDB_Nbr_Event" class="BaTi_Admin_textbox" value="<?php echo get_option('BaTi_Admin_ManageDB_Option_NbrEvent','')?>"/>
				<input type="submit" class="BaTi_Admin_submit" name="BaTi_Admin_ManageDB_Nbr_Event_sender" value="Enregistrer" />
			</p>
			<input type="hidden" name="BaTi_Admin_ManageDB_noncename" value="<?php echo $nonce; ?>" />
		</form>

<?php
		
		// Gestion d'erreur
		if( is_wp_error( $ErrorInput ) ) {
    		
    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorInput->get_error_message('NbrEvent').'</div>';
		}

?>
		<br />
		<div class="BaTi_Admin_div" id="BaTi_Admin_ManageDB_Info_NbrEvent">
			Info:	un shortcode est créé pour chaque événement:
					[BaTi_Event*] (* représente le numéro de l'événement)
		</div>
<?php


	} // END BaTi_Admin_Manage()

	

	function BaTi_AddEvent()
	{
		// Fonction d'ajout d'événements


		// Variable de la base de données WordPress
        global $wpdb;
       
        $wpdb->query("INSERT INTO {$wpdb->prefix}BaTi_tblEvent(eveNom) VALUES('".$_POST["BaTi_Admin_ManageDB_Add_Event"]."');");

	} // END BaTi_AddEvent()

	function BaTi_AddType()
	{
		// Fonction d'ajout de type de billets

		// Variable de la base de données WordPress
        global $wpdb;

        $wpdb->query("INSERT INTO {$wpdb->prefix}BaTi_tblTypeBillet(tybiNom,tybiPrix) VALUES('".$_POST["BaTi_Admin_ManageDB_Add_Type_Name"]."','".$_POST["BaTi_Admin_ManageDB_Add_Type_Prix"]."');");
	} // END BaTi_AddType()

	function BaTi_DeleteOptions()
	{
		// Supprime les options des événements supprimer et les dossiers d'images
		
		$Index;
		$Start = get_option('BaTi_Admin_ManageDB_Option_NbrEvent',0);
		$End = $_POST['BaTi_Admin_ManageDB_Nbr_Event'];

		// Boucle pour atteindre les options de chaque événement supprimer
		for($Index = $Start ; $Index > $End ; $Index--)
		{

			delete_option('BaTi_Admin_Event_Event_Option_EventName_'.$Index);
			
			global $wpdb;

        	$TypebilletOptions = $$wpdb->get_col("SELECT option_name FROM {$wpdb->prefix}options WHERE option_name LIKE 'BaTi_Admin_Event_Event_TypeBillet_Name_%';");

        	foreach ($TypebilletOptions as $TypebilletOption) {
        		
        		delete_option($TypebilletOption);

        	}
			
			delete_option('BaTi_Admin_Event_Pages_Option_Info_Legales_'.$Index);
			delete_option('BaTi_Admin_Event_Pages_Option_FirstPage_Picture_'.$Index);
			delete_option('BaTi_Admin_Event_Pages_Option_Confirmation_Text_'.$Index);
			delete_option('BaTi_Admin_Event_Pages_Option_Confirmation_Text_'.$Index);
			delete_option('BaTi_Admin_Event_Pages_Option_FirstPage_Text_'.$Index);
			delete_option('BaTi_Admin_Event_Mail_Option_Inscription_Content_'.$Id);
			delete_option('BaTi_Admin_Event_Mail_Option_Commande_Content_'.$Id);
			delete_option('BaTi_Admin_Event_Mail_Addresse_Expediteur_'.$Id);

			BaTi_DeleteFolderImg($Index);
			BaTi_DeleteFolderAttachment($Index);

		}

	} // END BaTi_DeleteOptions()

	function BaTi_DeleteFolderImg($Index)
	{
		// Suppression du dossier pour les images de l'événement

		$Id = $Index;

		$FolderEvent = substr(plugin_dir_path( __FILE__ ),0,strlen(plugin_dir_path( __FILE__ ))-6).'img\Evenement'.$Id;

		// Récupère les fichiers du dossier
		$Images = scandir($FolderEvent);

		foreach($Images as $Image)
		{

			if ($Image != "." && $Image != "..")
			{

				// Supprime le fichier
				unlink($FolderEvent.'\\'.$Image);

			}

		}

		// Suprrime le dossier
		rmdir($FolderEvent);

	} // END BaTi_DeleteFolderImg()

	function BaTi_DeleteFolderAttachment($Index)
	{
		// Suppression du dossier pour les images de l'événement

		$Id = $Index;

		$FolderEvent = substr(plugin_dir_path( __FILE__ ),0,strlen(plugin_dir_path( __FILE__ ))-6).'attachment\Evenement'.$Id;

		// Récupère les fichiers du dossier
		$Attachments = scandir($FolderEvent);

		foreach($Attachments as $Attachment)
		{

			if ($Attachment != "." && $Attachment != "..")
			{

				// Supprime le fichier
				unlink($FolderEvent.'\\'.$Attachment);

			}

		}

		// Suprrime le dossier
		rmdir($FolderEvent);

	} // END BaTi_DeleteFolderAttachment()

?>