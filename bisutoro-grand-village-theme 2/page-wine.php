<?php
/*
Template Name: ワインリスト
*/
get_header();
bgv_render_page_title_image('ワインリスト', 'title-sign-wine-stylish.png');
$has_cpt_menu = bgv_has_visible_cpt_items('wine_menu');
$wine_categories = array(
  'red_wine' => '赤ワイン',
  'white_wine' => '白ワイン',
  'sparkling' => 'スパークリング',
  'other' => 'その他',
);
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php if ($has_cpt_menu) : ?>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_cpt_menu_items('wine_menu', 'menu', 'wine_category', $wine_categories); ?>
            <?php else : ?>
              <?php echo bgv_static_default_content('wine.html'); ?>
            <?php endif; ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
