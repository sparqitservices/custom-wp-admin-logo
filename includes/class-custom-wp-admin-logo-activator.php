<?php
/**
 * Fired during plugin activation.
 *
 * @package Custom_WP_Admin_Logo
 */

class Custom_WP_Admin_Logo_Activator {

    /**
     * Activate the plugin.
     */
    public static function activate() {
        // Set default options if they don't exist
        if (!get_option('cwal_logo_height')) {
            add_option('cwal_logo_height', 84);
        }

        // Set activation redirect flag
        add_option('cwal_do_activation_redirect', true);

        // Clear any cached data
        wp_cache_flush();
    }
}
