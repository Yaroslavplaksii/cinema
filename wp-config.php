<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'cinema');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         ' :0k_nz0ZNPvU.-3h`4+kqBXM::^1@+V^j)T?IzyU~_mq/7EpS`^^E>T1RB/ZED6');
define('SECURE_AUTH_KEY',  '#jj.*OFUH)7 }=#D-S*[X#iF]#<A2Gj1wlxzHydfVg (AUUfjUT;!yw<?}rdW)?X');
define('LOGGED_IN_KEY',    ' tsY?t`OuE<J]dKJNOZc[N|s}dvV.))5_n,;n7mha5-y1X8tvxrsz dii=5&`a>z');
define('NONCE_KEY',        'HI7S1l.9bY%X27|&:@s+4L6ZzUz%C`)7dw>yT.ka|</vQdEQ@!}8a,}$hMJ.?) _');
define('AUTH_SALT',        ';8|1[%5<Dp>_@A6_p^q(+UBE&jbE{B}IohW#PQ07nAiOsI,6VngV*H(wt^cG ~qa');
define('SECURE_AUTH_SALT', '?Pj4O(W:a*/BK^+f_87CJYby|sTpw!H;KN69tY#xt?_wGx $4vT]Qk2YYsMhS<A]');
define('LOGGED_IN_SALT',   'Kd[lYckioYU%%H>VAV(k!;-;*wMZ?mG=x`fY2Eq{Dj)J7J*CybgP3LUgI9M7< Ro');
define('NONCE_SALT',       '`zC;fvW{VB]r 3FsZ]t~$?WS2VS(+ENX|t|XHiJO|4[$&sG*mS`TXAG]mNL$UP|f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ktik_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
