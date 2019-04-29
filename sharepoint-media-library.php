<?php
/*
 * Plugin Name: Sharepoint Media Library
 * Description: Integration between Office365 Sharepoint and Wordpress.
 * Version: 1.0.0
 * Author: Patrik Björn
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text domain: sharepoint-media-library
 * Domain Path: /languages
 *
 * Copyright (C) 2019
 */

if (!defined('ABSPATH')) {
    return;
}

define('SML_NAME', 'sharepoint-media-library');
define('SML_PATH', plugin_dir_path(__FILE__));
define('SML_URL', plugins_url('', __FILE__));
define('SML_TEMPLATE_PATH', SML_PATH . 'templates/');

add_action('plugins_loaded', function () {
    load_plugin_textdomain(SML_NAME, false, plugin_basename(dirname(__FILE__)) . '/languages');
});

// Add autoloader
require __DIR__ . '/vendor/autoload.php';

// Add dotenv reader
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');

// Start application
new SharepointMediaLibrary\App();
