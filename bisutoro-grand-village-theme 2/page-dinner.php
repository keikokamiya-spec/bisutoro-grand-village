<?php
/*
Template Name: ディナーメニュー
*/
get_header();
bgv_render_page_title('Food Menu');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php echo bgv_static_default_content('food.html'); ?>
            <?php bgv_render_linked_food_items(); ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

