<?php
get_header();
$zt_lang = zt_current_lang();
$zt_home = get_page_by_path($zt_lang === 'fr' ? 'fr/accueil' : 'home');
if ($zt_home) {
    $zt_original_post = isset($GLOBALS['post']) ? $GLOBALS['post'] : null;
    $GLOBALS['post'] = $zt_home;
    setup_postdata($zt_home);
    if ($zt_home->post_content) {
        // All homepage content is managed in Pages and is editable in WP admin.
        // The demo homepage is a complete component document. WordPress's
        // wpautop would inject <p>/<br> tags into its grids and SVG wrappers,
        // creating invalid HTML that browsers repair by moving grid children.
        echo '<div class="zt-home-content">';
        $zt_had_wpautop = has_filter('the_content', 'wpautop');
        if ($zt_had_wpautop) {
            remove_filter('the_content', 'wpautop', $zt_had_wpautop);
        }
        the_content();
        if ($zt_had_wpautop) {
            add_filter('the_content', 'wpautop', $zt_had_wpautop);
        }
        echo '</div>';
    }
    wp_reset_postdata();
    if ($zt_original_post) $GLOBALS['post'] = $zt_original_post;
} else {
    // Fallback static design if no page content is present.
    get_template_part('template-parts/front', $zt_lang);
}
get_footer();
