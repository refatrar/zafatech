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
        $locale = get_locale();
        return (strpos($locale, 'fr') === 0) ? 'fr' : 'en';
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
            foreach (array('en', 'fr') as $l) {
                $links[] = array(
                    'slug' => $l,
                    'name' => $l === 'en' ? 'English' : 'Français',
                    'url' => add_query_arg('lang', $l),
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
