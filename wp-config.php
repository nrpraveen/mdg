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
define( 'DB_NAME', 'mdg' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'wqhkEsK-,ne0,mD5]L3@x~4c`V!8CG@f1[W1K&4cxO,|z%u2TNiC>&>&m=-$Px+Z' );
define( 'SECURE_AUTH_KEY',  'j~|{#e$v&H-=-BIgV%Lzu6RRZUZf]iYl:s6UtQzSnql)_@fqxcL`eBELl 6kR;F+' );
define( 'LOGGED_IN_KEY',    'Rz6|_>!1,pyMQwr/vFx|fu+Th:AB+/4.Y=`Ag&*pk5y(v+V-?83s5$K=.+<<-#07' );
define( 'NONCE_KEY',        '%,EF|LB|3Ouy8]4XE_>;``u1prdL3+XJ:2kRQ[/`rW3=Mtgf{6Mf}yI$X[H+G7&%' );
define( 'AUTH_SALT',        'u.0s^At@:JGaqm3YV -Y}2NLy?XLDd-yQa1aad[S+dC8j%#|/@yLFsDq 2a;FMN9' );
define( 'SECURE_AUTH_SALT', 'DF+r{P>luXGe-0(TUzEGjkSPKHw&[8AisAL-&*S,S2V_KR;I.P@H;@j3G7+9/SVG' );
define( 'LOGGED_IN_SALT',   '6k:p_|[+|I=}Xeyl)kY=o-X$J+BHDEuF7e3OB=jToz}M#8[6W0kPw]Wp9S#%(F.H' );
define( 'NONCE_SALT',       '?d$VG7BFZO0Q|(`)Qy+E!pR6#KR)TPs-FRn{p2V,B@B&Z0r)n)EC}y.6%TFsII{}' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
