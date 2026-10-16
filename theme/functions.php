<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/helpers.php';

function zafatech_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 180,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('automatic-feed-links');

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'zafatech'),
        'footer'  => __('Footer Menu', 'zafatech'),
        'mobile'  => __('Mobile Menu', 'zafatech'),
    ));
}
add_action('after_setup_theme', 'zafatech_setup');

function zafatech_enqueue() {
    wp_enqueue_style('zafatech-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.1.4');
    wp_enqueue_style('zafatech-animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1');
    wp_enqueue_style('zafatech-fonts', 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=JetBrains+Mono:wght@500;600&family=Manrope:wght@400;500;600;700&display=swap', array(), null);
    wp_enqueue_script('zafatech-app', get_template_directory_uri() . '/assets/js/app.js', array(), '1.1.4', true);
    wp_localize_script('zafatech-app', 'ztStrings', array(
        'noSymptoms' => __('No symptoms selected yet.', 'zafatech'),
        'lang' => zt_current_lang(),
    ));
}
add_action('wp_enqueue_scripts', 'zafatech_enqueue');

function zafatech_body_classes($classes) {
    $classes[] = 'zt-lang-' . zt_current_lang();
    return $classes;
}
add_filter('body_class', 'zafatech_body_classes');

// Textdomain
function zafatech_textdomain() {
    load_theme_textdomain('zafatech', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'zafatech_textdomain');
