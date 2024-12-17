<?php
/**
 * Admin area display template
 *
 * @package Custom_WP_Admin_Logo
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="cwal-admin-container">
        <!-- Main Content Section -->
        <div class="cwal-admin-main">
            <form id="cwal-settings-form" action="options.php" method="post">
                <?php
                $logo_url = get_option('cwal_logo_url', '');
                $logo_height = get_option('cwal_logo_height', 84);
                ?>

                <div class="cwal-form-group">
                    <label for="logo-url"><?php _e('Logo URL', 'custom-wp-admin-logo'); ?></label>
                    <div class="cwal-input-group">
                        <input type="text" id="logo-url" name="logo_url" 
                               value="<?php echo esc_url($logo_url); ?>" 
                               class="regular-text">
                        <button type="button" class="button" id="upload-logo-btn">
                            <?php _e('Choose Image', 'custom-wp-admin-logo'); ?>
                        </button>
                    </div>
                </div>

                <div class="cwal-form-group">
                    <label for="logo-height"><?php _e('Logo Height (px)', 'custom-wp-admin-logo'); ?></label>
                    <input type="number" id="logo-height" name="logo_height" 
                           value="<?php echo esc_attr($logo_height); ?>" 
                           min="20" max="320" step="1">
                </div>

                <div class="cwal-preview">
                    <h3><?php _e('Preview', 'custom-wp-admin-logo'); ?></h3>
                    <div class="cwal-preview-box">
                        <?php if ($logo_url): ?>
                            <img src="<?php echo esc_url($logo_url); ?>" 
                                 alt="<?php _e('Login Logo Preview', 'custom-wp-admin-logo'); ?>"
                                 style="height: <?php echo esc_attr($logo_height); ?>px;">
                        <?php else: ?>
                            <p><?php _e('No logo selected', 'custom-wp-admin-logo'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="cwal-form-actions">
                    <button type="submit" class="button button-primary" id="save-settings-btn">
                        <?php _e('Save Changes', 'custom-wp-admin-logo'); ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Section -->
        <div class="cwal-admin-sidebar">
            <!-- Help Box -->
            <div class="cwal-sidebar-box">
                <h3>
                    <span class="dashicons dashicons-editor-help"></span>
                    <?php _e('Need Help?', 'custom-wp-admin-logo'); ?>
                </h3>
                <p><?php _e('For best results:', 'custom-wp-admin-logo'); ?></p>
                <ul>
                    <li><?php _e('Use an image with transparent background (PNG format)', 'custom-wp-admin-logo'); ?></li>
                    <li><?php _e('Recommended image height: 84px', 'custom-wp-admin-logo'); ?></li>
                    <li><?php _e('Maximum width: 320px', 'custom-wp-admin-logo'); ?></li>
                </ul>
            </div>

            <!-- About Box -->
            <div class="cwal-sidebar-box cwal-about-box">
                <h3>
                    <span class="dashicons dashicons-info"></span>
                    <?php _e('About Plugin', 'custom-wp-admin-logo'); ?>
                </h3>
                <div class="cwal-about-content">
                    <p class="cwal-company">
                        <span class="dashicons dashicons-building"></span>
                        <strong><?php _e('Company:', 'custom-wp-admin-logo'); ?></strong>
                        <span>Sparq IT Services</span>
                    </p>
                    <p class="cwal-developer">
                        <span class="dashicons dashicons-admin-users"></span>
                        <strong><?php _e('Developer:', 'custom-wp-admin-logo'); ?></strong>
                        <span>Afzal Hameed</span>
                    </p>
                    <p class="cwal-version">
                        <span class="dashicons dashicons-tag"></span>
                        <strong><?php _e('Version:', 'custom-wp-admin-logo'); ?></strong>
                        <span><?php echo CWAL_VERSION; ?></span>
                    </p>
                    <p class="cwal-website">
                        <span class="dashicons dashicons-admin-site-alt3"></span>
                        <strong><?php _e('Website:', 'custom-wp-admin-logo'); ?></strong>
                        <a href="https://sparqitservices.com" target="_blank">sparqitservices.com</a>
                    </p>
                    <p class="cwal-github">
                        <span class="dashicons dashicons-github"></span>
                        <strong><?php _e('GitHub:', 'custom-wp-admin-logo'); ?></strong>
                        <a href="https://github.com/sparqitservices/custom-wp-admin-logo" target="_blank">
                            View Repository
                        </a>
                    </p>
                </div>
            </div>

            <!-- Support & Review Box -->
            <div class="cwal-sidebar-box cwal-support-box">
                <h3>
                    <span class="dashicons dashicons-star-filled"></span>
                    <?php _e('Support & Review', 'custom-wp-admin-logo'); ?>
                </h3>
                <div class="cwal-support-content">
                    <p><?php _e('If you like this plugin, please consider:', 'custom-wp-admin-logo'); ?></p>
                    
                    <div class="cwal-action-buttons">
                        <a href="https://wordpress.org/support/plugin/custom-wp-admin-logo/reviews/#new-post" 
                           target="_blank" 
                           class="button button-primary">
                            <span class="dashicons dashicons-star-filled"></span>
                            <?php _e('Rate Plugin', 'custom-wp-admin-logo'); ?>
                        </a>
                        
                        <a href="https://github.com/sparqitservices/custom-wp-admin-logo/issues" 
                           target="_blank" 
                           class="button button-secondary">
                            <span class="dashicons dashicons-admin-tools"></span>
                            <?php _e('Report Issue', 'custom-wp-admin-logo'); ?>
                        </a>
                    </div>

                    <div class="cwal-donate">
                        <p><?php _e('Support Development:', 'custom-wp-admin-logo'); ?></p>
                        <a href="https://buymeacoffee.com/iafzalhameed" 
                           target="_blank" 
                           class="button button-secondary">
                            <span class="dashicons dashicons-coffee"></span>
                            <?php _e('Buy Me a Coffee', 'custom-wp-admin-logo'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
