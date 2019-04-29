<?php
declare(strict_types=1);

namespace SharepointMediaLibrary;

class General extends Helpers\Helper
{
    public function __construct()
    {
        // Add custom body class
        add_filter('admin_body_class', [&$this, 'customBodyClasses']);

        // Add admin pages
        add_action('admin_menu', [$this, 'adminMenu']);

        // Enqueue css & js
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin'], 950);

        // Custom header
        add_action('in_admin_header', [$this, 'adminHeader'], 100);

        // Hide all unrelated notices
        add_action('admin_print_scripts', [$this, 'hideUnrelatedNotices']);
    }

    /**
     * Add custom body classes
     *
     * @param string $classes The list of classes.
     *
     * @return string $classes The updated list of classes.
     */
    public function customBodyClasses(string $classes) : string
    {
        if ($this->isAdminPage()) {
            $classes = $classes . ' is-sml';
        }

        return $classes;
    }

    /**
     * Add the admin pages
     *
     * @return void
     */
    public function adminMenu() : void
    {
        // Add settings page
        add_options_page(
            __('Sharepoint Media Library', SML_NAME),
            __('Sharepoint Media Library', SML_NAME),
            'manage_options',
            SML_NAME . '-settings',
            [new Settings(), 'pluginSettings']
        );

        // TODO: Only add menu page if settings are correct
        // Add media library page
        add_menu_page(
            __('Sharepoint', SML_NAME),
            __('Sharepoint', SML_NAME),
            'upload_files',
            SML_NAME,
            [new Sharepoint(), 'mediaLibrary'],
            'dashicons-admin-media',
            11
        );
    }

    /**
     * Add the admin css & js
     *
     * @return void
     */
    public function enqueueAdmin() : void
    {
        if (!$this->isAdminPage()) {
            return;
        }

        // Style
        wp_register_style(SML_NAME, SML_URL . '/dist/css/' . SML_NAME . '.min.css', false, filemtime(SML_PATH . '/dist/css/' . SML_NAME . '.min.css'));
        wp_enqueue_style(SML_NAME);

        // Scripts
        wp_register_script(SML_NAME, SML_URL . '/dist/js/' . SML_NAME . '.min.js', false, filemtime(SML_PATH . '/dist/js/' . SML_NAME . '.min.js'), true);
        wp_enqueue_script(SML_NAME);
    }
}
