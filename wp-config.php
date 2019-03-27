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

define('HOSTNAME_LOCAL', 'dev.usply.net');
define('HOSTNAME_DEV', 'dev.usply.net.php72-37.lan3-1.websitetestlink.com/');
define('HOSTNAME_LIVE', 'www.usply.com');

function is_local() {
	return $_SERVER['HTTP_HOST'] == HOSTNAME_LOCAL;
}

function is_dev() {
	return $_SERVER['HTTP_HOST'] == HOSTNAME_DEV;
}

function is_live() {
	return $_SERVER['HTTP_HOST'] == HOSTNAME_LIVE;
}

define('WP_MEMORY_LIMIT', '64M');

$hostname = null;
$database = null;
$username = null;
$password = null;
$protocol = 'http';

if(in_array($_SERVER['HTTP_HOST'], [HOSTNAME_LOCAL, HOSTNAME_DEV])) {
	$hostname = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? '207.246.248.12' : 'mariadb-002.wc1.lan3.stabletransit.com';
	$database = '2021327_usplydev';
	$username = '2021327_usplydev';
	$password = '7kQmoV129zZ8';
}
elseif(in_array($_SERVER['HTTP_HOST'], [HOSTNAME_LIVE])) {
	$hostname = 'localhost';
	$database = '';
	$username = '';
	$password = '';
	$protocol = 'https';
	define('FORCE_SSL_ADMIN', true);
}

define('DB_NAME', $database);
define('DB_USER', $username);
define('DB_PASSWORD', $password);
define('DB_HOST', $hostname);
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
define('WP_SITEURL', $protocol.'://'.$_SERVER['HTTP_HOST']);
define('WP_HOME', $protocol.'://'.$_SERVER['HTTP_HOST']);
define('DISALLOW_FILE_EDIT', true);
define('WP_AUTO_UPDATE_CORE', false);

session_start();

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '8zItPbz7e87bKyO7(&5,JSDGV`1Yn4-;q+h~S#`I/lp~LAm-ff!%cU+Zv>4Nq?B.');
define('SECURE_AUTH_KEY',  '>E*fyx|iyxJ^NRA4.Mh=+T%YkFja%e|}-eo-2*S-<7GWm$sZ[jGgyF7KDO?!u^T!');
define('LOGGED_IN_KEY',    'Tc~niAVu&_f:J,yJX$NIej=y+(pdB<8pKwe72qV-J;2^6%/n<+y&p0z8D@]G @`(');
define('NONCE_KEY',        'YnV<vYY5lq}?P7EdvwvV-DMAm2&Fp>DyQ5pkFO-|-C:V,Q8 <eB<EOr3_XvyCJjs');
define('AUTH_SALT',        'rvz4k3kToymDB|-CloZ>v,3x;,ZI(&VIu`W2C$^e:X;Z|tn^|+|+|YL]aB)-;@Aw');
define('SECURE_AUTH_SALT', '|&b-dnVIQms}}(Kc!-q+I+`BHrvlwOFZ|0Web[Q`6+r`_i1k{6=1U5oJF.$Y@1YZ');
define('LOGGED_IN_SALT',   'C|S^,sS:/.Y{Mq=A_If|jm{3[ @)[sSv,WZVYn:/&7!|0G@,Z.P3z%8HYM*6=.>*');
define('NONCE_SALT',       'yrOPh-od1GPC4^,.s/|+NAl-6F-dQwE5i4)GL[Nkjnys%Tn}LatOk%aL*k/=A8L*');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ply_';

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
define('WP_DEBUG', isset($_GET['debug']));

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
