<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/customizer.php';

function zafatech_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 177,
        'width'       => 960,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('automatic-feed-links');

    $menus = array(
        'primary' => __('Primary Menu', 'zafatech'),
        'footer'  => __('Footer Menu', 'zafatech'),
        'mobile'  => __('Mobile Menu', 'zafatech'),
    );
    // Polylang/WPML assign one menu per language to each location. Without
    // them, French pages get their own locations.
    if (!zt_has_ml_plugin()) {
        $menus = array(
            'primary'    => __('Primary Menu (English)', 'zafatech'),
            'primary_fr' => __('Primary Menu (French)', 'zafatech'),
            'footer'     => __('Footer Menu (English)', 'zafatech'),
            'footer_fr'  => __('Footer Menu (French)', 'zafatech'),
            'mobile'     => __('Mobile Menu (English)', 'zafatech'),
            'mobile_fr'  => __('Mobile Menu (French)', 'zafatech'),
        );
    }
    register_nav_menus($menus);
}
add_action('after_setup_theme', 'zafatech_setup');

function zafatech_enqueue() {
    wp_enqueue_style('zafatech-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.4.0');
    wp_enqueue_style('zafatech-animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1');
    wp_enqueue_style('zafatech-fonts', 'https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=JetBrains+Mono:wght@500;600&family=Manrope:wght@400;500;600;700&display=swap', array(), null);
    wp_enqueue_script('zafatech-app', get_template_directory_uri() . '/assets/js/app.js', array(), '1.4.0', true);
    wp_localize_script('zafatech-app', 'ztStrings', array(
        'noSymptoms' => __('No symptoms selected yet.', 'zafatech'),
        'lang' => zt_current_lang(),
        'phone' => zt_mod('zt_phone'),
    ));
}
add_action('wp_enqueue_scripts', 'zafatech_enqueue');

// Bundled favicon until a Site Icon is set in Customizer → Site Identity.
function zafatech_fallback_icons() {
    if (has_site_icon()) return;
    $base = get_template_directory_uri() . '/assets/logo/';
    echo '<link rel="icon" href="' . esc_url($base . 'favicon.ico') . '" sizes="any" />' . "\n";
    echo '<link rel="icon" href="' . esc_url($base . 'site-icon.png') . '" type="image/png" />' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($base . 'apple-touch-icon.png') . '" />' . "\n";
}
add_action('wp_head', 'zafatech_fallback_icons');

function zafatech_body_classes($classes) {
    $classes[] = 'zt-lang-' . zt_current_lang();
    return $classes;
}
add_filter('body_class', 'zafatech_body_classes');

function zafatech_language_attributes($output) {
    $lang = zt_current_lang() === 'fr' ? 'fr-FR' : 'en-GB';
    return preg_replace('/lang=("|\')[^"\']+("|\')/', 'lang="' . $lang . '"', $output);
}
add_filter('language_attributes', 'zafatech_language_attributes');

// Textdomain
function zafatech_textdomain() {
    load_theme_textdomain('zafatech', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'zafatech_textdomain');
