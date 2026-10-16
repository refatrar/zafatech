<?php
if (!defined('ABSPATH')) exit;

function zt_register_post_types() {
    $types = array(
        'zt_service' => array(
            'labels' => array('name' => 'Services', 'singular_name' => 'Service'),
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        ),
        'zt_faq' => array(
            'labels' => array('name' => 'FAQs', 'singular_name' => 'FAQ'),
            'supports' => array('title', 'editor'),
        ),
        'zt_testimonial' => array(
            'labels' => array('name' => 'Testimonials', 'singular_name' => 'Testimonial'),
            'supports' => array('title', 'editor'),
        ),
        'zt_location' => array(
            'labels' => array('name' => 'Locations', 'singular_name' => 'Location'),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        ),
    );
    foreach ($types as $slug => $cfg) {
        register_post_type($slug, array(
            'labels' => array(
                'name' => $cfg['labels']['name'],
                'singular_name' => $cfg['labels']['singular_name'],
                'add_new_item' => 'Add New ' . $cfg['labels']['singular_name'],
                'edit_item' => 'Edit ' . $cfg['labels']['singular_name'],
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-hammer',
            'supports' => $cfg['supports'],
            'rewrite' => array('slug' => $slug),
        ));
    }

    register_taxonomy('zt_service_category', 'zt_service', array(
        'labels' => array('name' => 'Service Categories', 'singular_name' => 'Service Category'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'service-category'),
    ));
}
add_action('init', 'zt_register_post_types');

// Bilingual meta boxes (French fields)
function zt_add_meta_boxes() {
    $screens = array('zt_service', 'zt_faq', 'zt_testimonial', 'zt_location', 'page');
    foreach ($screens as $screen) {
        add_meta_box('zt_fr_fields', __('French (FR) content', 'zafatech'), 'zt_render_fr_meta_box', $screen, 'normal', 'default');
    }
}
add_action('add_meta_boxes', 'zt_add_meta_boxes');

function zt_render_fr_meta_box($post) {
    wp_nonce_field('zt_fr_meta', 'zt_fr_meta_nonce');
    $title = get_post_meta($post->ID, '_zt_title_fr', true);
    $excerpt = get_post_meta($post->ID, '_zt_excerpt_fr', true);
    $content = get_post_meta($post->ID, '_zt_content_fr', true);
    echo '<p><label>' . esc_html__('French title', 'zafatech') . '</label><br /><input type="text" name="zt_title_fr" value="' . esc_attr($title) . '" style="width:100%" /></p>';
    echo '<p><label>' . esc_html__('French excerpt', 'zafatech') . '</label><br /><textarea name="zt_excerpt_fr" style="width:100%">' . esc_textarea($excerpt) . '</textarea></p>';
    echo '<p><label>' . esc_html__('French content', 'zafatech') . '</label><br /><textarea name="zt_content_fr" rows="6" style="width:100%">' . esc_textarea($content) . '</textarea></p>';
}

function zt_save_fr_meta($post_id) {
    if (!isset($_POST['zt_fr_meta_nonce']) || !wp_verify_nonce($_POST['zt_fr_meta_nonce'], 'zt_fr_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    foreach (array('zt_title_fr' => '_zt_title_fr', 'zt_excerpt_fr' => '_zt_excerpt_fr', 'zt_content_fr' => '_zt_content_fr') as $field => $meta) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta, sanitize_textarea_field(wp_unslash($_POST[$field])));
        }
    }
}
add_action('save_post', 'zt_save_fr_meta');
