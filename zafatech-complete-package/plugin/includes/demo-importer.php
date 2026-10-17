<?php
if (!defined('ABSPATH')) exit;

function zt_demo_admin_menu() {
    add_management_page(
        'Zafa Tech Demo Import',
        'Zafa Tech Demo',
        'manage_options',
        'zt-demo-import',
        'zt_demo_import_page'
    );
}
add_action('admin_menu', 'zt_demo_admin_menu');

function zt_demo_import_page() {
    if (!current_user_can('manage_options')) return;
    $message = '';
    if (isset($_POST['zt_demo_import_nonce']) && wp_verify_nonce($_POST['zt_demo_import_nonce'], 'zt_demo_import')) {
        if (isset($_POST['zt_reset_demo'])) {
            delete_option('zt_demo_imported');
            delete_option('zt_demo_media');
            $message = 'Demo flags reset. Run import again to recreate.';
        } else {
            $result = zt_import_demo_content(true);
            $message = 'Demo import complete. Created/updated: ' . implode(', ', $result);
        }
    }
    $imported = get_option('zt_demo_imported', false);
    echo '<div class="wrap"><h1>Zafa Tech Demo Content</h1>';
    echo '<p>Status: ' . ($imported ? 'Imported' : 'Not imported') . '</p>';
    echo '<form method="post">';
    wp_nonce_field('zt_demo_import', 'zt_demo_import_nonce');
    submit_button($imported ? 'Refresh Homepage Demo Layout' : 'Import Demo Content');
    echo '<p><button type="submit" name="zt_reset_demo" value="1" class="button">Reset import flags</button></p>';
    echo '</form>';
    if ($message) echo '<div class="updated"><p>' . esc_html($message) . '</p></div>';
    echo '<p>Note: Demo content uses fictional placeholders marked [ ]. Edit each item after import.</p></div>';
}

function zt_import_local_media($file, $title, $alt) {
    $media_map = get_option('zt_demo_media', array());
    $basename = basename($file);
    if (isset($media_map[$basename])) {
        $id = (int) $media_map[$basename];
        if (get_post($id)) return $id;
    }
    if (!file_exists($file)) return 0;
    $uploads = wp_upload_dir();
    $dest = trailingslashit($uploads['path']) . $basename;
    if (!copy($file, $dest)) return 0;
    $attachment = array(
        'post_mime_type' => wp_check_filetype($basename)['type'] ?: 'image/jpeg',
        'post_title' => $title,
        'post_content' => '',
        'post_status' => 'inherit',
    );
    $id = wp_insert_attachment($attachment, $dest);
    if (is_wp_error($id)) return 0;
    if (function_exists('wp_generate_attachment_metadata')) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $meta = wp_generate_attachment_metadata($id, $dest);
        wp_update_attachment_metadata($id, $meta);
    }
    update_post_meta($id, '_wp_attachment_image_alt', $alt);
    $media_map[$basename] = $id;
    update_option('zt_demo_media', $media_map);
    return (int) $id;
}

function zt_find_page($slug) {
    return get_page_by_path($slug);
}

function zt_create_page($slug, $title, $content, $parent = 0, $template = '') {
    $existing = get_page_by_path($slug);
    if ($existing) {
        return $existing->ID;
    }
    $id = wp_insert_post(array(
        'post_type' => 'page',
        'post_title' => $title,
        'post_name' => $slug,
        'post_content' => $content,
        'post_status' => 'publish',
        'post_parent' => $parent,
        'page_template' => $template,
    ));
    return is_wp_error($id) ? 0 : (int) $id;
}

/** Refresh only the imported homepage markup without duplicating demo posts. */
function zt_refresh_demo_homepages($home_en = 0, $home_fr = 0) {
    $home_en_page = zt_find_page('home');
    $home_en = $home_en ?: ($home_en_page ? (int) $home_en_page->ID : 0);
    $home_fr_page = zt_find_page('fr/accueil');
    $home_fr = $home_fr ?: ($home_fr_page ? (int) $home_fr_page->ID : 0);
    $media_map = get_option('zt_demo_media', array());
    $storefront_id = isset($media_map['zafatech-storefront.webp']) ? (int) $media_map['zafatech-storefront.webp'] : 0;
    $storefront_url = $storefront_id ? wp_get_attachment_url($storefront_id) : '';

    foreach (array(
        array($home_en, ZT_CORE_DIR . 'demo-content/home-en.html'),
        array($home_fr, ZT_CORE_DIR . 'demo-content/home-fr.html'),
    ) as $homepage) {
        list($page_id, $file) = $homepage;
        if (!$page_id || !file_exists($file)) continue;
        $content = file_get_contents($file);
        if ($storefront_url) $content = str_replace('__STOREFRONT_URL__', esc_url($storefront_url), $content);
        wp_update_post(array('ID' => $page_id, 'post_content' => $content));
    }
}

function zt_link_pages($en_id, $fr_id) {
    if ($en_id && $fr_id) {
        update_post_meta($en_id, '_zt_translation_id', $fr_id);
        update_post_meta($fr_id, '_zt_translation_id', $en_id);
    }
}

function zt_import_demo_content($refresh_existing = false) {
    if (get_option('zt_demo_imported')) {
        if ($refresh_existing) {
            zt_refresh_demo_homepages();
            return array('homepage demo layout');
        }
        return array('already imported (skipped)');
    }

    $created = array();
    $storefront_id = zt_import_local_media(
        ZT_CORE_DIR . 'demo-content/media/zafatech-storefront.webp',
        'Zafa Tech storefront demo image',
        'The Zafa Tech shop front on Rue Littré: navy façade with a white sign listing repairs, accessories, photocopying and printing.'
    );
    $created[] = 'media';

    // Home pages (EN + FR under parent "fr")
    $fr_parent = zt_create_page('fr', 'Français (FR)', 'Dossier des pages françaises.', 0, '');
    $home_content_en = '';
    $home_content_fr = '';
    $en_file = ZT_CORE_DIR . 'demo-content/home-en.html';
    $fr_file = ZT_CORE_DIR . 'demo-content/home-fr.html';
    if (file_exists($en_file)) $home_content_en = file_get_contents($en_file);
    if (file_exists($fr_file)) $home_content_fr = file_get_contents($fr_file);
    if ($storefront_id) {
        $url = wp_get_attachment_url($storefront_id);
        if ($url) {
            $home_content_en = str_replace('__STOREFRONT_URL__', esc_url($url), $home_content_en);
            $home_content_fr = str_replace('__STOREFRONT_URL__', esc_url($url), $home_content_fr);
        }
    }
    $home_en = zt_create_page('home', 'Home', $home_content_en ? $home_content_en : 'Home', 0, '');
    $home_fr = zt_create_page('accueil', 'Accueil', $home_content_fr ? $home_content_fr : 'Accueil', $fr_parent, '');
    zt_link_pages($home_en, $home_fr);

    // About
    $about_en = zt_create_page('about', 'About', '<p>Zafa Tech is a local workshop in the 6th arrondissement — not a call centre. You can walk in, see who is fixing your device and ask questions along the way.</p>', 0, '');
    $about_fr = zt_create_page('a-propos', 'À propos', '<p>Zafa Tech est un atelier local du 6e arrondissement — pas un centre d’appels. Vous pouvez entrer, voir qui répare votre appareil et poser des questions.</p>', $fr_parent, '');
    zt_link_pages($about_en, $about_fr);

    // Services
    $svc_en = zt_create_page('services', 'Services', '<p>From everyday fixes to repairs other shops turn away.</p>', 0, '');
    $svc_fr = zt_create_page('services-fr', 'Services', '<p>Des réparations du quotidien aux pannes refusées par les autres ateliers.</p>', $fr_parent, '');
    zt_link_pages($svc_en, $svc_fr);

    // Locations
    $loc_en = zt_create_page('locations', 'Workshops', '<p>Visit the Zafa Tech workshop at 18 Rue Littré, 75006 Paris.</p>', 0, '');
    $loc_fr = zt_create_page('ateliers', 'Ateliers', '<p>Visitez l’atelier Zafa Tech au 18 Rue Littré, 75006 Paris.</p>', $fr_parent, '');
    zt_link_pages($loc_en, $loc_fr);

    // Book
    $book_en = zt_create_page('book-a-repair', 'Book a Repair', '<p>Send a repair request. No booking is confirmed until we contact you.</p>', 0, '');
    $book_fr = zt_create_page('reserver-une-reparation', 'Réserver une réparation', '<p>Envoyez une demande de réparation. Aucune réservation n’est confirmée tant que nous ne vous avons pas contacté.</p>', $fr_parent, '');
    zt_link_pages($book_en, $book_fr);

    // FAQ
    $faq_en = zt_create_page('faq', 'FAQ', '<p>Good questions, straight answers.</p>', 0, '');
    $faq_fr = zt_create_page('faq-fr', 'FAQ', '<p>De bonnes questions, des réponses franches.</p>', $fr_parent, '');
    zt_link_pages($faq_en, $faq_fr);

    // Contact
    $contact_en = zt_create_page('contact', 'Contact', '<p>Come see us on Rue Littré.</p>', 0, '');
    $contact_fr = zt_create_page('contact-fr', 'Contact', '<p>Venez nous voir Rue Littré.</p>', $fr_parent, '');
    zt_link_pages($contact_en, $contact_fr);

    // Refurbished
    $ref_en = zt_create_page('refurbished', 'Refurbished Devices', '<p>Second-life devices, checked on our bench. Demo listings only.</p>', 0, '');
    $ref_fr = zt_create_page('appareils-reconditionnes', 'Appareils reconditionnés', '<p>Appareils de seconde vie, contrôlés à l’atelier. Annonces de démonstration uniquement.</p>', $fr_parent, '');
    zt_link_pages($ref_en, $ref_fr);

    // Legal
    $privacy_en = zt_create_page('privacy-policy', 'Privacy Policy', '<p>[Placeholder — insert the final privacy policy text before launch.]</p>', 0, '');
    $terms_en = zt_create_page('terms-of-service', 'Terms of Service', '<p>[Placeholder — insert the final terms text before launch.]</p>', 0, '');
    $policy_en = zt_create_page('service-policy', 'Service Policy', '<p>[Placeholder — insert the final service policy text before launch.]</p>', 0, '');
    $privacy_fr = zt_create_page('politique-de-confidentialite', 'Politique de confidentialité', '<p>[Espace réservé — insérer le texte final de la politique de confidentialité avant mise en ligne.]</p>', $fr_parent, '');
    zt_link_pages($privacy_en, $privacy_fr);

    // Feature homepage content
    if ($storefront_id) {
        if ($home_en) set_post_thumbnail($home_en, $storefront_id);
        if ($about_en) set_post_thumbnail($about_en, $storefront_id);
        if ($loc_en) set_post_thumbnail($loc_en, $storefront_id);
    }

    // Custom post types: services
    $services_data = array(
        array('Smartphone Repair', 'Réparation Smartphone', 'Screens, back glass, batteries, charging ports, cameras, speakers and microphones.', 'Écrans, vitre arrière, batteries, connecteurs de charge, appareils photo, haut-parleurs et micros.'),
        array('Laptop & MacBook Repair', 'Réparation ordinateur portable et MacBook', 'Displays, keyboards, batteries, DC jacks, overheating, SSD and RAM upgrades.', 'Écrans, claviers, batteries, connecteurs d’alimentation, surchauffe, évolutions SSD et RAM.'),
        array('Tablet Repair', 'Réparation tablette', 'Cracked glass, digitizers, batteries and charging connectors.', 'Vitre cassée, écrans tactiles, batteries et connecteurs de charge.'),
        array('Micro-Soldering', 'Micro-soudure', 'Component-level work on logic boards: connectors, power circuits and traces.', 'Interventions de précision sur carte mère : connecteurs, circuits d’alimentation et pistes.'),
        array('Data Recovery', 'Récupération de données', 'Trying to get photos and files back from damaged phones, drives and computers.', 'Récupération de photos et fichiers à partir d’appareils endommagés.'),
        array('Refurbished Devices', 'Appareils reconditionnés', 'Checked, second-life phones, laptops and tablets — ask what is in stock.', 'Téléphones, ordinateurs et tablettes vérifiés — demandez le stock disponible.'),
    );
    foreach ($services_data as $item) {
        $post_id = wp_insert_post(array(
            'post_type' => 'zt_service',
            'post_title' => $item[0],
            'post_excerpt' => $item[2],
            'post_content' => $item[2],
            'post_status' => 'publish',
        ));
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_zt_title_fr', $item[1]);
            update_post_meta($post_id, '_zt_excerpt_fr', $item[3]);
            update_post_meta($post_id, '_zt_content_fr', $item[3]);
        }
    }
    $created[] = 'services';

    // FAQs
    $faqs = array(
        array('Do I need an appointment?', 'Ai-je besoin d’un rendez-vous ?', 'You are welcome to walk in during opening hours. Sending a request online first helps us prepare.', 'Vous pouvez passer sans rendez-vous pendant les horaires d’ouverture. Envoyer d’abord une demande en ligne nous aide à nous préparer.'),
        array('How much will my repair cost?', 'Combien coûtera ma réparation ?', 'It depends on the device, the fault and the part. After diagnosis we give a clear quote and no work begins until you approve.', 'Cela dépend de l’appareil, de la panne et de la pièce. Après diagnostic nous donnons un devis clair et aucun travail ne commence sans votre accord.'),
        array('How long does a repair take?', 'Combien de temps dure une réparation ?', 'Common repairs are usually quicker; board-level work and parts orders take longer. We give an estimate with the quote.', 'Les réparations courantes sont plus rapides; la carte mère et la commande de pièces prennent plus de temps. Nous donnons une estimation avec le devis.'),
    );
    foreach ($faqs as $item) {
        $post_id = wp_insert_post(array(
            'post_type' => 'zt_faq',
            'post_title' => $item[0],
            'post_content' => $item[2],
            'post_status' => 'publish',
        ));
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_zt_title_fr', $item[1]);
            update_post_meta($post_id, '_zt_content_fr', $item[3]);
        }
    }
    $created[] = 'faqs';

    // Testimonials (clearly fictional)
    $testimonials = array(
        array('Alex M.', 'Alex M.', 'Demo review: helpful service and clear quote. — fictional testimonial.', 'Avis de démonstration : service utile et devis clair. — témoignage fictif.'),
    );
    foreach ($testimonials as $item) {
        $post_id = wp_insert_post(array(
            'post_type' => 'zt_testimonial',
            'post_title' => $item[0],
            'post_content' => $item[2],
            'post_status' => 'publish',
        ));
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_zt_content_fr', $item[3]);
        }
    }
    $created[] = 'testimonials';

    // Locations
    $loc_id = wp_insert_post(array(
        'post_type' => 'zt_location',
        'post_title' => 'Zafa Tech — Rue Littré',
        'post_excerpt' => '18 Rue Littré, 75006 Paris',
        'post_content' => 'Main workshop location (demo).',
        'post_status' => 'publish',
    ));
    if (!is_wp_error($loc_id)) {
        update_post_meta($loc_id, '_zt_title_fr', 'Zafa Tech — Rue Littré');
        update_post_meta($loc_id, '_zt_excerpt_fr', '18 Rue Littré, 75006 Paris');
        if ($storefront_id) set_post_thumbnail($loc_id, $storefront_id);
    }
    $created[] = 'locations';

    // Menu
    $menu_name = 'Primary';
    $menu = wp_get_nav_menu_object($menu_name);
    if (!$menu) {
        $menu_id = wp_create_nav_menu($menu_name);
    } else {
        $menu_id = $menu->term_id;
    }
    if (!is_wp_error($menu_id)) {
        $existing_items = wp_get_nav_menu_items($menu_id);
        if (empty($existing_items)) {
            foreach (array(
                'Home' => home_url('/'),
                'Services' => home_url('/services/'),
                'About' => home_url('/about/'),
                'FAQ' => home_url('/faq/'),
                'Contact' => home_url('/contact/'),
            ) as $label => $url) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $label,
                    'menu-item-url' => $url,
                    'menu-item-status' => 'publish',
                ));
            }
            $created[] = 'menu';
        }
        $locations = get_nav_menu_locations();
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    // Front page setting
    if ($home_en) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_fr ?: $home_en);
    }

    if ($refresh_existing) zt_refresh_demo_homepages($home_en, $home_fr);

    update_option('zt_demo_imported', true);
    return $created;
}
