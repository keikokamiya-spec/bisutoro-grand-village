<?php get_header(); ?>

<section id="pagetitle">
  <h1><?php bloginfo('name'); ?></h1>
</section>

<section id="main">
  <div class="container">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <article>
          <div class="single-page wp-editable-content">
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
