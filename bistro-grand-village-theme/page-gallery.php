<?php
/*
Template Name: ギャラリー
*/
get_header();
bgv_render_page_title('Gallery');
$gallery_images = bgv_get_gallery_images(get_the_ID());
?>
<section id="main">
  <div class="container">
    <article>
      <div class="single-page pg-gal">
        <?php if (! empty($gallery_images)) : ?>
          <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
          <?php bgv_render_gallery_stack_list($gallery_images); ?>
        <?php else : ?>
          <p>ギャラリー画像は管理画面のACFから登録できます。</p>
        <?php endif; ?>
      </div>
    </article>
  </div>
</section>
<?php get_footer(); ?>
