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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'amarhospital');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '94M3x>DiY=%q])F:bka#APVAQw!o!Z?JSTm()6FMK=J+&~]r+r]w+/dnlW[W]&I;');
define('SECURE_AUTH_KEY', '4e+g{I=l}?w0Rv1Ldl+-b%7`,U:i2)Q{_UP%N1kHg$qt`fbp7O827!dQ[LeF04UN');
define('LOGGED_IN_KEY', 'L3s%Nbx{vKE?:prihi;xZ]iD0cna>MZwplm~G|[~W<MDomSM+3en!b0WJ22K`/>h');
define('NONCE_KEY', ' BL,1b5o4`IAJ?L(0E..wU$D*.~F70v[>9lK=;GpGxnT(->F?,>shi~wh.Yl,@Dc');
define('AUTH_SALT', 'U*Eu/)FC8$R_M6)J#9DTEFVh{Z*z8}Q;Siv=vbX`O0.OoiQ&qcl*kkt!Nm?Dl&3t');
define('SECURE_AUTH_SALT', ' m+{C@,>5cGt:2we[=8*WDp&)fN,<uTBkgtF#D=kV+|4D]GK//s]>2y(_equoL6M');
define('LOGGED_IN_SALT', '#m)++hav=J6/uJga(y_4LBU65mj(chC3oIM5}B%O4iK?s%wTww.d,iGV[#c[o.Mi');
define('NONCE_SALT', 'VWh*jKb Q3YMFIhj#1b SrnZMY [b[yjJkF zLuUQ0}OY>01E6$9PV%i:LE$yr?^');
define('WP_CACHE_KEY_SALT', 'J~sKgYx7eaJATR7D|>`Ml+R-;[8q22Z.Ow?Jf^`.sXS`cEbY/eM)/6^&M%~4VZpo');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define('WP_DEBUG', true);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
