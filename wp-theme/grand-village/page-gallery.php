<?php
/*
Template Name: ギャラリー
*/
get_header();
get_template_part('template-parts/page-title', null, array('title' => 'Gallery'));

$photos = new WP_Query(array(
    'post_type' => 'gallery_photo',
    'posts_per_page' => -1,
    'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
));
?>
<section id="main">
  <div class="container">
    <article>
      <div class="single-page pg-gal">
        <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
        <ul>
          <?php if ($photos->have_posts()) : ?>
            <?php while ($photos->have_posts()) : $photos->the_post(); ?>
              <?php
              $full = get_the_post_thumbnail_url(get_the_ID(), 'full');
              $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
              if (!$full || !$thumb) {
                  continue;
              }
              ?>
              <li>
                <a href="<?php echo esc_url($full); ?>" class="gallery">
                  <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                </a>
              </li>
            <?php endwhile; wp_reset_postdata(); ?>
          <?php else : ?>
            <li><a href="<?php echo gv_asset('images/auto_gal/01.jpg'); ?>" class="gallery"><img src="<?php echo gv_asset('images/auto_gal/01.jpg'); ?>" alt="ギャラリー1" /></a></li>
            <li><a href="<?php echo gv_asset('images/auto_gal/02.jpg'); ?>" class="gallery"><img src="<?php echo gv_asset('images/auto_gal/02.jpg'); ?>" alt="ギャラリー2" /></a></li>
            <li><a href="<?php echo gv_asset('images/auto_gal/03.jpg'); ?>" class="gallery"><img src="<?php echo gv_asset('images/auto_gal/03.jpg'); ?>" alt="ギャラリー3" /></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </article>
  </div>
</section>
<?php get_footer(); ?>

