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
define('DB_NAME', 'wrd_1ek4oc7ld1');

/** MySQL database username */
define('DB_USER', 'wrdSrkdu99s');

/** MySQL database password */
define('DB_PASSWORD', '3uVxrR313s');

/** MySQL hostname */
define('DB_HOST', 'floripaparaleigoscom.fatcowmysql.com');

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
define('AUTH_KEY',         'h0JVOMQCsbt0BNnvuxqaHuFL0lXiEQR4wppPGeX5xklIG6NBPdnJPYlcJFJhBVmw');
define('SECURE_AUTH_KEY',  '049yE20j9uF9NzJGZHNNRLUjQBso3uTMjUw9sn0yILHRV6RCOFM5vXbqDbsfsECm');
define('LOGGED_IN_KEY',    'KQPaVa19JYAWR4SNugtyNLOHU346OMtihPEttVk3kFYyTR8fohDdtYX4W48rRhYl');
define('NONCE_KEY',        '0m4YILy7HPpSDDwTmVqjySwg5hrgTiAwsp09MEOe9IKszN4niRxlDFHbtyE2RIW3');
define('AUTH_SALT',        'jk5mttNNqYbOrXN0g00zJeXOJ2zk10vF10yTy2KL5pse2kQp1JV9GbiHKownfmKR');
define('SECURE_AUTH_SALT', 'VrY7LJHpRWufeeBn3UAvBGvK1HKKeO8HUvfrUCh0HuHv3CIFsRWlNcqno4DamBQh');
define('LOGGED_IN_SALT',   '21OxgG9UpGzglPjdBAlBKT0nGygOchO6wZMQ6lVHBNLU2x5MBqk8z2PUIDOvdMnq');
define('NONCE_SALT',       '283GrwE5xx9cAf8Xr3dnQJ5vxlSnmTbkX19YTsAQimeWfv7ZOQTRW6iWoczobOj3');

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

define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'www.wearelosbastardos.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
