jQuery(document).ready(function($) {
    'use strict';

    // Cache DOM elements
    const $form = $('#cwal-settings-form');
    const $logoUrl = $('#logo-url');
    const $logoHeight = $('#logo-height');
    const $previewBox = $('.cwal-preview-box');
    const $uploadBtn = $('#upload-logo-btn');
    const $saveBtn = $('#save-settings-btn');

    // Initialize media uploader
    let mediaUploader = null;

    // Handle logo upload button click
    $uploadBtn.on('click', function(e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Create the media uploader
        mediaUploader = wp.media({
            title: cwalAdmin.messages.select || 'Select Logo',
            button: {
                text: cwalAdmin.messages.choose || 'Choose Image'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });

        // When an image is selected, run a callback
        mediaUploader.on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            $logoUrl.val(attachment.url).trigger('change');
            updatePreview();
        });

        // Open the uploader dialog
        mediaUploader.open();
    });

    // Handle form submission
    $form.on('submit', function(e) {
        e.preventDefault();
        saveSettings();
    });

    // Handle logo height changes
    $logoHeight.on('change input', function() {
        updatePreview();
    });

    // Handle logo URL changes
    $logoUrl.on('change input', function() {
        updatePreview();
    });

    /**
     * Update preview image
     */
    function updatePreview() {
        const logoUrl = $logoUrl.val();
        const logoHeight = $logoHeight.val();

        if (logoUrl) {
            const $preview = $previewBox.find('img');
            if ($preview.length) {
                $preview.attr('src', logoUrl).css('height', logoHeight + 'px');
            } else {
                $previewBox.html($('<img>', {
                    src: logoUrl,
                    alt: 'Login Logo Preview',
                    style: 'height: ' + logoHeight + 'px'
                }));
            }
        } else {
            $previewBox.html('<p>No logo selected</p>');
        }
    }

    /**
     * Save settings via AJAX
     */
    function saveSettings() {
        $saveBtn.prop('disabled', true).addClass('updating-message');

        $.ajax({
            url: cwalAdmin.ajaxurl,
            type: 'POST',
            data: {
                action: 'cwal_save_settings',
                nonce: cwalAdmin.nonce,
                logo_url: $logoUrl.val(),
                logo_height: $logoHeight.val()
            },
            success: function(response) {
                if (response.success) {
                    showNotice('success', response.data.message);
                } else {
                    showNotice('error', response.data || cwalAdmin.messages.error);
                }
            },
            error: function() {
                showNotice('error', cwalAdmin.messages.error);
            },
            complete: function() {
                $saveBtn.prop('disabled', false).removeClass('updating-message');
            }
        });
    }

    /**
     * Show admin notice
     */
    function showNotice(type, message) {
        const $notice = $('<div>', {
            class: `notice notice-${type} is-dismissible`,
            html: $('<p>', { text: message })
        });

        // Remove existing notices
        $('.notice').remove();

        // Add new notice
        $('.wrap h1').after($notice);

        // Make notice dismissible
        if (typeof wp.notices !== 'undefined' && typeof wp.notices.removeDismissible !== 'undefined') {
            wp.notices.removeDismissible($notice);
        }
    }

    // Initialize preview on page load
    updatePreview();
});
