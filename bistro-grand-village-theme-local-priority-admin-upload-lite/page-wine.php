<?php
/*
Template Name: ワインリスト
*/
get_header();
bgv_render_sign_page_title('wine');
$has_acf_menu = bgv_has_page_menu_items('wine', get_the_ID());
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
            <?php if ($has_acf_menu) : ?>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_page_acf_menu_items('wine', 'menu', $wine_categories, get_the_ID()); ?>
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
