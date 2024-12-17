<?php
/**
 * The core plugin class.
 *
 * @package Custom_WP_Admin_Logo
 */

class Custom_WP_Admin_Logo {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var Custom_WP_Admin_Logo_Loader
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @var string
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @var string
     */
    protected $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        $this->version = CWAL_VERSION;
        $this->plugin_name = 'custom-wp-admin-logo';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_login_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        require_once CWAL_PLUGIN_PATH . 'includes/class-custom-wp-admin-logo-loader.php';
        $this->loader = new Custom_WP_Admin_Logo_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     */
    private function define_admin_hooks() {
        // Add menu item
        $this->loader->add_action('admin_menu', $this, 'add_admin_menu');

        // Register settings
        $this->loader->add_action('admin_init', $this, 'register_settings');

        // Enqueue scripts and styles
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_admin_assets');

        // Add settings link on plugin page
        $this->loader->add_filter('plugin_action_links_' . CWAL_PLUGIN_BASENAME, $this, 'add_settings_link');

        // Handle activation redirect
        $this->loader->add_action('admin_init', $this, 'handle_activation_redirect');

        // Add AJAX handlers
        $this->loader->add_action('wp_ajax_cwal_save_settings', $this, 'handle_ajax_save_settings');
    }

    /**
     * Register all of the hooks related to the login functionality
     */
    private function define_login_hooks() {
        // Customize login logo
        $this->loader->add_action('login_head', $this, 'custom_login_logo');
        
        // Customize login header URL
        $this->loader->add_filter('login_headerurl', $this, 'custom_login_header_url');
        
        // Customize login header title
        $this->loader->add_filter('login_headertext', $this, 'custom_login_header_title');
    }

    /**
     * Handle activation redirect
     */
    public function handle_activation_redirect() {
        if (get_option('cwal_do_activation_redirect', false)) {
            delete_option('cwal_do_activation_redirect');
            if (!isset($_GET['activate-multi'])) {
                wp_safe_redirect(admin_url('options-general.php?page=' . $this->plugin_name));
                exit;
            }
        }
    }

    /**
     * Add settings link to plugin page
     */
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' 
            . __('Settings', 'custom-wp-admin-logo') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * Add options page
     */
    public function add_admin_menu() {
        add_options_page(
            __('Custom WP Admin Logo', 'custom-wp-admin-logo'),
            __('Custom Admin Logo', 'custom-wp-admin-logo'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_admin_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting(
            'cwal_settings',
            'cwal_logo_url',
            array(
                'type' => 'string',
                'sanitize_callback' => 'esc_url_raw',
                'default' => ''
            )
        );

        register_setting(
            'cwal_settings',
            'cwal_logo_height',
            array(
                'type' => 'number',
                'sanitize_callback' => 'absint',
                'default' => 84
            )
        );
    }

    // ... (continued in next part due to length) ...

    /**
     * Enqueue admin assets
     */
    /**
 * Enqueue admin assets
 */
public function enqueue_admin_assets($hook) {
    if ('settings_page_' . $this->plugin_name !== $hook) {
        return;
    }

    // Enqueue WordPress Media Library scripts
    wp_enqueue_media();

    // Enqueue CSS
    wp_enqueue_style(
        $this->plugin_name,
        CWAL_PLUGIN_URL . 'assets/css/admin-style.css',
        array(),
        $this->version
    );

    // Enqueue JavaScript
    wp_enqueue_script(
        $this->plugin_name,
        CWAL_PLUGIN_URL . 'assets/js/admin-script.js',
        array('jquery', 'media-upload'), // Add media-upload dependency
        $this->version,
        true
    );

    // Localize script
    wp_localize_script(
        $this->plugin_name,
        'cwalAdmin',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cwal_nonce'),
            'defaultHeight' => 84,
            'messages' => array(
                'success' => __('Settings saved successfully!', 'custom-wp-admin-logo'),
                'error' => __('Error saving settings.', 'custom-wp-admin-logo'),
                'choose' => __('Choose Image', 'custom-wp-admin-logo'),
                'select' => __('Select Logo', 'custom-wp-admin-logo')
            )
        )
    );
}

    /**
     * Display admin page
     */
    public function display_admin_page() {
        require_once CWAL_PLUGIN_PATH . 'admin/partials/admin-display.php';
    }

    /**
     * Handle AJAX save settings
     */
    public function handle_ajax_save_settings() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cwal_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        // Verify user capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }

        // Sanitize and save logo URL
        $logo_url = isset($_POST['logo_url']) ? esc_url_raw($_POST['logo_url']) : '';
        if (empty($logo_url)) {
            $logo_url = $this->get_default_logo_url();
        }
        update_option('cwal_logo_url', $logo_url);

        // Sanitize and save logo height
        $logo_height = isset($_POST['logo_height']) ? absint($_POST['logo_height']) : 84;
        update_option('cwal_logo_height', $logo_height);

        wp_send_json_success(array(
            'message' => __('Settings saved successfully!', 'custom-wp-admin-logo')
        ));
    }

    /**
     * Get default logo URL
     */
    private function get_default_logo_url() {
        $site_icon_id = get_option('site_icon');
        if ($site_icon_id) {
            $site_icon_url = wp_get_attachment_image_url($site_icon_id, 'full');
            if ($site_icon_url) {
                return $site_icon_url;
            }
        }
        return '';
    }

    /**
     * Customize login logo
     */
    public function custom_login_logo() {
        $logo_url = get_option('cwal_logo_url', $this->get_default_logo_url());
        $logo_height = get_option('cwal_logo_height', 84);

        if (empty($logo_url)) {
            return;
        }

        echo '<style type="text/css">
            .login h1 a {
                background-image: url(' . esc_url($logo_url) . ') !important;
                background-size: contain !important;
                width: 100% !important;
                height: ' . esc_attr($logo_height) . 'px !important;
            }
        </style>';
    }

    /**
     * Customize login header URL
     */
    public function custom_login_header_url() {
        return home_url();
    }

    /**
     * Customize login header title
     */
    public function custom_login_header_title() {
        return get_bloginfo('name');
    }

    /**
     * Run the loader to execute all hooks with WordPress.
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}
