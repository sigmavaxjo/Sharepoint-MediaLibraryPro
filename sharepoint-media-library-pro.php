<?php
/*
 * Plugin Name: Sharepoint Media Library Pro
 * Description: Integration between Media Library Pro and Office365 Sharepoint.
 * Version: 1.0.0
 * Author: Patrik Björn
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text domain: sharepoint-media-library-pro
 * Domain Path: /languages
 *
 * Copyright (C) 2019
 */

if(!defined('ABSPATH'))
    return;

define('SMLP_PATH', plugin_dir_path(__FILE__));
define('SMLP_URL', plugins_url('', __FILE__));
define('SMLP_TEMPLATE_PATH', SMLP_PATH . 'templates/');

load_plugin_textdomain('sharepoint-media-library-pro', false, plugin_basename(dirname(__FILE__)) . '/languages');

// Add autoloader
require __DIR__ . '/vendor/autoload.php';

// Start application
new SharepointMediaLibrary\App();
