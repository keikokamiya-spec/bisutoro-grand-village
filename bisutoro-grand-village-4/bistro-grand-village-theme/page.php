<?php
/*
Template Name: 汎用ページ
*/
get_header();
$slug = bgv_current_slug();
$title = get_the_title();
$default_file = '';
if ($slug === 'dinner') {
  $title = 'Food Menu';
  $default_file = 'food.html';
} elseif ($slug === 'lunch' || $slug === 'category-lunch') {
  $title = 'ランチ';
  $default_file = 'category-lunch.html';
} elseif ($slug === 'gallery') {
  $title = 'Gallery';
} elseif ($slug === 'interior-exterior') {
  $title = 'Interior & Exterior';
} elseif ($slug === 'blog') {
  $title = 'ブログ';
  $default_file = 'category-blog.html';
} elseif ($slug === 'information') {
  $title = 'お知らせ';
  $default_file = 'category-information.html';
} elseif ($slug === 'archives-1175') {
  $title = 'アーカイブ';
  $default_file = 'archives-1175.html';
}
bgv_render_page_title($title);
?>
<section id="main">
  <div class="container">
    <?php if ($slug === 'gallery') : ?>
      <article>
        <div class="single-page pg-gal">
          <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
          <ul>
            <?php
            $gallery_images = glob(bgv_asset_path('assets/images/auto_gal/*.{jpg,jpeg,JPG,JPEG,png,PNG}'), GLOB_BRACE);
            if (! is_array($gallery_images)) {
              $gallery_images = array();
            }
            sort($gallery_images, SORT_NATURAL | SORT_FLAG_CASE);
            foreach ($gallery_images as $index => $image_path) :
              $file = basename($image_path);
              $url = bgv_asset_uri('assets/images/auto_gal/' . rawurlencode($file));
              ?>
              <li<?php echo $index >= 12 ? ' class="lazy"' : ''; ?>><a href="<?php echo esc_url($url); ?>" class="gallery"><img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr('ギャラリー' . ($index + 1)); ?>" /></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </article>
    <?php else : ?>
      <div class="row">
        <div class="span12">
          <article>
            <div class="single-page">
              <?php if ($default_file) : ?>
                <?php if ($default_file === 'category-lunch.html') : ?>
                  <?php bgv_render_lunch_pdf_text_menu(); ?>
                <?php else : ?>
                  <?php echo bgv_static_default_content($default_file); ?>
                <?php endif; ?>
              <?php elseif ($slug === 'interior-exterior') : ?>
                <div class="photos interior-exterior-photos">
                  <section class="photos-section">
                    <h2 class="photos-section-title">外観<span>Exterior</span></h2>
                    <div class="photos-slider">
                      <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/gai1.jpg'); ?>" alt="外観１" /></figure>
                      <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/gai2.jpg'); ?>" alt="外観２" /></figure>
                    </div>
                  </section>
                  <section class="photos-section">
                    <h2 class="photos-section-title">内観<span>Interior</span></h2>
                    <div class="photos-slider">
                      <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai1.jpg'); ?>" alt="内観１" /></figure>
                      <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai2.jpg'); ?>" alt="内観２" /></figure>
                      <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai3.jpg'); ?>" alt="内観３" /></figure>
                      <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai4.jpg'); ?>" alt="内観４" /></figure>
                    </div>
                  </section>
                </div>
              <?php else : ?>
                <?php
                while (have_posts()) :
                  the_post();
                  the_content();
                endwhile;
                ?>
              <?php endif; ?>
            </div>
          </article>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
