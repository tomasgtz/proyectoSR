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
define('DB_NAME', 'i2958563_wp1');

/** MySQL database username */
define('DB_USER', 'i2958563_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'L*4Lc24*2jLnoDyj1H]24.&3');

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
define('AUTH_KEY',         'KN53zmqxaECsAqxrEIFoPKjsh6wJDQ4qVxrb0aWUj5agmZFuFgKdD34DBfMq7kTf');
define('SECURE_AUTH_KEY',  '1yyrAALAl0vHK5iibMzXW1F6RyacBNnVjS1KQgmyAo9MZOkbk6maiiGPNQoEIWDz');
define('LOGGED_IN_KEY',    'd1fEjXgrMxqOISBshUHprFgQeiJ1vSOLmdh9zoOOmynWqTAAM3lfj7XFhtcvledh');
define('NONCE_KEY',        'wIR47jlO3hbjPjRYQHuRzvtLGvN73dMnFLKzTGhwea32xFu6KAeO6BY87GXoEYjq');
define('AUTH_SALT',        'IfNdkFp2jMda6ZLQPd8UWkk01qi9b3gATHcRHeXUQlIbbCLlcM34Gcg53SnCjMt5');
define('SECURE_AUTH_SALT', 'C9g1WemDikoN269AtbnmoWK3doh3vM9UrjxpQhlcY71Pibx9cM9H6f8HG4HoHZkv');
define('LOGGED_IN_SALT',   'koJkrIPTbNRabljDlE3vkIKDw1LRdgSlUdzRbwJqMB6lb0iY3h30t8RMMzyDAJwg');
define('NONCE_SALT',       'i9T2DqSiZlFgd6FbmQIi05IaxoNPaIHsvBlHEnA8Z7i2dHAU12em5TOdVhFU1xV0');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
