<?php
/*
Template Name: 黒板メニュー
*/
get_header();
$heading = bgv_get_field('blackboard_heading', '黒板メニュー', get_the_ID());
$description = bgv_get_field('blackboard_description', "ご予算に応じてコース料理でお作りする事や\nアラカルトメニューもご注文可能です。\nお気軽にお問い合わせ下さい", get_the_ID());
bgv_render_sign_page_title('kokuban', $heading ?: '黒板メニュー');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ($description) : ?>
          <p class="balloon"><?php echo wp_kses_post(nl2br($description)); ?></p>
        <?php endif; ?>
        <?php get_template_part('template-parts/blackboard-images'); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
