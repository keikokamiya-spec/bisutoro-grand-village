<?php
/*
Template Name: ギャラリー（固定）
*/
get_header();

$gallery_dir = get_template_directory() . '/images/auto_gal';
$gallery_uri = get_template_directory_uri() . '/images/auto_gal';
$images = glob($gallery_dir . '/*.{jpg,jpeg,JPG,JPEG,png,PNG}', GLOB_BRACE);
if (! is_array($images)) {
  $images = array();
}
sort($images, SORT_NATURAL | SORT_FLAG_CASE);
?>

<section id="pagetitle">
  <h1>Gallery</h1>
</section>

<section id="breadcrumb">
  <div class="container">
    <ul>
      <li><a href="<?php echo esc_url(home_url('/')); ?>" class="home">HOME</a></li>
      <li><span class="fa fa-caret-right"></span><span>Gallery</span></li>
    </ul>
  </div>
</section>

<section id="main">
  <div class="container">
    <article>
      <div class="single-page pg-gal">
        <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
        <ul>
          <?php foreach ($images as $index => $image_path) : ?>
            <?php
            $filename = basename($image_path);
            $url = esc_url($gallery_uri . '/' . rawurlencode($filename));
            ?>
            <li<?php echo $index >= 12 ? ' class="lazy"' : ''; ?>><a href="<?php echo $url; ?>" class="gallery"><img src="<?php echo $url; ?>" alt="<?php echo esc_attr('ギャラリー' . ($index + 1)); ?>" /></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </article>
  </div>
</section>

<?php get_footer(); ?>
