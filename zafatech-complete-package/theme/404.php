<?php get_header(); ?>
<section class="section"><div class="container-site text-center">
  <h1 class="h-section">404</h1>
  <p class="lead mt-3"><?php echo esc_html(zt_ui('Page not found.', 'Page introuvable.')); ?></p>
  <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary mt-6"><?php echo esc_html(zt_ui('Back home', 'Retour à l\'accueil')); ?></a>
</div></section>
<?php get_footer(); ?>
