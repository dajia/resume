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
define('DB_NAME', 'resume');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '^d1wY#k[a3(=s6FIthC022|k7~pGcf}g]eNtv^>z.1+>x@9;5<Y6r-y(>yM4EXj~');
define('SECURE_AUTH_KEY',  'Lh|MPDh=*<J:0zl(b>G[[GpsYS;oAc}c[wxcoV`` ZH*?CZ~vtD)2+++jntN u@o');
define('LOGGED_IN_KEY',    'H%^~mm5U8(:k9G)9uaM&+;XWnLr={q1c2^d$r{ |OPP*q>;zZFb(LgEfu_6zy? 3');
define('NONCE_KEY',        'IisQje/6CK}?N<TPG/H%.ZW$n|z83y&L fM1|d;St|b-V`Oya t_NzSJ^mn0nsku');
define('AUTH_SALT',        '!bMn<rS%*!p:Lre;RT)bY.79N~9V%0*: gVglmE?7~battb/gd;~>Y Tpta`cyag');
define('SECURE_AUTH_SALT', 'Rq:S^aFEO& nu/s+}l_m*^].~9rP) >9}z*:N}oQRh@TQ|4paEdTpa1~&^=t-]LM');
define('LOGGED_IN_SALT',   'Lons:]v+AqTJz|yE|Zo HpVfyP(@>MeYbKCQ>8+n;:P^{#|9aN2pcRZ33(7EhE]=');
define('NONCE_SALT',       'zr,:udRj]i0{(aVY$@wU#vC`A-u~wn3|df<`9LT)[yf%H|:#-&)Zr5-SVD5Redd~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
