<?php
/*
Template Name: 汎用ページ
*/
get_header();
$slug = bgv_current_slug();
$title = get_the_title();
$default_file = '';
$page_content = '';
if (have_posts()) {
  the_post();
  $page_content = get_the_content();
  rewind_posts();
}
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
          <?php bgv_render_gallery_stack_list(bgv_get_gallery_images(get_the_ID())); ?>
        </div>
      </article>
    <?php else : ?>
      <div class="row">
        <div class="span12">
          <article>
            <div class="single-page">
              <?php if ($default_file) : ?>
                <?php if (trim(wp_strip_all_tags($page_content)) !== '') : ?>
                  <?php echo apply_filters('the_content', $page_content); ?>
                <?php elseif ($default_file === 'category-lunch.html') : ?>
                  <?php bgv_render_lunch_pdf_text_menu(); ?>
                <?php else : ?>
                  <?php echo bgv_static_default_content($default_file); ?>
                <?php endif; ?>
              <?php elseif ($slug === 'interior-exterior') : ?>
                <?php bgv_render_interior_exterior_sections(get_the_ID()); ?>
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
