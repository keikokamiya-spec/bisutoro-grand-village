<?php
/*
Template Name: ランチ
*/
get_header();
bgv_render_page_title('ランチ');
$has_cpt_menu = bgv_has_visible_cpt_items('lunch_menu');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ($has_cpt_menu) : ?>
          <?php bgv_render_cpt_menu_items('lunch_menu', 'menu lunch-menu-list'); ?>
        <?php else : ?>
          <?php echo bgv_static_default_content('category-lunch.html'); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
