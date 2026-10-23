<?php get_header(); ?>
<section class="section"><div class="container-site">
  <h1 class="h-section"><?php echo esc_html(sprintf(zt_ui('Search: %s', 'Recherche : %s'), get_search_query())); ?></h1>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="card p-6 mb-6"><h2 class="text-xl font-bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article>
  <?php endwhile; ?>
  <?php the_posts_pagination(array('mid_size' => 1, 'prev_text' => esc_html(zt_ui('Previous', 'Précédent')), 'next_text' => esc_html(zt_ui('Next', 'Suivant')), 'screen_reader_text' => zt_ui('Posts navigation', 'Navigation des articles'))); ?>
  <?php else : ?><p><?php echo esc_html(zt_ui('No results.', 'Aucun résultat.')); ?></p><?php endif; ?>
</div></section>
<?php get_footer(); ?>
