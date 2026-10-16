<?php
get_header();
?>
<section class="section">
  <div class="container-site">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="card p-6 mb-6">
        <h2 class="text-2xl font-bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="mt-2 text-muted"><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; else : ?>
      <p><?php echo esc_html(zt_ui('No content found.', 'Aucun contenu trouvé.')); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
