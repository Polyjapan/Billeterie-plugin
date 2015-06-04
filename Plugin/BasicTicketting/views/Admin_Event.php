<?php
	
	function BaTi_Admin_Event()
	{
		// Vue pour la page de gestion d'événement

		// Création du token de la page
		$nonce = wp_create_nonce('BaTi_Admin_Event_token');

		// Récupère le numéro de l'événement
		$Id = substr($_GET["page"],10,strlen($_GET["page"]));

		if (isset($_POST['BaTi_Admin_Event_Menu_sender']))
		{

			$Menu = $_POST['BaTi_Admin_Event_Menu_sender'];

		}

		$Contents = BaTi_ImportDataRichtext($Id);

		// Variables de contenu des richtexts
		$BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content = $Contents[0];
		$BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_Content = $Contents[1];
		$BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_Content = $Contents[2];
		$BaTi_Admin_Event_Mail_Richtext_Inscription_Content = $Contents[3];
		$BaTi_Admin_Event_Mail_Richtext_InscripCommande_Content = $Contents[4];

		// Importe les fichiers et récupère les erreurs 
		$Errors = BaTi_ImportFiles($Id);
		
		if (!empty($Errors['Header']))
		{
			
			$ErrorPictureHeader = $Errors['Header'];

		}
			
		if (!empty($Errors['Content']))
		{
			
			$ErrorPictureContent = $Errors['Content'];

		}

		if (!empty($Errors['FirstPage']))
		{
			
			$ErrorPictureFirstPage = $Errors['FirstPage'];

		}
			
		if (!empty($Errors['Confirmation']))
		{
			
			$ErrorPictureConfirmation = $Errors['Confirmation'];

		}

		if (!empty($Errors['Attachment']))
		{
			
			$ErrorAttachment = $Errors['Attachment'];

		}

		// Met à jour les options et récupère les erreurs
		$ErrorMail = BaTi_UpdateEventOption($Id);	
		
?>
		<h1>Gestion de l'événement <?php echo $Id; ?></h1>

		<br />

		<form method="post" action="#">

			<input type="submit" class="BaTi_Admin_submit" name="BaTi_Admin_Event_Menu_sender" value="Gestion" />
			<input type="submit" class="BaTi_Admin_submit" name="BaTi_Admin_Event_Menu_sender" value="Pages" />
			<input type="submit" class="BaTi_Admin_submit" name="BaTi_Admin_Event_Menu_sender" value="Mail" />

		</form>

		<form method="post" enctype="multipart/form-data" action="#">

			<input type="hidden" name="MAX_FILE_SIZE" value="300000000" />

			<input type="hidden" name="BaTi_Admin_Event_Menu_sender" value="<?php echo $Menu; ?>" />

<?php
			if (!isset($_POST['BaTi_Admin_Event_Menu_sender']) || $Menu == 'Gestion')
			{

?>
				<h2>Gestion de l'événement actuel<h2>
				<p>
					
					Choix de l'événement actuel:
					<?php BaTi_ChoiceEventName($Id);  ?>

				</p>
				<p>
					
					Choix du type de billet: <br />
					<?php BaTi_ChoiceTypeBillet($Id); ?>

				</p>
				<br /><br />
				<h2>Gestion du billet</h2>
				<p>
					Image d'en-tête: <input type="file" name="BaTi_Admin_Event_Event_Header_Picture" />
				</p>
<?php

				// Gestion d'erreur
				if( is_wp_error($ErrorPictureHeader ) )
				{
		    		
		    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorPictureHeader->get_error_message('Header').'</div>';
				}

?>

			<p>
					Image du corps de texte: <input type="file" name="BaTi_Admin_Event_Event_Content_Picture" />
				</p>
<?php

				// Gestion d'erreur
				if( is_wp_error($ErrorPictureContent ) )
				{
		    		
		    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorPictureContent->get_error_message('Content').'</div>';
				}

?>

				<input type="hidden" name="BaTi_Admin_Event_Pages_Richtext_Info_Legales_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Pages_Option_Info_Legales_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Pages_Option_FirstPage_Text_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Pages_Option_Confirmation_Text_'.$Id); ?>" />

				<input type="hidden" name="BaTi_Admin_Event_Mail_Richtext_Inscription_Content_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Inscription_Content_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Mail_Richtext_Commande_Content_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Commande_Content_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Mail_Address_Expediteur" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Addresse_Expediteur_'.$Id); ?>" />

<?php
			}
			
			if ($Menu == 'Pages')
			{

?>

				<h2>Infos légales</h2>
				<?php wp_editor($BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content,"BaTi_Admin_Event_Pages_Richtext_Info_Legales_".$Id); // Crée le Richtext ?>
				<br /><br />
				<h2>Première page du plugin</h2>
				<p>
					Image: 
					<input type="file" name="BaTi_Admin_Event_Pages_FirstPage_Picture" />
				</p>
<?php

				// Gestion d'erreur
				if( is_wp_error( $ErrorPictureFirstPage ) )
				{
		    		
		    		echo '<div class="BaTi_Admin_Error BaTi_Admin_div" >'.$ErrorPictureFirstPage->get_error_message('FirstPage').'</div>';
				}

?>
				<br /><br />
				<?php wp_editor($BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_Content,"BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_".$Id); ?>
				<br /><br />
				<h2>Page de confirmation de commande du plugin</h2>
				<p>
					Image: <input type="file" name="BaTi_Admin_Event_Pages_Confirmation_Picture" />
				</p>
<?php

				// Gestion d'erreur
				if( is_wp_error($ErrorPictureConfirmation ) )
				{
		    		
		    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorPictureConfirmation->get_error_message('Confirmation').'</div>';
				}

?>
				<br /><br />
				<?php wp_editor($BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_Content,"BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_".$Id); ?>

				<input type="hidden" name="BaTi_Admin_Event_Event_Name" value="<?php echo get_option('BaTi_Admin_Event_Event_Option_EventName_'.$Id); ?>" />

<?php

				// Variable de la base de données WordPress
		        global $wpdb;

		        $TypeBillets = $wpdb->get_col("SELECT tybiNom FROM {$wpdb->prefix}BaTi_tblTypeBillet;");

		        foreach($TypeBillets as $TypeBillet)
	        	{	        		

?>
	        		<input type="hidden" name="BaTi_Admin_Event_Event_TypeBillet_Name[]" value="<?php echo get_option('BaTi_Admin_Event_Event_TypeBillet_Name_'.$TypeBillet.'_'.$Id); ?>" />

<?php

	        	}

?>

				<input type="hidden" name="BaTi_Admin_Event_Mail_Richtext_Inscription_Content_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Inscription_Content_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Mail_Richtext_Commande_Content_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Commande_Content_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Mail_Address_Expediteur" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Addresse_Expediteur_'.$Id); ?>" />

<?php
			}
			
			if ($Menu == 'Mail')
			{

?>

				<h2>Gestion du mail de confirmation d'inscription</h2>
				<?php wp_editor($BaTi_Admin_Event_Mail_Richtext_Inscription_Content,"BaTi_Admin_Event_Mail_Richtext_Inscription_Content_".$Id); ?>
				<br /><br />

				<h2>Gestion du mail de confirmation de commande</h2>
				<?php wp_editor($BaTi_Admin_Event_Mail_Richtext_Commande_Content,"BaTi_Admin_Event_Mail_Richtext_Commande_Content_".$Id); ?>

				<br />

				<p>
					Pièce-jointe: <input type="text" name="BaTi_Admin_Event_Mail_Attachment_Name" />
					<input type="file" name="BaTi_Admin_Event_Mail_Attachment_File" />
				</p>

<?php

				// Gestion d'erreur
				if( is_wp_error($ErrorAttachment))
				{
		    		
		    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorAttachment->get_error_message('Attachment').'</div>';
				}

?>

				<br />

				<p>
					Adresse mail de l'expéditeur (optionnel): <input type="text" name="BaTi_Admin_Event_Mail_Address_Expediteur" value="<?php echo get_option('BaTi_Admin_Event_Mail_Option_Address_Expediteur_'.$Id); ?>" />
				</p>
			
<?php

				// Gestion d'erreur
				if( is_wp_error($ErrorMail))
				{
		    		
		    		echo '<div class="BaTi_Admin_div BaTi_Admin_Error" >'.$ErrorMail->get_error_message('Mail').'</div>';
				}

?>

				<input type="hidden" name="BaTi_Admin_Event_Event_Name" value="<?php echo get_option('BaTi_Admin_Event_Event_Option_EventName_'.$Id); ?>" />
				
<?php

				// Variable de la base de données WordPress
		        global $wpdb;

		        $TypeBillets = $wpdb->get_col("SELECT tybiNom FROM {$wpdb->prefix}BaTi_tblTypeBillet;");

		        foreach($TypeBillets as $TypeBillet)
	        	{

?>

	        		<input type="hidden" name="BaTi_Admin_Event_Event_TypeBillet_Name[]" value="<?php echo get_option('BaTi_Admin_Event_Event_TypeBillet_Name_'.$TypeBillet.'_'.$Id); ?>" />

<?php

	        	}

?>

				<input type="hidden" name="BaTi_Admin_Event_Pages_Richtext_Info_Legales_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Pages_Option_Info_Legales_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Pages_Option_FirstPage_Text_'.$Id); ?>" />
				<input type="hidden" name="BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_<?php echo $Id; ?>" value="<?php echo get_option('BaTi_Admin_Event_Pages_Option_Confirmation_Text_'.$Id); ?>" />

<?php

			}

?>
			<br /><br />
			<input type="submit" class="BaTi_Admin_submit" name="BaTi_Admin_Event_sender" value="Enregistrer" />
			<input type="hidden" name="BaTi_Admin_Event_noncename" value="<?php echo $nonce; ?>" />

		</form>

<?php
	}

	function BaTi_ImportDataRichtext($NumEvent)
	{
		// Récupère les données des richtext

		$Id = $NumEvent;

		// Test si la page a été charger pour la première fois ou recharger par le formulaire pur charger la valeur des rich text
		if (isset($_POST["BaTi_Admin_Event_Pages_Richtext_Info_Legales_".$Id]))
		{
				
			$BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content = $_POST["BaTi_Admin_Event_Pages_Richtext_Info_Legales_".$Id];

		}
		else
		{
			
			$BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content = get_option('BaTi_Admin_Event_Pages_Option_Info_Legales_'.$Id,'');

		}

		if (isset($_POST["BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_".$Id]))
		{
				
			$BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_Content = $_POST["BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_".$Id];

		}
		else
		{
			
			$BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_Content = get_option('BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_'.$Id,'');

		}

		if (isset($_POST["BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_".$Id]))
		{
				
			$BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_Content = $_POST["BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_".$Id];

		}
		else
		{
			
			$BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_Content = get_option('BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_'.$Id,'');

		}

		if (isset($_POST["BaTi_Admin_Event_Mail_Richtext_Inscription_Content_".$Id]))
		{
				
			$BaTi_Admin_Event_Mail_Richtext_Inscription_Content = $_POST["BaTi_Admin_Event_Mail_Richtext_Inscription_Content_".$Id];

		}
		else
		{
			
			$BaTi_Admin_Event_Mail_Richtext_Inscription_Content = get_option('BaTi_Admin_Event_Mail_Richtext_Inscription_Content_'.$Id,'');

		}

		if (isset($_POST["BaTi_Admin_Event_Mail_Richtext_Commande_Content_".$Id]))
		{
				
			$BaTi_Admin_Event_Mail_Richtext_Commande_Content = $_POST["BaTi_Admin_Event_Mail_Richtext_Commande_Content_".$Id];

		}
		else
		{
			
			$BaTi_Admin_Event_Mail_Richtext_Commande_Content = get_option('BaTi_Admin_Event_Mail_Richtext_Commande_Content_'.$Id,'');

		}

		$Contents = array($BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content,$BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_Content,$BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_Content,$BaTi_Admin_Event_Mail_Richtext_Inscription_Content,$BaTi_Admin_Event_Mail_Richtext_Commande_Content);

		return $Contents;

	} // END BaTi_ImportDataRichtext()

	function BaTi_UpdateEventOption($NumEvent)
	{
		// Crée ou met à jour les options

		$Id = $NumEvent;

		// Options groupe Event
		if (isset($_POST['BaTi_Admin_Event_Event_Name']))
		{

			update_option('BaTi_Admin_Event_Event_Option_EventName_'.$Id,$_POST['BaTi_Admin_Event_Event_Name']);

		}

		if (isset($_POST['BaTi_Admin_Event_Event_TypeBillet_Name']))
		{

			foreach($_POST['BaTi_Admin_Event_Event_TypeBillet_Name'] as $TypeBillet)
			{

				update_option('BaTi_Admin_Event_Event_TypeBillet_Name_'.$TypeBillet.'_'.$Id,$TypeBillet);

			}

			// Variable de la base de données WordPress
	        global $wpdb;

	        $TypeBillets = $wpdb->get_col("SELECT tybiNom FROM {$wpdb->prefix}BaTi_tblTypeBillet;");

	        foreach($TypeBillets as $TypeBillet)
        	{

        		if (!in_array($TypeBillet,$_POST['BaTi_Admin_Event_Event_TypeBillet_Name']))
        		{

        			delete_option('BaTi_Admin_Event_Event_TypeBillet_Name_'.$TypeBillet.'_'.$Id);

        		}

        	}

		}

		if (!empty($_POST['BaTi_Admin_Event_Event_Content_Picture']))
		{

			update_option('BaTi_Admin_Event_Event_Content_Option_Picture_'.$Id,$_POST['BaTi_Admin_Event_Pages_Confirmation_Text']);

		}
		else
		{

			delete_option('BaTi_Admin_Event_Event_Content_Option_Picture_'.$Id);

		}

		// Options groupe Page

		$Contents = BaTi_ImportDataRichtext($Id);

		// Variables de contenu des richtexts
		$BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content = $Contents[0];
		$BaTi_Admin_Event_Pages_Richtext_FirstPage_Text_Content = $Contents[1];
		$BaTi_Admin_Event_Pages_Richtext_Confirmation_Text_Content = $Contents[2];
		$BaTi_Admin_Event_Mail_Richtext_Inscription_Content = $Content[3];

		if (!empty($BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content))
		{

			update_option('BaTi_Admin_Event_Pages_Option_Info_Legales_'.$Id,$BaTi_Admin_Event_Pages_Richtext_Info_Legales_Content);

		}
		else
		{

			delete_option('BaTi_Admin_Event_Pages_Option_Info_Legales_'.$Id);

		}

		if (!empty($_POST['BaTi_Admin_Event_Pages_FirstPage_Text']))
		{

			update_option('BaTi_Admin_Event_Pages_Option_FirstPage_Text_'.$Id,$_POST['BaTi_Admin_Event_Pages_FirstPage_Text']);

		}
		else
		{

			delete_option('BaTi_Admin_Event_Pages_Option_FirstPage_Text_'.$Id);

		}

		if (!empty($_POST['BaTi_Admin_Event_Pages_Confirmation_Text']))
		{

			update_option('BaTi_Admin_Event_Pages_Option_Confirmation_Text_'.$Id,$_POST['BaTi_Admin_Event_Pages_Confirmation_Text']);

		}
		else
		{

			delete_option('BaTi_Admin_Event_Pages_Option_Confirmation_Text_'.$Id);

		}

		// Options groupe Mail
		if (!empty($BaTi_Admin_Event_Mail_Richtext_Inscription_Content))
		{

			update_option('BaTi_Admin_Event_Mail_Option_Inscription_Content_'.$Id,$BaTi_Admin_Event_Mail_Richtext_Inscription_Content);

		}
		else
		{

			delete_option('BaTi_Admin_Event_Mail_Option_Inscription_Content_'.$Id);

		}

		if (!empty($BaTi_Admin_Event_Mail_Richtext_Commande_Content))
		{

			update_option('BaTi_Admin_Event_Mail_Option_Commande_Content_'.$Id,$BaTi_Admin_Event_Mail_Richtext_Commande_Content);

		}
		else
		{

			delete_option('BaTi_Admin_Event_Mail_Option_Commande_Content_'.$Id);

		}

		if (isset($_POST['BaTi_Admin_Event_Mail_Address_Expediteur']))
		{
			
			if (!empty($_POST['BaTi_Admin_Event_Mail_Address_Expediteur']))
			{

				// Test la validité du format de l'adresse mail
				if (filter_var($_POST['BaTi_Admin_Event_Mail_Address_Expediteur'], FILTER_VALIDATE_EMAIL))
				{

					update_option('BaTi_Admin_Event_Mail_Address_Expediteur_'.$Id,$_POST['BaTi_Admin_Event_Mail_Address_Expediteur']);

				}
				else
				{

					$ErrorMail = new WP_Error('Mail','Il faut rentrer une adresse mail avec un format valide.');

					return $ErrorMail;

				}

			}

		}
		else
		{
			
			delete_option('BaTi_Admin_Event_Mail_Address_Expediteur_'.$Id);

		}

	} // END BaTi_UpdateEventOption()

	function BaTi_ImportFiles($NumEvent)
	{
		// Copie les images à l'intérieur du plugin

		$Id = $NumEvent;

		// Défini les extensions valide du fichier
		$EtensionsValides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );

		// Chemin des dossier
		$FolderPictureEvent = substr(plugin_dir_path( __FILE__ ),0,strlen(plugin_dir_path( __FILE__ ))-6).'img\Evenement'.$Id;
		$FolderAttachmentEvent = substr(plugin_dir_path( __FILE__ ),0,strlen(plugin_dir_path( __FILE__ ))-6).'attachment\Evenement'.$Id;

		if (isset($_FILES['BaTi_Admin_Event_Event_Header_Picture']))
		{

			if ($_FILES['BaTi_Admin_Event_Event_Header_Picture']['error'] > 0) 
			{

				if ( $_FILES['BaTi_Admin_Event_Event_Header_Picture']['error'] != 4)
				{

					$ErrorPictureHeader = new WP_Error('Header','Erreur lors du transfert.');

				}

			}
			else 
			{

				if ($_FILES['BaTi_Admin_Event_Event_Header_Picture']['size'] > $_POST['MAX_FILE_SIZE'])
				{

					$ErrorPictureHeader = new WP_Error('Header','Le fichier est trop gros.');
					
				}
				else
				{
					//1. strrchr renvoie l'extension avec le point (« . »).
					//2. substr(chaine,1) ignore le premier caractère de chaine.
					//3. strtolower met l'extension en minuscules.
					$ExtensionPictureHeader = strtolower(  substr(  strrchr($_FILES['BaTi_Admin_Event_Event_Header_Picture']['name'], '.')  ,1)  );

					if ( in_array($ExtensionPictureHeader,$EtensionsValides) ) 
					{

						$Transfert = move_uploaded_file($_FILES['BaTi_Admin_Event_Event_Header_Picture']['tmp_name'],$FolderPictureEvent.'\PictureHeader.'.$ExtensionPictureHeader);

						if ($Transfert)
						{
							
							$ErrorPictureHeader = new WP_Error('Header','Transfert réussi');

						}
					}
					else
					{

						$ErrorPictureHeader = new WP_Error('Header','Le fichier doit avoir une extension de type jpg, png ou gif.');

					}

				}

			}

		}

		if (isset($_FILES['BaTi_Admin_Event_Event_Content_Picture']))
		{

			if ($_FILES['BaTi_Admin_Event_Event_Content_Picture']['error'] > 0) 
			{
				
				if($_FILES['BaTi_Admin_Event_Event_Content_Picture']['error'] != 4)
				{

					$ErrorPictureContent = new WP_Error('Content','Erreur lors du transfert.');

				}	

			}
			else 
			{

				if ($_FILES['BaTi_Admin_Event_Event_Content_Picture']['size'] > $_POST['MAX_FILE_SIZE'])
				{

					$ErrorPictureContent = new WP_Error('Content','Le fichier est trop gros.');
					
				}
				else
				{
					//1. strrchr renvoie l'extension avec le point (« . »).
					//2. substr(chaine,1) ignore le premier caractère de chaine.
					//3. strtolower met l'extension en minuscules.
					$ExtensionPictureContent = strtolower(  substr(  strrchr($_FILES['BaTi_Admin_Event_Event_Content_Picture']['name'], '.')  ,1)  );

					if ( in_array($ExtensionPictureContent,$EtensionsValides) ) 
					{

						$Transfert = move_uploaded_file($_FILES['BaTi_Admin_Event_Event_Content_Picture']['tmp_name'],$FolderPictureEvent.'\PictureContent.'.$ExtensionPictureContent);

						if ($Transfert)
						{
							
							$ErrorPictureContent = new WP_Error('Content','Transfert réussi');

						}
					}
					else
					{

						$ErrorPictureContent = new WP_Error('Content','Le fichier doit avoir une extension de type jpg, png ou gif.');

					}

				}

			}

		}

		if (isset($_FILES['BaTi_Admin_Event_Pages_FirstPage_Picture']))
		{
			
			if ($_FILES['BaTi_Admin_Event_Pages_FirstPage_Picture']['error'] > 0) 
			{
				
				if($_FILES['BaTi_Admin_Event_Pages_FirstPage_Picture']['error'] != 4)
				{

					$ErrorPictureFirstPage = new WP_Error('FirstPage','Erreur lors du transfert.');
				}	

			}
			else 
			{

				if ($_FILES['BaTi_Admin_Event_Pages_FirstPage_Picture']['size'] > $_POST['MAX_FILE_SIZE'])
				{

					$ErrorPictureFirstPage = new WP_Error('FirstPage','Le fichier est trop gros.');

				}
				else
				{
					//1. strrchr renvoie l'extension avec le point (« . »).
					//2. substr(chaine,1) ignore le premier caractère de chaine.
					//3. strtolower met l'extension en minuscules.
					$ExtensionPictureFirstPage = strtolower(  substr(  strrchr($_FILES['BaTi_Admin_Event_Pages_FirstPage_Picture']['name'], '.')  ,1)  );

					if ( in_array($ExtensionPictureFirstPage,$EtensionsValides) ) 
					{

						$Transfert = move_uploaded_file($_FILES['BaTi_Admin_Event_Pages_FirstPage_Picture']['tmp_name'],$FolderPictureEvent.'\PictureFirstPage.'.$ExtensionPictureFirstPage);

						if ($Transfert)
						{

							$ErrorPictureFirstPage = new WP_Error('FirstPage','Transfert réussi');

						}
					}
					else
					{

						$ErrorPictureFirstPage = new WP_Error('FirstPage','Le fichier doit avoir une extension de type jpg, png ou gif.');

					}

				}

			}

		}

		if (isset($_FILES['BaTi_Admin_Event_Pages_Confirmation_Picture']))
		{

			if ($_FILES['BaTi_Admin_Event_Pages_Confirmation_Picture']['error'] > 0) 
			{
				
				if ($_FILES['BaTi_Admin_Event_Pages_Confirmation_Picture']['error'] != 4) 
				{

					$ErrorPictureConfirmation = new WP_Error('Confirmation','Erreur lors du transfert.');

				}	

			}
			else 
			{

				if ($_FILES['BaTi_Admin_Event_Pages_Confirmation_Picture']['size'] > $_POST['MAX_FILE_SIZE'])
				{

					$ErrorPictureConfirmation = new WP_Error('Confirmation','Le fichier est trop gros.');
					
				}
				else
				{
					//1. strrchr renvoie l'extension avec le point (« . »).
					//2. substr(chaine,1) ignore le premier caractère de chaine.
					//3. strtolower met l'extension en minuscules.
					$ExtensionPictureConfirmation = strtolower(  substr(  strrchr($_FILES['BaTi_Admin_Event_Pages_Confirmation_Picture']['name'], '.')  ,1)  );

					if ( in_array($ExtensionPictureConfirmation,$EtensionsValides) ) 
					{

						$Transfert = move_uploaded_file($_FILES['BaTi_Admin_Event_Pages_Confirmation_Picture']['tmp_name'],$FolderPictureEvent.'\PictureConfirmation.'.$ExtensionPictureConfirmation);

						if ($Transfert)
						{
							
							$ErrorPictureConfirmation = new WP_Error('Confirmation','Transfert réussi');

						}
					}
					else
					{

						$ErrorPictureConfirmation = new WP_Error('Confirmation','Le fichier doit avoir une extension de type jpg, png ou gif.');

					}

				}

			}

		}


		if (isset($_FILES['BaTi_Admin_Event_Mail_Attachment_File']))
		{

			if (isset($_POST['BaTi_Admin_Event_Mail_Attachment_Name']))
			{

				if ($_FILES['BaTi_Admin_Event_Mail_Attachment_File']['error'] > 0) 
				{
					
					if ($_FILES['BaTi_Admin_Event_Mail_Attachment_File']['error'] != 4) 
					{
						
						$ErrorAttachment = new WP_Error('Attachment','Erreur lors du transfert.');	

					}

				}
				else 
				{

					if ($_FILES['BaTi_Admin_Event_Mail_Attachment_File']['size'] > $_POST['MAX_FILE_SIZE'])
					{

						$ErrorAttachment = new WP_Error('Attachment','Le fichier est trop gros.');
						
					}
					else
					{
						//1. strrchr renvoie l'extension avec le point (« . »).
						//2. substr(chaine,1) ignore le premier caractère de chaine.
						//3. strtolower met l'extension en minuscules.
						$ExtensionPicturePieceJointe = strtolower(  substr(  strrchr($_FILES['BaTi_Admin_Event_Mail_Attachment_File']['name'], '.')  ,1)  );

						if ($ExtensionPicturePieceJointe == 'pdf') 
						{

							$Transfert = move_uploaded_file($_FILES['BaTi_Admin_Event_Mail_Attachment_File']['tmp_name'],$FolderAttachmentEvent.'\\'.$_POST['BaTi_Admin_Event_Mail_Attachment_Name'].'.'.$ExtensionPicturePieceJointe);

							if ($Transfert)
							{
								
								$ErrorAttachment = new WP_Error('Attachment','Transfert réussi');

							}
						}
						else
						{

							$ErrorAttachment = new WP_Error('Attachment','Le fichier doit avoir une extension de type pdf.');

						}

					}

				}

			}
			else
			{

				$ErrorAttachment = new WP_Error('Attachment','Il faut donner un nom à la pièce-jointe.');

			}

		}

		if(isset($ErrorPictureHeader))
		{

			$Errors['Header'] = $ErrorPictureHeader;

		}
		else
		{

			$Errors['Header'] = '';

		}
		
		if(isset($ErrorPictureContent))
		{

			$Errors['Content'] = $ErrorPictureContent;

		}
		else
		{

			$Errors['Content'] = '';

		}

		if(isset($ErrorPictureFirstPage))
		{

			$Errors['FirstPage'] = $ErrorPictureFirstPage;

		}
		else
		{

			$Errors['FirstPage'] = '';

		}
		
		if(isset($ErrorPictureConfirmation))
		{

			$Errors['Confirmation'] = $ErrorPictureConfirmation;

		}
		else
		{

			$Errors['Confirmation'] = '';

		}

		if(isset($ErrorAttachment))
		{

			$Errors['Attachment'] = $ErrorAttachment;

		}
		else
		{

			$Errors['Attachment'] = '';

		}

		return $Errors;

	} // END BaTi_ImportImages()

	function BaTi_ChoiceEventName($NumEvent)
	{
		// Créé un combobox avec les noms d'événement

		$Id = $NumEvent;

		// Variable de la base de données WordPress
        global $wpdb;

        $EventNames = $wpdb->get_col("SELECT eveNom FROM {$wpdb->prefix}BaTi_tblEvent;");
  
?>

   		<select name="BaTi_Admin_Event_Event_Name">

<?php

        foreach($EventNames as $EventName)
        {

			if (isset($_POST['BaTi_Admin_Event_Event_Name']))
	   		{
	   			
	   			if ($EventName == $_POST['BaTi_Admin_Event_Event_Name'])
	   			{

?>

	   				<option value="<?php echo $EventName; ?>" selected="selected"><?php echo $EventName; ?></option>

<?php
				
				}
				else
				{

?>

	   				<option value="<?php echo $EventName; ?>"><?php echo $EventName; ?></option>

<?php
				
				}

	   		}
	   		else
	   		{

				if ($EventName == get_option('BaTi_Admin_Event_Event_Option_EventName_'.$Id))
	   			{ 


?>

   					<option value="<?php echo $EventName; ?>" selected="selected"><?php echo $EventName; ?></option>

<?php
			
				}
				else
				{

?>

   					<option value="<?php echo $EventName; ?>"><?php echo $EventName; ?></option>

<?php
			
				}

	        }

    	}

?>

        	</select>

<?php

	} // END BaTi_ChoiceEventName()

	function BaTi_ChoiceTypeBillet($NumEvent)
	{
		// Créé un combobox avec les noms de types

		$Id = $NumEvent;

		// Variable de la base de données WordPress
        global $wpdb;

        $TypeBillets = $wpdb->get_col("SELECT tybiNom FROM {$wpdb->prefix}BaTi_tblTypeBillet;");

        foreach($TypeBillets as $TypeBillet)
        {

?>

			<input type="checkbox" name="BaTi_Admin_Event_Event_TypeBillet_Name[]" value="<?php echo $TypeBillet; ?>"> <?php echo $TypeBillet; ?>

<?php

        }
        
	} // END BaTi_ChoiceTypeBillet()

?>