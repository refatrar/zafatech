<?php
/**
 * Plugin Name: Zafa Tech Core
 * Plugin URI: https://zafatech.example
 * Description: Companion plugin for Zafa Tech: custom post types, bilingual fields and demo content importer.
 * Version: 1.1.0
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

function zt_core_apply_french_default() {
    if (get_option('zt_core_language_migration') === '1.1.0') return;
    $fr_home = get_page_by_path('fr/accueil');
    if ($fr_home) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', (int) $fr_home->ID);
    }
    update_option('zt_core_language_migration', '1.1.0');
}
add_action('init', 'zt_core_apply_french_default');


register_activation_hook(__FILE__, function () {
    require_once ZT_CORE_DIR . 'includes/cpt.php';
    require_once ZT_CORE_DIR . 'includes/demo-importer.php';
    if (function_exists('zt_import_demo_content')) {
        zt_import_demo_content();
    }
});
