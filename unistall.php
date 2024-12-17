<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Custom_WP_Admin_Logo
 */

// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all plugin options
delete_option('cwal_logo_url');
delete_option('cwal_logo_height');
delete_option('cwal_do_activation_redirect');

// Clear any cached data
wp_cache_flush();
