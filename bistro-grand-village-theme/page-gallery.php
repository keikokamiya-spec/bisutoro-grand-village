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
        <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
        <?php bgv_render_gallery_stack_list($gallery_images); ?>
      </div>
    </article>
  </div>
</section>
<?php get_footer(); ?>
