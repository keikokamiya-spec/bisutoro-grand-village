<div class="row">
  <div class="js-masonry">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <div class="span4 item">
          <div class="posts">
            <a href="<?php the_permalink(); ?>" class="mouseonfade">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
              <?php endif; ?>
            </a>
            <p class="date"><?php echo esc_html(get_the_date('Y年n月j日（D）')); ?></p>
            <p class="icons"><?php the_category(' '); ?></p>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else : ?>
      <p>記事がありません。</p>
    <?php endif; ?>
  </div>
</div>
<?php the_posts_pagination(array('mid_size' => 2, 'prev_text' => '«', 'next_text' => '»')); ?>

