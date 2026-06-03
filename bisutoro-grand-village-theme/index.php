<?php get_header(); ?>
<section id="main">
  <div class="container">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <article>
          <div class="single-page">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>

