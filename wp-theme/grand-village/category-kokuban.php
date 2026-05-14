<?php
get_header();
get_template_part('template-parts/page-title', null, array('title' => '黒板メニュー'));

$photos = new WP_Query(array(
    'post_type' => 'blackboard_photo',
    'posts_per_page' => -1,
    'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
));
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <p class="balloon">
          ご予算に応じてコース料理でお作りする事や<br class="sp_only">アラカルトメニューもご注文可能です。<br />お気軽にお問い合わせ下さい
        </p>
        <div class="kokuban-menu-images">
          <?php if ($photos->have_posts()) : ?>
            <?php while ($photos->have_posts()) : $photos->the_post(); ?>
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
              <?php endif; ?>
            <?php endwhile; wp_reset_postdata(); ?>
          <?php else : ?>
            <img width="384" height="288" src="<?php echo gv_asset('kokubann1.jpeg'); ?>" alt="黒板メニュー" decoding="async" fetchpriority="high" />
            <img width="384" height="288" src="<?php echo gv_asset('okuban2.jpeg'); ?>" alt="黒板メニュー" decoding="async" loading="lazy" />
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

