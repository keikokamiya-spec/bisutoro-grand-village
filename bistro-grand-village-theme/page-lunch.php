<?php
/*
Template Name: ランチ
*/
get_header();
bgv_render_page_title('ランチ');
$has_lunch_acf = bgv_has_lunch_acf_values(get_the_ID());
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ($has_lunch_acf && bgv_render_lunch_sections(bgv_get_lunch_sections(get_the_ID()))) : ?>
        <?php else : ?>
          <?php echo bgv_static_default_content('category-lunch.html'); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
