<?php
/*
Template Name: お子様セット
*/
get_header();
bgv_render_page_title('Kids Menu');
$has_cpt_menu = bgv_has_visible_cpt_items('kids_menu');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php if ($has_cpt_menu) : ?>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_cpt_menu_items('kids_menu'); ?>
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
