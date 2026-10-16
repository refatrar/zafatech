  </main>

  <footer class="site-footer on-dark bg-navy-950 pt-10 text-white/70 sm:pt-12 lg:pt-16" aria-labelledby="footer-title">
    <h2 id="footer-title" class="sr-only">Zafa Tech — site footer</h2>
    <div class="container-site grid gap-8 pb-8 sm:gap-10 sm:pb-10 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr] lg:gap-12 lg:pb-12">
      <div class="md:col-span-2 lg:col-span-1">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2.5" aria-label="Zafa Tech — back to top">
          <svg class="h-11 w-11 text-brand-400" viewBox="0 0 64 64" fill="currentColor" aria-hidden="true"><use href="#i-fleur"/></svg>
          <span class="flex flex-col leading-none">
            <span class="font-brand text-2xl font-bold tracking-wide text-crimson-400">Z<span class="text-[1.2rem]">AFA</span>T<span class="text-[1.2rem]">ECH</span></span>
            <span class="mt-1 border-t border-white/30 pt-1 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-white/70"><?php echo esc_html(zt_t('site_tagline')); ?></span>
          </span>
        </a>
        <p class="mt-4 max-w-xl text-sm leading-relaxed lg:mt-5 lg:max-w-xs"><?php echo esc_html(zt_ui('Smartphone, computer and console repair, board-level micro-soldering and everyday tech services in Paris 6e.', 'Réparation de smartphones, ordinateurs et consoles, micro-soudure sur carte mère et services techniques du quotidien à Paris 6e.')); ?></p>
        <ul class="mt-5 flex gap-2 lg:mt-6" aria-label="Social media">
          <li><a href="#" data-placeholder-link="Instagram" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 transition hover:border-white/40 hover:text-white" aria-label="Instagram (coming soon)"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-instagram"/></svg></a></li>
          <li><a href="#" data-placeholder-link="Facebook" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 transition hover:border-white/40 hover:text-white" aria-label="Facebook (coming soon)"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-facebook"/></svg></a></li>
          <li><a href="#" data-placeholder-link="TikTok" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 transition hover:border-white/40 hover:text-white" aria-label="TikTok (coming soon)"><svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-tiktok"/></svg></a></li>
        </ul>
      </div>

      <nav class="hidden lg:block" aria-label="Footer services">
        <h3 class="font-sans text-sm font-semibold uppercase tracking-wider !text-white"><?php echo esc_html(zt_t('nav_services')); ?></h3>
        <ul class="mt-4 space-y-2.5 text-sm">
          <li><a class="hover:text-white" href="#services"><?php echo esc_html(zt_ui('Smartphone repair', 'Réparation de smartphone')); ?></a></li>
          <li><a class="hover:text-white" href="#services"><?php echo esc_html(zt_ui('Laptop and computer repair', 'Réparation d’ordinateur portable et de bureau')); ?></a></li>
          <li><a class="hover:text-white" href="#services"><?php echo esc_html(zt_ui('Tablet and console repair', 'Réparation de tablette et de console')); ?></a></li>
          <li><a class="hover:text-white" href="#lab"><?php echo esc_html(zt_ui('Micro-soldering', 'Micro-soudure')); ?></a></li>
          <li><a class="hover:text-white" href="#services"><?php echo esc_html(zt_ui('Data recovery', 'Récupération de données')); ?></a></li>
          <li><a class="hover:text-white" href="#refurbished"><?php echo esc_html(zt_ui('Refurbished devices', 'Appareils reconditionnés')); ?></a></li>
        </ul>
      </nav>

      <nav class="hidden lg:block" aria-label="Footer navigation">
        <h3 class="font-sans text-sm font-semibold uppercase tracking-wider !text-white"><?php echo esc_html(zt_ui('Navigate', 'Navigation')); ?></h3>
        <ul class="mt-4 space-y-2.5 text-sm">
          <li><a class="hover:text-white" href="#why"><?php echo esc_html(zt_t('nav_about')); ?></a></li>
          <li><a class="hover:text-white" href="#process"><?php echo esc_html(zt_t('nav_process')); ?></a></li>
          <li><a class="hover:text-white" href="#instore"><?php echo esc_html(zt_ui('In-store services', 'Services en boutique')); ?></a></li>
          <li><a class="hover:text-white" href="#faq"><?php echo esc_html(zt_t('nav_faq')); ?></a></li>
          <li><a class="hover:text-white" href="#booking"><?php echo esc_html(zt_t('nav_book')); ?></a></li>
        </ul>
      </nav>

      <div class="hidden lg:block">
        <h3 class="font-sans text-sm font-semibold uppercase tracking-wider !text-white"><?php echo esc_html(zt_t('nav_contact')); ?></h3>
        <address class="mt-4 space-y-3 text-sm not-italic">
          <p class="flex gap-2.5"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-pin"/></svg>18 Rue Littré, 75006 Paris</p>
          <p><a class="flex gap-2.5 hover:text-white" href="tel:+33753194003"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-call"/></svg>07 53 19 40 03</a></p>
          <p><a class="flex gap-2.5 break-all hover:text-white" href="mailto:zafatechparis@gmail.com"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-mail"/></svg>zafatechparis@gmail.com</a></p>
          <p class="flex gap-2.5"><svg class="icon h-5 w-5 text-brand-400" aria-hidden="true"><use href="#i-clock"/></svg><span class="font-mono text-xs"><?php echo esc_html(__('[Business hours]', 'zafatech')); ?></span></p>
        </address>
      </div>

      <div class="md:col-span-2 lg:hidden">
        <h3 class="sr-only"><?php echo esc_html(zt_t('nav_contact')); ?></h3>
        <div class="footer-actions">
          <a href="tel:+33753194003" class="footer-action"><span class="footer-action-icon"><svg class="icon" aria-hidden="true"><use href="#i-call"/></svg></span><span><strong><?php echo esc_html(zt_ui('Call us', 'Appelez-nous')); ?></strong><small>07 53 19 40 03</small></span></a>
          <a href="mailto:zafatechparis@gmail.com" class="footer-action"><span class="footer-action-icon"><svg class="icon" aria-hidden="true"><use href="#i-mail"/></svg></span><span><strong><?php echo esc_html(zt_ui('Email', 'E-mail')); ?></strong><small><?php echo esc_html(zt_ui('Send a message', 'Envoyer un message')); ?></small></span></a>
          <a href="https://www.google.com/maps/search/?api=1&amp;query=18+Rue+Littr%C3%A9%2C+75006+Paris" class="footer-action" target="_blank" rel="noopener"><span class="footer-action-icon"><svg class="icon" aria-hidden="true"><use href="#i-pin"/></svg></span><span><strong><?php echo esc_html(zt_ui('Directions', 'Itinéraire')); ?></strong><small>18 Rue Littré</small></span></a>
        </div>

        <div class="footer-accordions">
          <details class="footer-accordion">
            <summary><?php echo esc_html(zt_t('nav_services')); ?><span class="footer-plus" aria-hidden="true"></span></summary>
            <ul>
              <li><a href="#services"><?php echo esc_html(zt_ui('Phone, tablet and computer repair', 'Réparation téléphone, tablette et ordinateur')); ?></a></li>
              <li><a href="#lab"><?php echo esc_html(zt_ui('Micro-soldering and data recovery', 'Micro-soudure et récupération de données')); ?></a></li>
              <li><a href="#refurbished"><?php echo esc_html(zt_ui('Refurbished devices', 'Appareils reconditionnés')); ?></a></li>
            </ul>
          </details>
          <details class="footer-accordion">
            <summary><?php echo esc_html(zt_ui('Explore', 'Explorer')); ?><span class="footer-plus" aria-hidden="true"></span></summary>
            <ul>
              <li><a href="#why"><?php echo esc_html(zt_t('nav_about')); ?></a></li>
              <li><a href="#process"><?php echo esc_html(zt_t('nav_process')); ?></a></li>
              <li><a href="#faq"><?php echo esc_html(zt_t('nav_faq')); ?></a></li>
              <li><a href="#booking"><?php echo esc_html(zt_t('nav_book')); ?></a></li>
            </ul>
          </details>
        </div>
        <p class="mt-5 flex items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-xs"><svg class="icon h-4 w-4 text-brand-400" aria-hidden="true"><use href="#i-clock"/></svg><span><?php echo esc_html(__('[Business hours]', 'zafatech')); ?></span></p>
      </div>
    </div>

    <div class="border-t border-white/10">
      <div class="container-site flex flex-col gap-4 py-5 pb-[calc(6rem+env(safe-area-inset-bottom))] text-xs sm:pb-[calc(7rem+env(safe-area-inset-bottom))] lg:flex-row lg:items-center lg:justify-between lg:py-6">
        <p>© <span id="year"><?php echo esc_html(date('Y')); ?></span> Zafa Tech. <?php echo esc_html(zt_ui('All rights reserved.', 'Tous droits réservés.')); ?></p>
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
  <a href="#top" id="back-to-top" class="fixed bottom-24 right-4 z-30 inline-flex h-11 w-11 translate-y-4 items-center justify-center rounded-full bg-navy-900 text-white opacity-0 shadow-lift transition duration-300 hover:bg-brand-600 sm:bottom-28 sm:right-6 lg:bottom-5 lg:h-12 lg:w-12 [&.is-visible]:pointer-events-auto [&.is-visible]:translate-y-0 [&.is-visible]:opacity-100 pointer-events-none" aria-label="Back to top">
    <svg class="icon h-5 w-5" aria-hidden="true"><use href="#i-arrow-up"/></svg>
  </a>

  <?php wp_footer(); ?>
</body>
</html>
