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
define( 'DB_NAME', 'performance_performance2' );

/** MySQL database username */
define( 'DB_USER', 'performance_performance2' );

/** MySQL database password */
define( 'DB_PASSWORD', 'performance2' );

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
define( 'AUTH_KEY',          'uvmg-:n0F&# ]H,xFsM5$/zSFKC9Ejq7-Yf;{jGLJ;]N&oY-{)G-bIW])yFP_cP:' );
define( 'SECURE_AUTH_KEY',   'GznublOq?gLFiZwG,;- 5*N-N|KX/:?:,_dry%Y?$?mIho7.uQm# ux}TF< %C^2' );
define( 'LOGGED_IN_KEY',     '=O.OShC*iLR~f2iY(u6{-K2Ye-=A|p8gm7ir,_A6X3sNFD9/gB9uqZa5g?m|S=;x' );
define( 'NONCE_KEY',         '._-8?sl4Q!m}Z*;]lT<aZ_m81|rlr^Pp#(N50 ]>aa[=%N_/6VsJ/1hIJ`^&T90t' );
define( 'AUTH_SALT',         'j5CnQ,+PrBQ%g2<%/CZ+}[}V&0@?2R7>BQyLQVv[6h;O#:!M[YmZtEhYC3*? u}.' );
define( 'SECURE_AUTH_SALT',  'b:DkeNa_QMp/Z;q*JNs[-(,u3n9Cd_e{Dva9L`oZEUfl*){pr>t4qWgAlOD``Q{@' );
define( 'LOGGED_IN_SALT',    'ArSg/}^lK]0+YTN&1S2=lOP=Ox@BH{*$5>/tY;{T#q~q#~2>z^nR>vJZGzG3f/e:' );
define( 'NONCE_SALT',        'xRxTWVzT+&;#x2r/1nhm!*4*|:1[kz_s-`Zz=SCP2u+_7U:S,9NE%wc1}</l6s=}' );
define( 'WP_CACHE_KEY_SALT', '&h3,n ^]Q4D4VT%:rt>-+N>#9gmb2TF|^NZR2Zvz*Ki<AlfC<`x|RC|F]x:+S`-6' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
