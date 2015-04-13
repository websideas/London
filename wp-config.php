<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'websidea_london');

/** MySQL database username */
define('DB_USER', 'websidea_cuongdv');

/** MySQL database password */
define('DB_PASSWORD', 'admin123');

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
define('AUTH_KEY',         'z1K~c=3Qn^4+iRuw I#`&/+pVJwT{,U#?4b2*{fT)ac|-4q`D6cPQT(kw=kL=MO@');
define('SECURE_AUTH_KEY',  'ADTb8UJXO`^s&V~(C~91Z=^JN:Y+iKf07cX~N^hLsKivp`f&p~8fd|=+CrlL.T1C');
define('LOGGED_IN_KEY',    '$ IK@x_FEz6}Jg4r]?@jwCW+3!|&vD}S}:f;]#~cV-C;4s+ |-E/0q3V()pRSy5-');
define('NONCE_KEY',        '[Wl+$1wO#!5k5k8+^uByIsk@i(m7k$>vHAp29xUz`<;VqL#z1_DczX+n.nP5>k+M');
define('AUTH_SALT',        'Tj _Z2l?#-K.WAlo5qzw)a*]}GXM:|^Uw+yo]-9(2tk:=X!6:MzZe<]@|2tuu[j&');
define('SECURE_AUTH_SALT', 'bADR2~.3F+R_{OJcEfKBQsD--]|viAxhBVE&&y:N/d8NEKN&=FUH[M8%?$8ppE8V');
define('LOGGED_IN_SALT',   'z0j^A;tR_/_|t:6M?1_Q(pBrb9+kmJ=;G?Njht8%0cya!yci`BONTFM[iLE3F@G>');
define('NONCE_SALT',       'aj7}dmFV%I1~1tM(FdyoeyX1Q$zC-VPJma#XF$&d!bJ6$3V#il+,9<.oEHltQxXL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ld_';

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
