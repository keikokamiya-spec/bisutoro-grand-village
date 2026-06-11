<?php
/*
Template Name: お子様セット
*/
get_header();
bgv_render_page_title('Kids Menu');
$has_acf_menu = bgv_has_page_menu_items('kids', get_the_ID());
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
              <?php if ($has_acf_menu) : ?>
                <p align="right">※全て税込み価格になります。</p>
                <?php bgv_render_page_acf_menu_items('kids', 'menu', array(), get_the_ID()); ?>
                <?php bgv_render_kids_soft_drink_note(); ?>
              <?php else : ?>
                <?php echo bgv_static_default_content('kids.html'); ?>
              <?php endif; ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
