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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'YGkDppIW4EOaJoQ1j0Lu/+5j+mwKD3i6YMQyHQaDGSKyiUI18pMp4bHcWdZHDsJz9RdnN8RCCQ2UTeu+qUbZew==');
define('SECURE_AUTH_KEY',  'wQe7yS6F75EZwgWK9zTMI437HCqzGBZ+nMocSDWJb/zfGnLhiKdf2k6hGPP8vtSpqd2aH+u486eJTu8oPWUNiA==');
define('LOGGED_IN_KEY',    'Tv0XXCSNYxMLA2vHqRC0F2sjl3EKed/00QNNsZrP8U0NDEshEK/++K0rQHSmLp2sANV629X1u5i6lywNzUUr2Q==');
define('NONCE_KEY',        'cbydvZEo7Qv/r9le9r/Ns+9WbzRC7m6tpHsCydTSjSVC7qjyBNzTGjlT8MqnR0AWG60xrzj6pb/En5oFslNunw==');
define('AUTH_SALT',        'h9bn9MELYxSNp8hd9Nj90XP1kTIl22xFC3PbTvaA+soMdXc+H4fNYsF7f/r5dyJVR8KfjLNOQSXacF2B5TVZow==');
define('SECURE_AUTH_SALT', 'NLJHueR9rZDhq9CkLhJ8FP4uJMdbeNy30S8ERyVsYSYRlh61HZfOKWsr5Xg27MdoGtXqPlkea2a04ab/If24jw==');
define('LOGGED_IN_SALT',   'a4WWc6MYQbCNtM8SpS6rom0js8c8U4IyOe+LEuV2PNkQR99fqgE9sUU4bBXwNGutoNytq+wEaSyj6SGGxoIrBA==');
define('NONCE_SALT',       '2QCI5rNVMOHfCZYUUWMSAypjmwsRDbvl4hhvW1ncQDCulvkDbluzT/Oj1t7kPAp9r8oJM66V41Y0LvhEnUSjdA==');

// custom env variable
define('ERP_SITE_URL', 'http://localhost:3000');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
