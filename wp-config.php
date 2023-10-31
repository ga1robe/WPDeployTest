<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //

if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'local' );
	/** Database username */
	define( 'DB_USER', 'root' );
	/** Database password */
	define( 'DB_PASSWORD', 'root' );
	/** Database hostname */
	define( 'DB_HOST', 'localhost' );
} else {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'gajewska_graphics_training' );
	/** Database username */
	define( 'DB_USER', 'gajewska_graphics_admin' );
	/** Database password */
	define( 'DB_PASSWORD', 'L643-FS-UXDlXnyL' );
	/** Database hostname */
	define( 'DB_HOST', '127.0.0.1' );
}

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}


define('AUTH_KEY',         'QiileRwpU8sNNLLkMxO3NWOjyYRvz85RTQ/HNckBkIoto1jWTD/UdtvMyRBTddnDIXKY9qYRnmRgpbHOCenBIw==');
define('SECURE_AUTH_KEY',  '1gUdbbfdRhoQNLsNTAOHZarGZBCXoYFo/62Bv0l7uGSQpDSoW+o5nwGj93/f1rKufQBV9V47UVxE0g4D7Dr8nw==');
define('LOGGED_IN_KEY',    'rHdfBNHfJUWAh7OFJmBrope/kzRWhnZJYa7FVWGKfli/gOEElnBUN3GqiEen0OWVocvmZHohqB2s+iZaJjDqUg==');
define('NONCE_KEY',        'SjRt4QFigob0qnDXkcT9bMIzvo2Iw8GTHPi9lEAMgv0VrTsh03ekf30KKXaxjf8J6oLQwAvV40pm8XJOHSYfUw==');
define('AUTH_SALT',        'Yd+zMxZtcQrjUAKdWWlfzcRcWo0HvW9wB/2+UXhxmL5cDDRTZ2pHl1M8uOnRjulsaoIUP59AyZbdxWOKCOAo2A==');
define('SECURE_AUTH_SALT', 'iC5JiZgwAJY9G6N03NAYTIoROGSokcLyXSJIXY9GekAtP3Tv4gqUTAgDHVhNyjeau6knDQFziLZQbgYJ0HuIRg==');
define('LOGGED_IN_SALT',   'WG4hFXQ7W/xSXmkWaFoKqGm1TxnwUvh7VeKL50Tf+sm9IOJ+bg8AjRqKMZPmzaHPbkcNck3HErLxash7ukiNmA==');
define('NONCE_SALT',       '5dpJtWBXgOJcDk51IjGszmldmda623mtxDQ3V0iitGHElkuwhBKc1CCzlO9DBFHABSiyymvAiBcz95U3aaSjlQ==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
