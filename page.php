<?php get_header(); ?>

<section id="pagetitle">
  <h1><?php echo esc_html(bgv_page_title()); ?></h1>
</section>

<section id="breadcrumb">
  <div class="container">
    <ul>
      <li><a href="<?php echo esc_url(home_url('/')); ?>" class="home">HOME</a></li>
      <li><span class="fa fa-caret-right"></span><span><?php echo esc_html(bgv_page_title()); ?></span></li>
    </ul>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page wp-editable-content">
            <?php
            while (have_posts()) :
              the_post();
              the_content();
            endwhile;
            ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
