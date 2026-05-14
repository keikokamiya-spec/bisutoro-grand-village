<?php
get_header();
?>
<section id="pagetitle">
  <p><?php echo esc_html(gv_post_title_label()); ?></p>
</section>
<section id="breadcrumb">
  <div class="container">
    <ul>
      <li><a href="<?php echo esc_url(home_url('/')); ?>" class="home"><span>HOME</span></a></li>
      <?php
      $category = get_the_category();
      if ($category) :
          $primary = $category[0];
      ?>
        <li><span class="fa fa-caret-right"></span><a href="<?php echo esc_url(get_category_link($primary)); ?>"><span><?php echo esc_html($primary->name); ?></span></a></li>
      <?php endif; ?>
      <li><span class="fa fa-caret-right"></span><span><?php the_title(); ?></span></li>
    </ul>
  </div>
</section>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span8">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <article class="single-post">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', array('class' => 'thumb')); ?>
            <?php endif; ?>
            <p class="date"><?php echo esc_html(get_the_date('Y年n月j日（D）')); ?></p>
            <p class="icons"><?php the_category(' '); ?></p>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="single-post-content">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile; endif; ?>
      </div>
      <?php get_template_part('template-parts/sidebar'); ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>
