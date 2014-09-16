<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bask_blog');

/** MySQL database username */
define('DB_USER', 'bask_blog');

/** MySQL database password */
define('DB_PASSWORD', 'Ahmichai4');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'o|hZZtB0lVv|5/HHFg}ytzA`(qWe-p*zm0;X?|rznd!aD^O8j_8*(ggKs]G9)bM4');
define('SECURE_AUTH_KEY',  '/DpE k:SsKN</&#J`vLIP3LHu|~hjNc ZOMN6ND)L{qURA!PQ:cw<1akS@xw~,%K');
define('LOGGED_IN_KEY',    'DCp{>-xVD6tvAsF.ds8V%dGT:rezf||[I|%R(}bcG}XF=b[!Utg85E+Oqm7|amz&');
define('NONCE_KEY',        'lccP+}3yY$ecLtV[Jra[D|t.f`;@}^cUqNlU~jKYv13/dr+9_!$vdAtM9}kG/,X=');
define('AUTH_SALT',        'JLGWv4xV:S)Ts*b&v4k.U`=xNbTyU}ayzW+x~dAI6G;lG|]E2GWJ|FM(/x}F=_Ez');
define('SECURE_AUTH_SALT', 'I+vd8ZX/3gshn~A!tM+>8*.6H$cpt>c)ga*h}}y>>x@*_BwihT>IW)8ik[?~,-C-');
define('LOGGED_IN_SALT',   'G1AYaQB UR#ET9<L/vx&--Sq~>`6J8 0veUd?x ?i-7B/LoICYI)Q^a#-^T!jwx<');
define('NONCE_SALT',       'B/sE N]V#c6e5SDc8 zxmA$#x>E>h`U;~HsQw.b7$fJ/Yo^BU@ZYyxl0>4$|!=+t');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
