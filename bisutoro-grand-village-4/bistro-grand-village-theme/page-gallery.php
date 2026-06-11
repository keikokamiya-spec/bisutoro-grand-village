<?php
/*
Template Name: ギャラリー
*/
get_header();
bgv_render_page_title('Gallery');

$gallery_images = array();
$default_gallery_files = bgv_default_gallery_files();
for ($i = 1; $i <= count($default_gallery_files); $i++) {
  $image_id = bgv_get_field('gallery_image_' . $i, 0, get_the_ID());
  $default_file = $default_gallery_files[$i - 1];
  $default_alt = 'ギャラリー' . $i;

  if ($image_id && is_numeric($image_id)) {
    $gallery_images[] = array(
      'type' => 'attachment',
      'id' => (int) $image_id,
      'alt' => bgv_get_field('gallery_image_' . $i . '_alt', $default_alt, get_the_ID()),
    );
    continue;
  }

  $gallery_images[] = array(
    'type' => 'default',
    'url' => bgv_asset_uri('assets/images/auto_gal/' . rawurlencode($default_file)),
    'alt' => bgv_get_field('gallery_image_' . $i . '_alt', $default_alt, get_the_ID()),
  );
}
?>
<section id="main">
  <div class="container">
    <article>
      <div class="single-page pg-gal">
        <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
        <?php if (! empty($gallery_images)) : ?>
          <ul>
            <?php foreach ($gallery_images as $index => $image) : ?>
              <li<?php echo $index >= 12 ? ' class="lazy"' : ''; ?>>
                <?php if ($image['type'] === 'attachment') : ?>
                  <?php $full_url = wp_get_attachment_image_url($image['id'], 'full'); ?>
                  <?php if ($full_url) : ?>
                    <a href="<?php echo esc_url($full_url); ?>" class="gallery">
                      <?php echo wp_get_attachment_image($image['id'], 'large', false, array('alt' => esc_attr($image['alt']))); ?>
                    </a>
                  <?php endif; ?>
                <?php else : ?>
                  <a href="<?php echo esc_url($image['url']); ?>" class="gallery"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></a>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </article>
  </div>
</section>
<?php get_footer(); ?>
