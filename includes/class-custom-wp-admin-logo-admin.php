<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    CustomWPAdminLogo
 * @author     Afzal Hameed
 */

class Custom_WP_Admin_Logo_Admin {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function init() {
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_filter('plugin_action_links_' . CWAL_PLUGIN_BASENAME, array($this, 'add_action_links'));
    }

    /**
     * Register the administration menu for this plugin.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {
        add_options_page(
            __('Custom WP Admin Logo', 'custom-wp-admin-logo'),
            __('Admin Logo', 'custom-wp-admin-logo'),
            'manage_options',
            'custom-wp-admin-logo',
            array($this, 'display_plugin_admin_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links($links) {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=custom-wp-admin-logo') . '">' . __('Settings', 'custom-wp-admin-logo') . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page() {
        include_once CWAL_PLUGIN_DIR . 'admin/partials/admin-display.php';
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_admin_assets($hook) {
        if ('settings_page_custom-wp-admin-logo' !== $hook) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_style('cwal-admin', CWAL_PLUGIN_URL . 'assets/css/admin-style.css', array(), CWAL_VERSION);
        wp_enqueue_script('cwal-admin', CWAL_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), CWAL_VERSION, true);
    }
}
