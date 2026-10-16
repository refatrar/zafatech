<?php get_header(); ?>
<section class="section"><div class="container-site">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article class="card p-6 mb-6"><h2 class="text-xl font-bold"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article>
<?php endwhile; endif; ?>
</div></section>
<?php get_footer(); ?>
