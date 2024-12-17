<?php
/**
 * Fired during plugin deactivation.
 *
 * @package Custom_WP_Admin_Logo
 */

class Custom_WP_Admin_Logo_Deactivator {

    /**
     * Deactivate the plugin.
     */
    public static function deactivate() {
        // Remove temporary data
        delete_option('cwal_do_activation_redirect');

        // Clear any cached data
        wp_cache_flush();
    }
}
