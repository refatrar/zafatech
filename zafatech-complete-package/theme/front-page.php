<?php
get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();
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
} else {
    // Fallback static design if no page content is present.
    $lang = zt_current_lang() === 'fr' ? 'fr' : 'en';
    get_template_part('template-parts/front', $lang);
}
get_footer();
