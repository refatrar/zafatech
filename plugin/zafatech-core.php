<?php
/**
 * Plugin Name: Zafa Tech Core
 * Plugin URI: https://zafatech.example
 * Description: Companion plugin for Zafa Tech: custom post types, bilingual fields and demo content importer.
 * Version: 1.0.1
 * Author: Zafa Tech
 * License: GPL-2.0-or-later
 * Text Domain: zafatech-core
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ZT_CORE_DIR', plugin_dir_path(__FILE__));
define('ZT_CORE_URL', plugin_dir_url(__FILE__));

require_once ZT_CORE_DIR . 'includes/cpt.php';
require_once ZT_CORE_DIR . 'includes/demo-importer.php';
require_once ZT_CORE_DIR . 'includes/admin.php';


register_activation_hook(__FILE__, function () {
    require_once ZT_CORE_DIR . 'includes/cpt.php';
    require_once ZT_CORE_DIR . 'includes/demo-importer.php';
    if (function_exists('zt_import_demo_content')) {
        zt_import_demo_content();
    }
});
