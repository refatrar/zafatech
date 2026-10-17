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
    <a href="<?php echo esc_url(home_url('/')); ?>" class="group flex items-center gap-2.5" aria-label="Zafa Tech — home">
      <svg class="h-10 w-10 text-brand-600 transition-transform duration-500 group-hover:-translate-y-0.5" viewBox="0 0 64 64" fill="currentColor" aria-hidden="true"><use href="#i-fleur"/></svg>
      <span class="flex flex-col leading-none">
        <span class="font-brand text-[1.35rem] font-bold tracking-wide text-crimson-500">Z<span class="text-[1.05rem]">AFA</span>T<span class="text-[1.05rem]">ECH</span></span>
        <span class="mt-1 hidden border-t border-navy-900/70 pt-1 font-sans text-[0.58rem] font-semibold uppercase tracking-[0.2em] text-navy-900 xs:block"><?php echo esc_html(zt_t('site_tagline')); ?></span>
      </span>
    </a>

    <nav aria-label="Primary" class="hidden lg:block">
      <?php
      if (has_nav_menu('primary') && zt_current_lang() === 'en') {
          wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'flex items-center gap-1', 'fallback_cb' => false));
      } else {
          ?>
          <ul class="flex items-center gap-1">
            <li><a class="nav-link" href="#services"><?php echo esc_html(zt_t('nav_services')); ?></a></li>
            <li><a class="nav-link" href="#why"><?php echo esc_html(zt_t('nav_about')); ?></a></li>
            <li><a class="nav-link" href="#process"><?php echo esc_html(zt_t('nav_process')); ?></a></li>
            <li><a class="nav-link" href="#faq"><?php echo esc_html(zt_t('nav_faq')); ?></a></li>
            <li><a class="nav-link" href="#contact"><?php echo esc_html(zt_t('nav_contact')); ?></a></li>
          </ul>
          <?php
      }
      ?>
    </nav>

    <?php if (!empty($GLOBALS['zt_mobile_nav_allowed'])) : ?>
    <?php endif; ?>

    <div class="flex items-center gap-2">
      <a href="tel:+33753194003" class="hidden items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-navy-900 transition-colors hover:text-brand-700 min-[1536px]:inline-flex">
        <svg class="icon h-4 w-4 text-brand-600" aria-hidden="true"><use href="#i-call"/></svg><?php echo esc_html('07 53 19 40 03'); ?>
      </a>
      <a href="#booking" class="btn btn-primary hidden whitespace-nowrap px-4 text-sm md:inline-flex xl:px-5"><?php echo esc_html(zt_t('nav_book')); ?><svg class="icon btn-arrow" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
      <!-- Language switcher -->
      <nav aria-label="Langue" class="language-switch">
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
<div id="mobile-nav" class="mobile-nav lg:hidden" aria-label="Mobile">
  <div class="mobile-nav-handle" aria-hidden="true"></div>
  <div class="mb-4 flex items-center justify-between">
    <p class="font-mono text-xs font-semibold uppercase tracking-[0.16em] text-brand-700"><?php echo esc_html(zt_ui('Explore Zafa Tech', 'Explorer Zafa Tech')); ?></p>
    <button type="button" class="mobile-nav-close" aria-label="<?php echo esc_attr(zt_ui('Close menu', 'Fermer le menu')); ?>"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button>
  </div>
  <nav aria-label="Mobile primary">
    <a class="m-link" href="#services"><?php echo esc_html(zt_t('nav_services')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="#diagnose"><?php echo esc_html(zt_t('nav_diagnose')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="#why"><?php echo esc_html(zt_t('nav_about')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="#process"><?php echo esc_html(zt_t('nav_process')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="#faq"><?php echo esc_html(zt_t('nav_faq')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a class="m-link" href="#contact"><?php echo esc_html(zt_t('nav_contact')); ?><svg class="icon text-brand-600" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
  </nav>
  <div class="mt-8 grid gap-3">
    <a href="#booking" class="btn btn-primary w-full"><?php echo esc_html(zt_t('nav_book')); ?><svg class="icon btn-arrow" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    <a href="tel:+33753194003" class="btn btn-ghost w-full"><svg class="icon" aria-hidden="true"><use href="#i-call"/></svg><?php echo esc_html(zt_t('call')); ?> 07 53 19 40 03</a>
  </div>
  <p class="mt-8 flex items-start gap-2 text-sm text-muted"><svg class="icon h-5 w-5 text-crimson-500" aria-hidden="true"><use href="#i-pin"/></svg><?php echo esc_html(zt_t('address')); ?></p>
  <nav aria-label="Mobile language" class="mt-6 flex gap-2">
    <?php foreach (zt_lang_switcher_links() as $l) : ?>
      <a class="lang-link<?php echo $l['current'] ? ' is-active' : ''; ?>" href="<?php echo esc_url($l['url']); ?>"><?php echo esc_html($l['name']); ?></a>
    <?php endforeach; ?>
  </nav>
</div>
<nav class="mobile-dock lg:hidden" aria-label="<?php echo esc_attr(zt_ui('Quick actions', 'Actions rapides')); ?>">
  <a class="mobile-dock-link" href="#top"><svg class="icon" aria-hidden="true"><use href="#i-home"/></svg><span><?php echo esc_html(zt_ui('Home', 'Accueil')); ?></span></a>
  <a class="mobile-dock-link" href="#services"><svg class="icon" aria-hidden="true"><use href="#i-tool"/></svg><span><?php echo esc_html(zt_t('nav_services')); ?></span></a>
  <a class="mobile-dock-link" href="#diagnose"><svg class="icon" aria-hidden="true"><use href="#i-diagnose"/></svg><span><?php echo esc_html(zt_ui('Diagnose', 'Diagnostic')); ?></span></a>
  <a class="mobile-dock-link" href="tel:+33753194003"><svg class="icon" aria-hidden="true"><use href="#i-call"/></svg><span><?php echo esc_html(zt_ui('Call', 'Appeler')); ?></span></a>
  <a class="mobile-dock-link mobile-dock-primary" href="#booking"><svg class="icon" aria-hidden="true"><use href="#i-calendar"/></svg><span><?php echo esc_html(zt_ui('Book', 'Réserver')); ?></span></a>
</nav>
<div id="top-sentinel" class="pointer-events-none absolute left-0 top-0 h-6 w-px" aria-hidden="true"></div>
<main id="main">
