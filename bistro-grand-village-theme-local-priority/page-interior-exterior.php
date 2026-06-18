<?php
/*
Template Name: 内観＆外観
*/
get_header();
bgv_render_page_title('Interior & Exterior');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <?php bgv_render_interior_exterior_sections(get_the_ID()); ?>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
