<?php
/**
 * Helpers: language detection and bilingual strings.
 */

if (!function_exists('zt_current_lang')) {
    function zt_current_lang() {
        if (function_exists('pll_current_language')) {
            $l = pll_current_language('slug');
            if ($l) return $l === 'fr_FR' ? 'fr' : $l;
        }
        if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE) {
            return (strpos(ICL_LANGUAGE_CODE, 'fr') === 0) ? 'fr' : 'en';
        }
        if (isset($_GET['lang']) && in_array($_GET['lang'], array('en', 'fr'), true)) {
            return sanitize_key($_GET['lang']);
        }
        // Inner pages carry their own language (French pages live under the
        // "fr" parent). The front page keeps the French default below.
        if (did_action('wp') && is_page() && !is_front_page()) {
            return zt_page_lang(get_queried_object());
        }
        // Zafa Tech serves its Paris audience in French by default. English is
        // opt-in through the visible language switcher.
        return 'fr';
    }
}

if (!function_exists('zt_strings')) {
    function zt_strings($lang = 'en') {
        static $cache = array();
        if (isset($cache[$lang])) return $cache[$lang];
        $en = array(
            'site_tagline' => 'All solutions on demand',
            'skip' => 'Skip to content',
            'nav_services' => 'Services',
            'nav_about' => 'About',
            'nav_process' => 'How it works',
            'nav_faq' => 'FAQ',
            'nav_contact' => 'Contact',
            'nav_diagnose' => 'Choose your device',
            'nav_book' => 'Book a Repair',
            'call' => 'Call',
            'address' => '18 Rue Littré, 75006 Paris',
            'open_menu' => 'Open menu',
            'close_menu' => 'Close menu',
        );
        $fr = array(
            'site_tagline' => 'Toutes les solutions sur demande',
            'skip' => 'Aller au contenu',
            'nav_services' => 'Services',
            'nav_about' => 'À propos',
            'nav_process' => 'Comment ça marche',
            'nav_faq' => 'FAQ',
            'nav_contact' => 'Contact',
            'nav_diagnose' => 'Choisir votre appareil',
            'nav_book' => 'Réserver une réparation',
            'call' => 'Appeler',
            'address' => '18 Rue Littré, 75006 Paris',
            'open_menu' => 'Ouvrir le menu',
            'close_menu' => 'Fermer le menu',
        );
        $out = array();
        foreach (array_keys($en) as $k) {
            $out[$k] = ($lang === 'fr') ? (isset($fr[$k]) ? $fr[$k] : $en[$k]) : $en[$k];
        }
        $cache[$lang] = $out;
        return $out;
    }
}

if (!function_exists('zt_t')) {
    function zt_t($key) {
        $s = zt_strings(zt_current_lang());
        return isset($s[$key]) ? $s[$key] : $key;
    }
}

if (!function_exists('zt_lang_switcher_links')) {
    function zt_lang_switcher_links() {
        $links = array();
        if (function_exists('pll_the_languages')) {
            $raw = pll_the_languages(array('raw' => 1));
            if (is_array($raw)) {
                foreach ($raw as $slug => $l) {
                    $links[] = array('slug' => $slug, 'name' => $l['name'], 'url' => $l['url'], 'current' => !empty($l['current_lang']));
                }
            }
        }
        if (empty($links)) {
            $current = zt_current_lang();
            $page = (is_page() && !is_front_page()) ? get_queried_object() : null;
            foreach (array('fr', 'en') as $l) {
                if ($page) {
                    // Link to the linked translation; without one, to that language's homepage
                    // rather than this page with mismatched chrome.
                    $translation = get_post((int) get_post_meta($page->ID, '_zt_translation_id', true));
                    if (zt_page_lang($page) === $l) {
                        $url = get_permalink($page);
                    } elseif ($translation && $translation->post_status === 'publish') {
                        $url = get_permalink($translation);
                    } else {
                        $url = $l === 'en' ? add_query_arg('lang', 'en', home_url('/')) : home_url('/');
                    }
                } else {
                    $url = add_query_arg('lang', $l);
                }
                $links[] = array(
                    'slug' => $l,
                    'name' => $l === 'en' ? 'EN' : 'FR',
                    'url' => $url,
                    'current' => ($current === $l),
                );
            }
        }
        return $links;
    }
}


if (!function_exists('zt_ui')) {
    function zt_ui($en, $fr) {
        return (zt_current_lang() === 'fr') ? $fr : $en;
    }
}

if (!function_exists('zt_has_ml_plugin')) {
    /** Polylang/WPML assign menus and front pages per language themselves. */
    function zt_has_ml_plugin() {
        return function_exists('pll_current_language') || defined('ICL_SITEPRESS_VERSION');
    }
}

if (!function_exists('zt_page_lang')) {
    /** Without a multilingual plugin, French pages live under the "fr" parent page. */
    function zt_page_lang($post) {
        foreach (get_post_ancestors($post) as $ancestor) {
            if (get_post_field('post_name', $ancestor) === 'fr') return 'fr';
        }
        return 'en';
    }
}

if (!function_exists('zt_section_url')) {
    /** Link to a homepage section: "#id" on the front page, home URL + "#id" elsewhere. */
    function zt_section_url($id) {
        if (is_front_page()) return '#' . $id;
        if (function_exists('pll_home_url')) {
            $url = pll_home_url();
        } else {
            $url = apply_filters('wpml_home_url', home_url('/'));
            if (!zt_has_ml_plugin() && zt_current_lang() === 'en') $url = add_query_arg('lang', 'en', $url);
        }
        return $url . '#' . $id;
    }
}

/* ------------------------------------------------------------------ */
/* Branding                                                            */
/* ------------------------------------------------------------------ */

if (!function_exists('zt_logo')) {
    /**
     * Site logo image. $variant "dark" is for the navy footer.
     * Header: Customizer → Site Identity → Logo, else the bundled navy logo.
     * Footer: Customizer → Site Identity → Footer logo, else the bundled white logo.
     */
    function zt_logo($variant = 'light', $class = '') {
        $alt = get_bloginfo('name', 'display');
        $id = $variant === 'dark' ? (int) zt_mod('zt_footer_logo') : (int) get_theme_mod('custom_logo');
        if ($id && wp_attachment_is_image($id)) {
            return wp_get_attachment_image($id, 'full', false, array(
                'class'    => $class,
                'alt'      => $alt,
                'loading'  => $variant === 'dark' ? 'lazy' : 'eager',
                'decoding' => 'async',
            ));
        }
        $file = $variant === 'dark' ? 'zafatech-logo-white.webp' : 'zafatech-logo.webp';
        return sprintf(
            '<img src="%s" width="960" height="177" class="%s" alt="%s" loading="%s" decoding="async" />',
            esc_url(get_template_directory_uri() . '/assets/logo/' . $file),
            esc_attr($class),
            esc_attr($alt),
            $variant === 'dark' ? 'lazy' : 'eager'
        );
    }
}

/* ------------------------------------------------------------------ */
/* Contact details (Customizer → Zafa Tech: Contact & Social)          */
/* ------------------------------------------------------------------ */

if (!function_exists('zt_tel_href')) {
    function zt_tel_href() {
        $digits = preg_replace('/[^0-9+]/', '', zt_mod('zt_phone'));
        // French national format (0X XX XX XX XX) → +33 X XX XX XX XX
        if (strlen($digits) === 10 && $digits[0] === '0') $digits = '+33' . substr($digits, 1);
        return 'tel:' . $digits;
    }
}

if (!function_exists('zt_map_url')) {
    function zt_map_url() {
        return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode(zt_mod('zt_address'));
    }
}

if (!function_exists('zt_hours')) {
    /** Opening hours for the current language, or null when not set yet. */
    function zt_hours() {
        $hours = zt_mod(zt_current_lang() === 'fr' ? 'zt_hours_fr' : 'zt_hours_en');
        if ($hours === '') $hours = zt_mod(zt_current_lang() === 'fr' ? 'zt_hours_en' : 'zt_hours_fr');
        return $hours !== '' ? $hours : null;
    }
}

if (!function_exists('zt_social_links')) {
    function zt_social_links() {
        $links = array();
        foreach (array('instagram' => 'Instagram', 'facebook' => 'Facebook', 'tiktok' => 'TikTok') as $slug => $name) {
            $links[] = array('slug' => $slug, 'name' => $name, 'url' => zt_mod('zt_' . $slug));
        }
        return $links;
    }
}

/* ------------------------------------------------------------------ */
/* Menus                                                               */
/* ------------------------------------------------------------------ */

if (!function_exists('zt_menu_items')) {
    /**
     * Top-level items of the menu assigned to $location for the current
     * language, or an empty array when none is assigned (templates then
     * render their built-in links). Without Polylang/WPML, French pages use
     * the "<location>_fr" location.
     */
    function zt_menu_items($location) {
        if (!zt_has_ml_plugin() && zt_current_lang() === 'fr') {
            $location .= '_fr';
        }
        $locations = get_nav_menu_locations();
        if (empty($locations[$location])) return array();
        $items = wp_get_nav_menu_items($locations[$location], array('update_post_term_cache' => false));
        if (!$items) return array();
        if (function_exists('_wp_menu_item_classes_by_context')) {
            _wp_menu_item_classes_by_context($items);
        }
        $out = array();
        foreach ($items as $item) {
            if ((int) $item->menu_item_parent !== 0) continue;
            $out[] = $item;
        }
        return $out;
    }
}

if (!function_exists('zt_menu_link_attrs')) {
    function zt_menu_link_attrs($item, $class) {
        $classes = array_filter(array_merge(array($class), (array) get_post_meta($item->ID, '_menu_item_classes', true)));
        $attrs = ' class="' . esc_attr(implode(' ', $classes)) . '" href="' . esc_url($item->url) . '"';
        if (!empty($item->target)) $attrs .= ' target="' . esc_attr($item->target) . '"';
        $rel = trim($item->xfn . ($item->target === '_blank' ? ' noopener' : ''));
        if ($rel) $attrs .= ' rel="' . esc_attr($rel) . '"';
        if (!empty($item->attr_title)) $attrs .= ' title="' . esc_attr($item->attr_title) . '"';
        if (!empty($item->current)) $attrs .= ' aria-current="page"';
        return $attrs;
    }
}
