<?php
get_header();
get_template_part('template-parts/page-title', null, array('title' => get_the_title()));
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <article>
            <div class="single-page">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

