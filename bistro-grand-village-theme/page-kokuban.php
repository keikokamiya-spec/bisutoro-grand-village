<?php
/*
Template Name: 黒板メニュー
*/
get_header();
bgv_render_page_title('黒板メニュー');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <p class="balloon">
          ご予算に応じてコース料理でお作りする事や<br class="sp_only">アラカルトメニューもご注文可能です。<br />お気軽にお問い合わせ下さい
        </p>
        <?php get_template_part('template-parts/blackboard-images'); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

