<?php
get_header();
get_template_part('template-parts/page-title', null, array('title' => gv_category_label()));
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php get_template_part('template-parts/post-list'); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

