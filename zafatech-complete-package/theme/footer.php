  </main>

  <footer class="site-footer on-dark bg-navy-950 pt-10 text-white/70 sm:pt-12 lg:pt-16" aria-labelledby="footer-title">
    <h2 id="footer-title" class="sr-only"><?php echo esc_html(get_bloginfo('name', 'display') . ' — ' . zt_ui('site footer', 'pied de page')); ?></h2>
    <div class="container-site grid gap-8 pb-8 sm:gap-10 sm:pb-10 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr] lg:gap-12 lg:pb-12">
      <div class="md:col-span-2 lg:col-span-1">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand" rel="home" aria-label="<?php echo esc_attr(get_bloginfo('name', 'display') . ' — ' . zt_ui('home', 'accueil')); ?>">
          <?php echo zt_logo('dark', 'footer-logo'); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts ?>
        </a>
        <p class="mt-4 max-w-xl text-sm leading-relaxed lg:mt-5 lg:max-w-xs"><?php echo esc_html(zt_ui('Smartphone, computer and console repair, board-level micro-soldering and everyday tech services in Paris 6e.', 'Réparation de smartphones, ordinateurs et consoles, micro-soudure sur carte mère et services techniques du quotidien à Paris 6e.')); ?></p>
        <ul class="mt-5 flex gap-2 lg:mt-6" aria-label="<?php echo esc_attr(zt_ui('Social media', 'Réseaux sociaux')); ?>">
          <?php foreach (zt_social_links() as $social) : ?>
            <?php if ($social['url']) : ?>
              <li><a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 transition hover:border-white/40 hover:text-white" aria-label="<?php echo esc_attr($social['name']); ?>"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-<?php echo esc_attr($social['slug']); ?>"/></svg></a></li>
            <?php else : ?>
              <li><a href="#" data-placeholder-link="<?php echo esc_attr($social['name']); ?>" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 transition hover:border-white/40 hover:text-white" aria-label="<?php echo esc_attr($social['name'] . ' ' . zt_ui('(coming soon)', '(bientôt)')); ?>"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-<?php echo esc_attr($social['slug']); ?>"/></svg></a></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>

      <nav class="hidden lg:block" aria-label="<?php echo esc_attr(zt_ui('Footer services', 'Services (pied de page)')); ?>">
        <h3 class="font-sans text-sm font-semibold uppercase tracking-wider !text-white"><?php echo esc_html(zt_t('nav_services')); ?></h3>
        <ul class="mt-4 space-y-2.5 text-sm">
          <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_ui('Smartphone repair', 'Réparation de smartphone')); ?></a></li>
          <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_ui('Laptop and computer repair', 'Réparation d’ordinateur portable et de bureau')); ?></a></li>
          <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_ui('Tablet and console repair', 'Réparation de tablette et de console')); ?></a></li>
          <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('lab')); ?>"><?php echo esc_html(zt_ui('Micro-soldering', 'Micro-soudure')); ?></a></li>
          <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_ui('Data recovery', 'Récupération de données')); ?></a></li>
          <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('refurbished')); ?>"><?php echo esc_html(zt_ui('Refurbished devices', 'Appareils reconditionnés')); ?></a></li>
        </ul>
      </nav>

      <nav class="hidden lg:block" aria-label="<?php echo esc_attr(zt_ui('Footer navigation', 'Navigation (pied de page)')); ?>">
        <h3 class="font-sans text-sm font-semibold uppercase tracking-wider !text-white"><?php echo esc_html(zt_ui('Navigate', 'Navigation')); ?></h3>
        <?php $zt_footer_menu = zt_menu_items('footer'); ?>
        <ul class="mt-4 space-y-2.5 text-sm">
          <?php if ($zt_footer_menu) : ?>
            <?php foreach ($zt_footer_menu as $item) : ?>
              <li><a<?php echo zt_menu_link_attrs($item, 'hover:text-white'); ?>><?php echo esc_html($item->title); ?></a></li>
            <?php endforeach; ?>
          <?php else : ?>
            <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('why')); ?>"><?php echo esc_html(zt_t('nav_about')); ?></a></li>
            <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('process')); ?>"><?php echo esc_html(zt_t('nav_process')); ?></a></li>
            <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('instore')); ?>"><?php echo esc_html(zt_ui('In-store services', 'Services en boutique')); ?></a></li>
            <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('faq')); ?>"><?php echo esc_html(zt_t('nav_faq')); ?></a></li>
            <li><a class="hover:text-white" href="<?php echo esc_url(zt_section_url('booking')); ?>"><?php echo esc_html(zt_t('nav_book')); ?></a></li>
          <?php endif; ?>
        </ul>
      </nav>

      <div class="hidden lg:block">
        <h3 class="font-sans text-sm font-semibold uppercase tracking-wider !text-white"><?php echo esc_html(zt_t('nav_contact')); ?></h3>
        <address class="mt-4 space-y-3 text-sm not-italic">
          <p class="flex gap-2.5"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-pin"/></svg><?php echo esc_html(zt_mod('zt_address')); ?></p>
          <p><a class="flex gap-2.5 hover:text-white" href="<?php echo esc_attr(zt_tel_href()); ?>"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-call"/></svg><?php echo esc_html(zt_mod('zt_phone')); ?></a></p>
          <p><a class="flex gap-2.5 break-all hover:text-white" href="<?php echo esc_attr('mailto:' . antispambot(zt_mod('zt_email'))); ?>"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-mail"/></svg><?php echo esc_html(antispambot(zt_mod('zt_email'))); ?></a></p>
          <p class="flex gap-2.5"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-clock"/></svg><?php if (zt_hours()) : ?><span><?php echo esc_html(zt_hours()); ?></span><?php else : ?><span class="font-mono text-xs"><?php echo esc_html(zt_ui('[Business hours]', '[Horaires d\'ouverture]')); ?></span><?php endif; ?></p>
        </address>
      </div>

      <div class="md:col-span-2 lg:hidden">
        <h3 class="sr-only"><?php echo esc_html(zt_t('nav_contact')); ?></h3>
        <div class="footer-actions">
          <a href="<?php echo esc_attr(zt_tel_href()); ?>" class="footer-action"><span class="footer-action-icon"><svg class="icon" aria-hidden="true"><use href="#i-call"/></svg></span><span><strong><?php echo esc_html(zt_ui('Call us', 'Appelez-nous')); ?></strong><small><?php echo esc_html(zt_mod('zt_phone')); ?></small></span></a>
          <a href="<?php echo esc_attr('mailto:' . antispambot(zt_mod('zt_email'))); ?>" class="footer-action"><span class="footer-action-icon"><svg class="icon" aria-hidden="true"><use href="#i-mail"/></svg></span><span><strong><?php echo esc_html(zt_ui('Email', 'E-mail')); ?></strong><small><?php echo esc_html(zt_ui('Send a message', 'Envoyer un message')); ?></small></span></a>
          <a href="<?php echo esc_url(zt_map_url()); ?>" class="footer-action" target="_blank" rel="noopener"><span class="footer-action-icon"><svg class="icon" aria-hidden="true"><use href="#i-pin"/></svg></span><span><strong><?php echo esc_html(zt_ui('Directions', 'Itinéraire')); ?></strong><small><?php echo esc_html(strtok(zt_mod('zt_address'), ',')); ?></small></span></a>
        </div>

        <div class="footer-accordions">
          <details class="footer-accordion">
            <summary><?php echo esc_html(zt_t('nav_services')); ?><span class="footer-plus" aria-hidden="true"></span></summary>
            <ul>
              <li><a href="<?php echo esc_url(zt_section_url('services')); ?>"><?php echo esc_html(zt_ui('Phone, tablet and computer repair', 'Réparation téléphone, tablette et ordinateur')); ?></a></li>
              <li><a href="<?php echo esc_url(zt_section_url('lab')); ?>"><?php echo esc_html(zt_ui('Micro-soldering and data recovery', 'Micro-soudure et récupération de données')); ?></a></li>
              <li><a href="<?php echo esc_url(zt_section_url('refurbished')); ?>"><?php echo esc_html(zt_ui('Refurbished devices', 'Appareils reconditionnés')); ?></a></li>
            </ul>
          </details>
          <details class="footer-accordion">
            <summary><?php echo esc_html(zt_ui('Explore', 'Explorer')); ?><span class="footer-plus" aria-hidden="true"></span></summary>
            <ul>
              <?php if ($zt_footer_menu) : ?>
                <?php foreach ($zt_footer_menu as $item) : ?>
                  <li><a<?php echo zt_menu_link_attrs($item, ''); ?>><?php echo esc_html($item->title); ?></a></li>
                <?php endforeach; ?>
              <?php else : ?>
                <li><a href="<?php echo esc_url(zt_section_url('why')); ?>"><?php echo esc_html(zt_t('nav_about')); ?></a></li>
                <li><a href="<?php echo esc_url(zt_section_url('process')); ?>"><?php echo esc_html(zt_t('nav_process')); ?></a></li>
                <li><a href="<?php echo esc_url(zt_section_url('faq')); ?>"><?php echo esc_html(zt_t('nav_faq')); ?></a></li>
                <li><a href="<?php echo esc_url(zt_section_url('booking')); ?>"><?php echo esc_html(zt_t('nav_book')); ?></a></li>
              <?php endif; ?>
            </ul>
          </details>
        </div>
        <p class="mt-5 flex items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-xs"><svg class="icon h-4 w-4 text-brand-400" aria-hidden="true"><use href="#i-clock"/></svg><span><?php echo esc_html(zt_hours() ?: zt_ui('[Business hours]', '[Horaires d\'ouverture]')); ?></span></p>
      </div>
    </div>

    <div class="border-t border-white/10">
      <div class="container-site flex flex-col gap-4 py-5 pb-[calc(6rem+env(safe-area-inset-bottom))] text-xs sm:pb-[calc(7rem+env(safe-area-inset-bottom))] lg:flex-row lg:items-center lg:justify-between lg:py-6">
        <p>© <span id="year"><?php echo esc_html(wp_date('Y')); ?></span> <?php echo esc_html(get_bloginfo('name', 'display')); ?>. <?php echo esc_html(zt_ui('All rights reserved.', 'Tous droits réservés.')); ?></p>
        <p class="max-w-xl text-white/50"><?php echo esc_html(zt_ui('Zafa Tech is an independent repair shop and is not affiliated with device manufacturers. Brand names belong to their respective owners.', 'Zafa Tech est un atelier de réparation indépendant et n\'est affilié à aucun fabricant. Les marques appartiennent à leurs propriétaires respectifs.')); ?></p>
        <ul class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:gap-x-5 sm:gap-y-2">
          <li><button type="button" class="min-h-10 text-left hover:text-white" data-legal="privacy"><?php echo esc_html(zt_ui('Privacy Policy', 'Politique de confidentialité')); ?></button></li>
          <li><button type="button" class="min-h-10 text-left hover:text-white" data-legal="terms"><?php echo esc_html(zt_ui('Terms of Service', 'Conditions d\'utilisation')); ?></button></li>
          <li><button type="button" class="min-h-10 text-left hover:text-white" data-legal="service"><?php echo esc_html(zt_ui('Service Policy', 'Politique de service')); ?></button></li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- Legal placeholder dialog -->
  <dialog id="legal-dialog" class="w-[min(92vw,560px)] rounded-3xl p-0 text-ink shadow-2xl backdrop:bg-navy-950/60 backdrop:backdrop-blur-sm" aria-labelledby="legal-title">
    <div class="p-6 sm:p-8">
      <div class="flex items-start justify-between gap-4">
        <h2 id="legal-title" class="text-2xl font-bold"><?php echo esc_html(zt_ui('Privacy Policy', 'Politique de confidentialité')); ?></h2>
        <button type="button" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-paper hover:bg-brand-50" data-close-dialog aria-label="<?php echo esc_attr(zt_ui('Close', 'Fermer')); ?>"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button>
      </div>
      <p id="legal-body" class="mt-4 text-muted"></p>
      <p class="mt-4 rounded-xl bg-crimson-50 p-4 font-mono text-sm text-crimson-600"><?php echo esc_html(zt_ui('[Placeholder — insert the final policy text before launch.]', '[Espace réservé — insérer le texte définitif avant la mise en ligne.]')); ?></p>
    </div>
  </dialog>

  <!-- Toast region -->
  <div id="toast-region" class="pointer-events-none fixed left-4 right-4 top-[calc(var(--header-h)+8px)] z-[60] flex flex-col items-end gap-3 sm:bottom-6 sm:left-auto sm:right-6 sm:top-auto sm:w-[380px]" aria-live="polite" aria-atomic="false"></div>

  <!-- Back to top -->
  <a href="#main" id="back-to-top" class="fixed bottom-24 right-4 z-30 inline-flex h-11 w-11 translate-y-4 items-center justify-center rounded-full bg-navy-900 text-white opacity-0 shadow-lift transition duration-300 hover:bg-brand-600 sm:bottom-28 sm:right-6 lg:bottom-5 lg:h-12 lg:w-12 [&.is-visible]:pointer-events-auto [&.is-visible]:translate-y-0 [&.is-visible]:opacity-100 pointer-events-none" aria-label="<?php echo esc_attr(zt_ui('Back to top', 'Retour en haut')); ?>">
    <svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-arrow-up"/></svg>
  </a>

  <?php wp_footer(); ?>
</body>
</html>
