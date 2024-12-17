<?php
/**
 * Plugin Name: Custom WP Admin Logo
 * Plugin URI: https://sparqitservices.com/wordpress-plugins/custom-wp-admin-logo
 * Description: Customize your WordPress admin login logo easily.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Afzal Hameed
 * Author URI: https://sparqitservices.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-wp-admin-logo
 * Domain Path: /languages
 *
 * @package Custom_WP_Admin_Logo
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin version
define('CWAL_VERSION', '1.0.0');

// Plugin path
define('CWAL_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Plugin URL
define('CWAL_PLUGIN_URL', plugin_dir_url(__FILE__));

// Plugin basename
define('CWAL_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Plugin main file
define('CWAL_PLUGIN_FILE', __FILE__);

/**
 * The code that runs during plugin activation.
 */
function activate_custom_wp_admin_logo() {
    require_once CWAL_PLUGIN_PATH . 'includes/class-custom-wp-admin-logo-activator.php';
    Custom_WP_Admin_Logo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_custom_wp_admin_logo() {
    require_once CWAL_PLUGIN_PATH . 'includes/class-custom-wp-admin-logo-deactivator.php';
    Custom_WP_Admin_Logo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_custom_wp_admin_logo');
register_deactivation_hook(__FILE__, 'deactivate_custom_wp_admin_logo');

// Require the core plugin class
require_once CWAL_PLUGIN_PATH . 'includes/class-custom-wp-admin-logo.php';

/**
 * Begins execution of the plugin.
 */
function run_custom_wp_admin_logo() {
    $plugin = new Custom_WP_Admin_Logo();
    $plugin->run();
}

// Start the plugin
run_custom_wp_admin_logo();
