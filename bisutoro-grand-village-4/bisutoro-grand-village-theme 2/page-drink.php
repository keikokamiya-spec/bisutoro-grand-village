<?php
/*
Template Name: ドリンク
*/
get_header();
bgv_render_page_title('Drink Menu');
$has_cpt_menu = bgv_has_visible_cpt_items('drink_menu');
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
            <?php if ($has_cpt_menu) : ?>
              <p align="right">※全て税込み価格になります。</p>
              <?php bgv_render_cpt_menu_items('drink_menu', 'menu', 'drink_category', $drink_categories); ?>
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
