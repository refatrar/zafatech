<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#0A1F44" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part('template-parts/icon-sprite'); ?>
<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-full focus:bg-navy-900 focus:px-5 focus:py-3 focus:text-white"><?php echo esc_html(zt_t('skip')); ?></a>

<!-- Header -->
<header id="site-header" class="site-header">
  <div class="container-site flex h-full items-center justify-between gap-4">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-brand" rel="home" aria-label="<?php echo esc_attr(get_bloginfo('name', 'display') . ' — ' . zt_ui('home', 'accueil')); ?>">
      <?php echo zt_logo('light', 'site-logo'); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts ?>
    </a>

    <nav aria-label="<?php echo esc_attr(zt_ui('Primary', 'Principal')); ?>" class="hidden lg:block">
      <?php $zt_primary = zt_menu_items('primary'); ?>
      <ul class="flex items-center gap-1">
        <?php if ($zt_primary) : ?>
          <?php foreach ($zt_primary as $item) : ?>
            <li><a<?php echo zt_menu_link_attrs($item, 'nav-link'); ?>><?php echo esc_html($item->title); ?></a></li>
          <?php endforeach; ?>
        <?php else : ?>
          <li><a class="nav-link" href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_t('nav_services')); ?></a></li>
          <li><a class="nav-link" href="<?php echo esc_url(zt_section_url('why')); ?>"><?php echo esc_html(zt_t('nav_about')); ?></a></li>
          <li><a class="nav-link" href="<?php echo esc_url(zt_section_url('process')); ?>"><?php echo esc_html(zt_t('nav_process')); ?></a></li>
          <li><a class="nav-link" href="<?php echo esc_url(zt_section_url('faq')); ?>"><?php echo esc_html(zt_t('nav_faq')); ?></a></li>
          <li><a class="nav-link" href="<?php echo esc_url(zt_section_url('contact')); ?>"><?php echo esc_html(zt_t('nav_contact')); ?></a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <div class="flex items-center gap-2">
      <a href="<?php echo esc_attr(zt_tel_href()); ?>" class="hidden items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-navy-900 transition-colors hover:text-brand-700 min-[1536px]:inline-flex">
        <svg class="icon h-4 w-4 text-brand-600" aria-hidden="true"><use href="#i-call"/></svg><?php echo esc_html(zt_mod('zt_phone')); ?>
      </a>
      <a href="<?php echo esc_url(zt_section_url('booking')); ?>" class="btn btn-primary hidden whitespace-nowrap px-4 text-sm md:inline-flex xl:px-5"><?php echo esc_html(zt_t('nav_book')); ?><svg class="icon btn-arrow" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
      <!-- Language switcher -->
      <nav aria-label="<?php echo esc_attr(zt_ui('Language', 'Langue')); ?>" class="language-switch">
        <?php foreach (zt_lang_switcher_links() as $l) : ?>
          <a class="lang-link<?php echo $l['current'] ? ' is-active' : ''; ?>" href="<?php echo esc_url($l['url']); ?>" hreflang="<?php echo esc_attr($l['slug']); ?>"><?php echo esc_html($l['name']); ?></a>
        <?php endforeach; ?>
      </nav>
      <button id="nav-toggle" class="burger lg:hidden" type="button" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php echo esc_attr(zt_t('open_menu')); ?>">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile nav -->
<button id="mobile-nav-backdrop" class="mobile-nav-backdrop lg:hidden" type="button" tabindex="-1" aria-label="<?php echo esc_attr(zt_ui('Close menu', 'Fermer le menu')); ?>"></button>
<div id="mobile-nav" class="mobile-nav lg:hidden" aria-label="<?php echo esc_attr(zt_ui('Mobile menu', 'Menu mobile')); ?>">
  <div class="mobile-nav-handle" aria-hidden="true"></div>
  <div class="mb-4 flex items-center justify-between">
    <p class="font-mono text-xs font-semibold uppercase tracking-[0.16em] text-brand-700"><?php echo esc_html(zt_ui('Explore Zafa Tech', 'Explorer Zafa Tech')); ?></p>
    <button type="button" class="mobile-nav-close" aria-label="<?php echo esc_attr(zt_ui('Close menu', 'Fermer le menu')); ?>"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button>
  </div>
  <nav aria-label="<?php echo esc_attr(zt_ui('Mobile navigation', 'Navigation mobile')); ?>">
    <?php $zt_mobile = zt_menu_items('mobile') ?: zt_menu_items('primary'); ?>
    <?php if ($zt_mobile) : ?>
      <?php foreach ($zt_mobile as $item) : ?>
        <a<?php echo zt_menu_link_attrs($item, 'm-link'); ?>><?php echo esc_html($item->title); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
      <?php endforeach; ?>
    <?php else : ?>
    <a class="m-link" href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_t('nav_services')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="<?php echo esc_url(zt_section_url('diagnose')); ?>"><?php echo esc_html(zt_t('nav_diagnose')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="<?php echo esc_url(zt_section_url('why')); ?>"><?php echo esc_html(zt_t('nav_about')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="<?php echo esc_url(zt_section_url('process')); ?>"><?php echo esc_html(zt_t('nav_process')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="<?php echo esc_url(zt_section_url('faq')); ?>"><?php echo esc_html(zt_t('nav_faq')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="<?php echo esc_url(zt_section_url('contact')); ?>"><?php echo esc_html(zt_t('nav_contact')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <?php endif; ?>
  </nav>
  <div class="mt-8 grid gap-3">
    <a href="<?php echo esc_url(zt_section_url('booking')); ?>" class="btn btn-primary w-full"><?php echo esc_html(zt_t('nav_book')); ?><svg class="icon btn-arrow" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a href="<?php echo esc_attr(zt_tel_href()); ?>" class="btn btn-ghost w-full"><svg class="icon" aria-hidden="true"><use href="#i-call"/></svg><?php echo esc_html(zt_t('call') . ' ' . zt_mod('zt_phone')); ?></a>
  </div>
  <p class="mt-8 flex items-start gap-2 text-sm text-muted"><svg class="icon h-5 w-5 text-crimson-500" aria-hidden="true"><use href="#i-pin"/></svg><?php echo esc_html(zt_mod('zt_address')); ?></p>
  <nav aria-label="<?php echo esc_attr(zt_ui('Language', 'Langue')); ?>" class="mt-6 flex gap-2">
    <?php foreach (zt_lang_switcher_links() as $l) : ?>
      <a class="lang-link<?php echo $l['current'] ? ' is-active' : ''; ?>" href="<?php echo esc_url($l['url']); ?>"><?php echo esc_html($l['name']); ?></a>
    <?php endforeach; ?>
  </nav>
</div>
<nav class="mobile-dock lg:hidden" aria-label="<?php echo esc_attr(zt_ui('Quick actions', 'Actions rapides')); ?>">
  <a class="mobile-dock-link" href="<?php echo esc_url(zt_section_url('top')); ?>"><svg class="icon" aria-hidden="true"><use href="#i-home"/></svg><span><?php echo esc_html(zt_ui('Home', 'Accueil')); ?></span></a>
  <a class="mobile-dock-link" href="<?php echo esc_url(zt_section_url('services')); ?>"><svg class="icon" aria-hidden="true"><use href="#i-tool"/></svg><span><?php echo esc_html(zt_t('nav_services')); ?></span></a>
  <a class="mobile-dock-link" href="<?php echo esc_url(zt_section_url('diagnose')); ?>"><svg class="icon" aria-hidden="true"><use href="#i-diagnose"/></svg><span><?php echo esc_html(zt_ui('Diagnose', 'Diagnostic')); ?></span></a>
  <a class="mobile-dock-link" href="<?php echo esc_attr(zt_tel_href()); ?>"><svg class="icon" aria-hidden="true"><use href="#i-call"/></svg><span><?php echo esc_html(zt_ui('Call', 'Appeler')); ?></span></a>
  <a class="mobile-dock-link mobile-dock-primary" href="<?php echo esc_url(zt_section_url('booking')); ?>"><svg class="icon" aria-hidden="true"><use href="#i-calendar"/></svg><span><?php echo esc_html(zt_ui('Book', 'Réserver')); ?></span></a>
</nav>
<div id="top-sentinel" class="pointer-events-none absolute left-0 top-0 h-6 w-px" aria-hidden="true"></div>
<main id="main">
