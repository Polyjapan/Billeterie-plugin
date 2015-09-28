<?php


/**
*	The class used for the installation and desinstallation of the db
*
*/
class BaTi_Install_Plugin
{

    public function __construct()
    {

    } // END __construct()


    // Creation of the table
    public static function BaTi_install_DB()
    {
		// db variable
		global $wpdb;
		// charset
		$charset_collate = $wpdb->get_charset_collate();
		
		//This table will contain the informations about the client when he will buy a ticket
		if($wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblClient (
                    PKClient INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    cliNom VARCHAR(45) NOT NULL,
                    cliPrenom VARCHAR(45) NOT NULL,
                    cliPassword VARCHAR(60) NOT NULL,
                    cliMail VARCHAR(45) NOT NULL,

                    CONSTRAINT UNIQUE Unique_Password (cliMail)
                ) $charset_collate;") === false)
		{
			trigger_error("DB ERROR : error when creating table client",E_ERROR);
		}
		// This table will hold the different types of a tickets ( 1 or 2 days and so on )
		if($wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblTypeBillet (
                    PKTypeBillet INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    tybiNom VARCHAR(45) NOT NULL,
                    tybiPrix DOUBLE NOT NULL,
					tybiDescription LONGTEXT,
					

                    CONSTRAINT UNIQUE Unique_Nom (tybiNom)
                ) $charset_collate;") === false)
		{
			trigger_error("DB ERROR : error when creating table TypeBillet",E_ERROR);
		}
		// Holds the name of the event
		if($wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblEvent (
                    PKEvent INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    eveNom VARCHAR(45) NOT NULL,


                    CONSTRAINT UNIQUE Unique_Nom (eveNom)
                ) $charset_collate;") === false)
		{
			trigger_error("DB ERROR : error when creating table Event",E_ERROR);
		}
		// Holds the origin of the tickets
		if($wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblOrigine (
                    PKOrigine INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    oriNom VARCHAR(45) NOT NULL,

                    CONSTRAINT UNIQUE Unique_Nom (oriNom)
                ) $charset_collate;") === false)
		{
			trigger_error("DB ERROR : error when creating table Origine",E_ERROR);
		}
		// Holds all the transaction of the client
		if($wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblCommande (
                    PKCommande INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    FKClient INT NOT NULL,
                    comDate DATE NOT NULL,
                    comMontantTotal DOUBLE NOT NULL,
					comValidate BOOLEAN NOT NULL,
					CONSTRAINT FK_Commande_Client FOREIGN KEY (FKClient)
					REFERENCES {$wpdb->prefix}BaTi_tblClient(PKClient)
                )  $charset_collate;") === false)
		{
			trigger_error("DB ERROR : error when creating table Commande",E_ERROR);
		}
		

		// 	The successful generated tickets
		if($wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblBillet (
                    PKBillet INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    FKCommande INT NOT NULL,
                    FKTypeBillet INT NOT NULL,
                    FKEvent INT NOT NULL,
					FKOrigine INT NOT NULL,
                    bilCodeBarre INT NOT NULL,
                    bilEnterDate DATETIME,
                    CONSTRAINT UNIQUE Unique_CodeBarre (bilCodeBarre),
					CONSTRAINT FK_Billet_Commande FOREIGN KEY (FKCommande)
					REFERENCES {$wpdb->prefix}BaTi_tblCommande(PKCommande),
					CONSTRAINT FK_BILLET_TYPEBILLET FOREIGN KEY (FKTypeBillet)
					REFERENCES {$wpdb->prefix}BaTi_tblTypeBillet(PKTypeBillet),
					CONSTRAINT FK_BILLET_Event FOREIGN KEY (FKEvent)
					REFERENCES {$wpdb->prefix}BaTi_tblEvent(PKEvent),
					CONSTRAINT FK_BILLET_Origine FOREIGN KEY (FKOrigine)
					REFERENCES {$wpdb->prefix}BaTi_tblOrigine(PKOrigine)
                ) $charset_collate;") === false)
		{
			trigger_error("DB ERROR : error when creating table Billet",E_ERROR);
		}
		
        
    }   // END BaTi_install_DB
	

	

    public static function BaTi_uninstall_DB()
    {
        // Supprime les tables et les options

        // Variable de la base de données WordPress
        global $wpdb;

        // Suppression de tables
        $wpdb->query("DROP TABLE {$wpdb->prefix}BaTi_tblBillet;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}BaTi_tblCommande;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}BaTi_tblEvent;");
		$wpdb->query("DROP TABLE {$wpdb->prefix}BaTi_tblOrigine;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}BaTi_tblTypeBillet;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}BaTi_tblClient;");
        
        $Options = $wpdb->get_col("SELECT option_name FROM {$wpdb->prefix}options WHERE option_name LIKE 'BaTi_%';");

        foreach ($Options as $Option) {
            
            delete_option($Option);

        }
        
    }   // END BaTi_uninstall_DB

} // END class BaTi_Install_Plugin