<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'dbJapanImpact');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'illidan56');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         's~Yy%n_?F(oTkXPik>LRH1.QD}X^+%YZ2o5)&Dim$lxI}Es*IHU8Og{2^C@0GgC2');
define('SECURE_AUTH_KEY',  '9WHO2BY]-jYH!- bpoaJg|yJCN!mi-iZa_:Fk}[R+V{T+}Q@BYDTv+ N?[K1I:!f');
define('LOGGED_IN_KEY',    '3xOwo3^f8yg$,}q1-k+($y5zM?tTya/XX>85x08cC=PM$:-QB98W,|e`BY?5#7-k');
define('NONCE_KEY',        'ynL$ y;P+PGCO$lkS%6&A-8c|jm9.UuN=0N&Q/?*A|$|16H~HyC(K.%%z.-Ky_QJ');
define('AUTH_SALT',        '.Ue-v&yPAjp55*1V04M&S5V;Nvy)t8T<iJpoxv(>t|dcQ7l<12dBhGhWR>,?AqAY');
define('SECURE_AUTH_SALT', '/RRxjcB7lWCmWHHc.W+V`{zdtBo 4*15ol0?t(xhN+e-Ykch(#]sE-&AH%@R`>gn');
define('LOGGED_IN_SALT',   '.hx$ZM9F}I)M~O.brg&<}p| 9>m)ab]0mJZUf2XGUb,3>i%(Sop^nvk{#@A+Ouib');
define('NONCE_SALT',       '}7{0_% ]Ib+5e{|v:61caHf~$|I<d4QtcA2)G_Vf c:E;:*Bdg-&jhS|xR,wXu-F');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'JI_';

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
 // Enable WP_DEBUG mode
define('WP_DEBUG', true);

// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

// Disable display of errors and warnings 
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors',0);

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define('SCRIPT_DEBUG', true);
/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');