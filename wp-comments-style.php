<?php

/**
 * Plugin Name:  WP Comments Style
 * Description:  This plugins help you change the look of wordpress comments
 * Plugin URI:   https://github.com/nathanrodrigues2111/wp-nathan-react
 * Author:       Nathan Rodrigues
 * Version:      1.0
 * License:      GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:   https://github.com/nathanrodrigues2111/wp-nathan-react
 * Text Domain:  wp-comments-style
 * Domain Path:  /languages
*/

/**
* Exit if file called directly
*/
if (! defined('ABSPATH')) {
    exit;
}

define('WPNAT_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('WPNAT_MAIN_FILE', __FILE__);
define('WPNAT_URL', trailingslashit(plugins_url('/', __FILE__)));
define('WPNAT_TETXDOMAIN', 'wp-comments-style');
define('WPNAT_PLUGIN_NAME', 'WP Comments Style');

/**
* Public functions
*/

if (! class_exists('WpnatPublicFunctions')) {
    include_once WPNAT_PATH . 'assets/classes/class-public-functions.php';
}

/**
* Admin functions
*/

if (! class_exists('WpnatAdminFunctions')) {
    include_once WPNAT_PATH . 'admin/classes/class-admin-functions.php';
}
