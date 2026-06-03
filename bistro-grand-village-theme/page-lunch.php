<?php
/*
Template Name: ランチ
*/
get_header();
bgv_render_page_title('ランチ');
$has_acf_menu = bgv_has_acf_menu_sections(get_the_ID());
$sections = $has_acf_menu ? bgv_menu_from_acf(array(), get_the_ID()) : array();
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ($has_acf_menu) : ?>
          <?php bgv_render_menu_sections($sections, 'menu lunch-menu-list'); ?>
        <?php else : ?>
          <?php echo bgv_static_default_content('category-lunch.html'); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
