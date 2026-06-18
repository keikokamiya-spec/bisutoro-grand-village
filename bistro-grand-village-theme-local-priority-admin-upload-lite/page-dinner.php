<?php
/*
Template Name: ディナーメニュー
*/
get_header();
bgv_render_sign_page_title('dinner');
$has_acf_menu = bgv_has_page_menu_items('dinner', get_the_ID());
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php if ($has_acf_menu) : ?>
              <p class="balloon">ご予算に応じて<br class="sp_only">コース料理でお作りする事も可能です。<br />お気軽にお問い合わせ下さい</p>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_page_acf_menu_items('dinner', 'menu', array(), get_the_ID()); ?>
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
