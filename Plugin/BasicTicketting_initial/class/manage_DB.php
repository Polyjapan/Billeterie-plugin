<?php

class BaTi_Install_Plugin
{

    public function __construct()
    {

    } // END __construct()


    // Création des tables
    public static function BaTi_install_DB()
    {
        // Création des tables

        // Variable de la base de données WordPress
        global $wpdb;

        // table client
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblClient (
                    cliId INT NOT NULL AUTO_INCREMENT,
                    cliNom VARCHAR(45) NOT NULL,
                    cliPrenom VARCHAR(45) NOT NULL,
                    cliPassword VARCHAR(60) NOT NULL,
                    cliMail VARCHAR(45) NOT NULL,

                    PRIMARY KEY (cliId),

                    CONSTRAINT UNIQUE Unique_Password (cliPassword)
                ) ENGINE=INNODB DEFAULT CHARSET=utf8;");

        // table type de billets
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblTypeBillet (
                    tybiId INT NOT NULL AUTO_INCREMENT,
                    tybiNom VARCHAR(45) NOT NULL,
                    tybiPrix DOUBLE NOT NULL,

                    PRIMARY KEY (tybiId),

                    CONSTRAINT UNIQUE Unique_Nom (tybiNom)
                ) ENGINE=INNODB DEFAULT CHARSET=utf8;");

        // table événement
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblEvent (
                    eveId INT NOT NULL AUTO_INCREMENT,
                    eveNom VARCHAR(45) NOT NULL,

                    PRIMARY KEY (eveId),

                    CONSTRAINT UNIQUE Unique_Nom (eveNom)
                ) ENGINE=INNODB DEFAULT CHARSET=utf8;");

        // table Commande
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblCommande (
                    comId INT NOT NULL AUTO_INCREMENT,
                    BaTi_tblClient_cliId INT NOT NULL,
                    comDate DATE NOT NULL,
                    comMontantTotal DOUBLE NOT NULL,

                    PRIMARY KEY (comId),

                    KEY BaTi_tblClient_cliId_FK(BaTi_tblClient_cliId)

                ) ENGINE=INNODB DEFAULT CHARSET=utf8;");

        // ajout de la clé étrangère
        $wpdb->query("ALTER TABLE {$wpdb->prefix}bati_tblcommande
                        ADD CONSTRAINT FK_{$wpdb->prefix}bati_tblcommande_{$wpdb->prefix}bati_tblClient FOREIGN KEY (BaTi_tblClient_cliId) REFERENCES {$wpdb->prefix}bati_tblclient (cliId);");
        
        // table billet
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}BaTi_tblBillet (
                    bilId INT NOT NULL AUTO_INCREMENT,
                    BaTi_tblCommande_comId INT NOT NULL,
                    BaTi_tblTypeBillet_tybiId INT NOT NULL,
                    BaTi_tblEvent_eveId INT NOT NULL,
                    bilCodeBarre INT NOT NULL,
                    bilPDF VARCHAR(255),

                    PRIMARY KEY (bilId),

                    KEY BaTi_tblCommande_comId_FK (BaTi_tblCommande_comId),
                    KEY BaTi_tblTypeBillet_tybiId_FK (BaTi_tblTypeBillet_tybiId),
                    KEY BaTi_tblEvent_eveId_FK (BaTi_tblEvent_eveId),

                    CONSTRAINT UNIQUE Unique_CodeBarre (bilCodeBarre)
                ) ENGINE=INNODB DEFAULT CHARSET=utf8;");

        // ajout des clés étrangères
        $wpdb->query("ALTER TABLE {$wpdb->prefix}BaTi_tblBillet
                        ADD CONSTRAINT FK_{$wpdb->prefix}BaTi_tblBillet_{$wpdb->prefix}BaTi_tblCommande FOREIGN KEY (BaTi_tblCommande_comId) REFERENCES {$wpdb->prefix}BaTi_tblCommande (comId);");
        $wpdb->query("ALTER TABLE {$wpdb->prefix}BaTi_tblBillet
                        ADD CONSTRAINT FK_{$wpdb->prefix}BaTi_tblBillet_{$wpdb->prefix}BaTi_tblTypeBillet FOREIGN KEY (BaTi_tblTypeBillet_tybiId) REFERENCES {$wpdb->prefix}BaTi_tblTypeBillet (tybiId);");
        $wpdb->query("ALTER TABLE {$wpdb->prefix}BaTi_tblBillet
                        ADD CONSTRAINT FK_{$wpdb->prefix}BaTi_tblBillet_{$wpdb->prefix}BaTi_tblEvent FOREIGN KEY (BaTi_tblEvent_eveId) REFERENCES {$wpdb->prefix}BaTi_tblEvent (eveId);");
        
    }   // END BaTi_install_DB

    public static function BaTi_uninstall_DB()
    {
        // Supprime les tables et les options

        // Variable de la base de données WordPress
        global $wpdb;

        // Suppression de tables
        $wpdb->query("DELETE {$wpdb->prefix}BaTi_tblBillet;");
        $wpdb->query("DELETE {$wpdb->prefix}BaTi_tblCommande;");
        $wpdb->query("DELETE {$wpdb->prefix}BaTi_tblEvent;");
        $wpdb->query("DELETE {$wpdb->prefix}BaTi_tblTypeBillet;");
        $wpdb->query("DELETE {$wpdb->prefix}BaTi_tblClient;");
        
        $Options = $wpdb->get_col("SELECT option_name FROM {$wpdb->prefix}options WHERE option_name LIKE 'BaTi_%';");

        foreach ($Options as $Option) {
            
            delete_option($Option);

        }
        
    }   // END BaTi_uninstall_DB

} // END class BaTi_Install_Plugin

?>