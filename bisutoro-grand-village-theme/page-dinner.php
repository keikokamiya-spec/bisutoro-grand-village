<?php
/*
Template Name: ディナーメニュー
*/
get_header();
bgv_render_page_title('Food Menu');
$has_cpt_menu = bgv_has_visible_cpt_items('dinner_menu');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php if ($has_cpt_menu) : ?>
              <p class="balloon">ご予算に応じて<br class="sp_only">コース料理でお作りする事も可能です。<br />お気軽にお問い合わせ下さい</p>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_cpt_menu_items('dinner_menu'); ?>
            <?php else : ?>
              <?php echo bgv_static_default_content('food.html'); ?>
            <?php endif; ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
