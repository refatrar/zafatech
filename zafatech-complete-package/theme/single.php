<?php get_header(); ?>
<section class="section"><div class="container-site max-w-3xl">
<?php while (have_posts()) : the_post(); ?>
  <h1 class="h-section"><?php the_title(); ?></h1>
  <div class="prose mt-6"><?php the_content(); ?></div>
<?php endwhile; ?>
</div></section>
<?php get_footer(); ?>
