<?php
/*
Template Name: ドリンク
*/
get_header();
bgv_render_page_title('Drink Menu');
$has_acf_menu = bgv_has_page_menu_items('drink', get_the_ID());
$acf_menu_count = count(bgv_get_page_menu_items('drink', get_the_ID()));
$drink_categories = array(
  'beer' => 'ビール',
  'wine' => 'ワイン',
  'cocktail' => 'カクテル',
  'soft_drink' => 'ソフトドリンク',
  'other' => 'その他',
);
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php if ($has_acf_menu && $acf_menu_count >= 30) : ?>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_page_acf_menu_items('drink', 'menu', $drink_categories, get_the_ID()); ?>
            <?php else : ?>
              <?php echo bgv_static_default_content('drink.html'); ?>
            <?php endif; ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
