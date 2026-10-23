<?php
/**
 * Customizer: branding, contact details and social links.
 *
 * Header logo uses the core "Site Identity → Logo" control (custom-logo
 * support). Everything below adds what the header/footer need on top of it.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('zt_mod_defaults')) {
    function zt_mod_defaults() {
        return array(
            'zt_footer_logo' => 0,
            'zt_phone'       => '07 53 19 40 03',
            'zt_email'       => 'zafatechparis@gmail.com',
            'zt_address'     => '18 Rue Littré, 75006 Paris',
            'zt_hours_en'    => '',
            'zt_hours_fr'    => '',
            'zt_instagram'   => '',
            'zt_facebook'    => '',
            'zt_tiktok'      => '',
        );
    }
}

if (!function_exists('zt_mod')) {
    function zt_mod($key) {
        $defaults = zt_mod_defaults();
        $value = get_theme_mod($key, isset($defaults[$key]) ? $defaults[$key] : '');
        // An emptied contact field falls back to the default instead of
        // leaving a blank phone link or address in the header and footer.
        if ($value === '' && in_array($key, array('zt_phone', 'zt_email', 'zt_address'), true)) {
            $value = $defaults[$key];
        }
        return $value;
    }
}

function zafatech_customize_register($wp_customize) {
    $wp_customize->add_setting('zt_footer_logo', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'zt_footer_logo', array(
        'label'       => __('Footer logo (dark background)', 'zafatech'),
        'description' => __('Shown on the navy footer. Use a light or white version of the logo. Leave empty to use the bundled white logo.', 'zafatech'),
        'section'     => 'title_tagline',
        'mime_type'   => 'image',
        'priority'    => 9,
    )));

    $wp_customize->add_section('zt_contact', array(
        'title'       => __('Zafa Tech: Contact & Social', 'zafatech'),
        'description' => __('Used in the header, mobile menu and footer.', 'zafatech'),
        'priority'    => 30,
    ));

    $fields = array(
        'zt_phone'     => array(__('Phone number', 'zafatech'), 'text', 'sanitize_text_field'),
        'zt_email'     => array(__('Email address', 'zafatech'), 'email', 'sanitize_email'),
        'zt_address'   => array(__('Address', 'zafatech'), 'text', 'sanitize_text_field'),
        'zt_hours_fr'  => array(__('Opening hours (French)', 'zafatech'), 'text', 'sanitize_text_field'),
        'zt_hours_en'  => array(__('Opening hours (English)', 'zafatech'), 'text', 'sanitize_text_field'),
        'zt_instagram' => array(__('Instagram URL', 'zafatech'), 'url', 'esc_url_raw'),
        'zt_facebook'  => array(__('Facebook URL', 'zafatech'), 'url', 'esc_url_raw'),
        'zt_tiktok'    => array(__('TikTok URL', 'zafatech'), 'url', 'esc_url_raw'),
    );
    $defaults = zt_mod_defaults();
    foreach ($fields as $id => $field) {
        $wp_customize->add_setting($id, array(
            'default'           => $defaults[$id],
            'sanitize_callback' => $field[2],
        ));
        $wp_customize->add_control($id, array(
            'label'       => $field[0],
            'section'     => 'zt_contact',
            'type'        => $field[1],
            'description' => (strpos($id, 'zt_hours') === 0 || in_array($field[1], array('url'), true))
                ? __('Leave empty to show a placeholder.', 'zafatech')
                : '',
        ));
    }
}
add_action('customize_register', 'zafatech_customize_register');
