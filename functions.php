<?php

function bgv_asset($path) {
  return esc_url(get_template_directory_uri() . '/' . ltrim($path, '/'));
}

function bgv_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'bgv_setup');

function bgv_enqueue_assets() {
  $theme = wp_get_theme();

  wp_enqueue_style('bgv-font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '1.0.0');
  wp_enqueue_style('bgv-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '1.0.0');
  wp_enqueue_style('bgv-bootstrap-responsive', get_template_directory_uri() . '/css/bootstrap-responsive.css', array('bgv-bootstrap'), '1.0.0');
  wp_enqueue_style('bgv-flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '1.0.0');
  wp_enqueue_style('bgv-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.0.0');
  wp_enqueue_style('bgv-style-static', get_template_directory_uri() . '/css/style.css', array(), '1.0.0');
  wp_enqueue_style('bgv-base', get_template_directory_uri() . '/css/base.css', array('bgv-style-static'), '1.0.0');
  wp_enqueue_style('bgv-theme', get_stylesheet_uri(), array('bgv-base'), $theme->get('Version'));

  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '1.12.4', true);
  wp_enqueue_script('bgv-bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('bgv-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('bgv-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('bgv-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'), '1.0.0', true);
  wp_enqueue_script('bgv-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'bgv_enqueue_assets');

function bgv_head_tags() {
  ?>
  <link rel="shortcut icon" href="<?php echo bgv_asset('favicon.ico'); ?>" />
  <link rel="icon" href="<?php echo bgv_asset('favicon.ico'); ?>" />
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-5XM011MNR4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-5XM011MNR4');
  </script>
  <?php
}
add_action('wp_head', 'bgv_head_tags', 5);

function bgv_nav_items() {
  return array(
    array('label' => '黒板メニュー', 'slug' => 'category-kokuban'),
    array('label' => 'ランチ', 'slug' => 'category-lunch'),
    array('label' => 'ディナー', 'slug' => 'food'),
    array('label' => 'お子様セット', 'slug' => 'kids'),
    array('label' => 'ドリンク', 'slug' => 'drink'),
    array('label' => 'ワインリスト', 'slug' => 'wine'),
    array('label' => '内観＆外観', 'slug' => 'interior-exterior'),
    array('label' => 'ギャラリー', 'slug' => 'gallery'),
    array('label' => '営業時間＆アクセス', 'slug' => '#home_access'),
  );
}

function bgv_page_url($slug) {
  if ($slug === '#home_access') {
    return esc_url(home_url('/#home_access'));
  }

  $page = get_page_by_path($slug);
  if ($page) {
    return esc_url(get_permalink($page));
  }

  return esc_url(home_url('/' . trim($slug, '/') . '/'));
}

function bgv_is_active_slug($slug) {
  if ($slug === '#home_access') {
    return false;
  }

  return is_page($slug);
}

function bgv_transform_static_content($content) {
  $theme_uri = get_template_directory_uri();
  $content = preg_replace('/\s+align="right"/i', '', $content);
  $content = preg_replace('/\s+style="text-align:\s*right;?"/i', '', $content);
  $content = str_replace(array('src="images/', 'href="images/'), array('src="' . esc_url($theme_uri) . '/images/', 'href="' . esc_url($theme_uri) . '/images/'), $content);
  $content = str_replace('href="https://grand-village.yokohama/archives/52"', 'href="' . esc_url(home_url('/archives/52/')) . '"', $content);

  return trim($content);
}

function bgv_update_kokuban_images() {
  if (get_option('bgv_kokuban_images_v2')) {
    return;
  }

  $page = get_page_by_path('category-kokuban');
  if (! $page) {
    update_option('bgv_kokuban_images_v2', 1);
    return;
  }

  $theme_uri = get_template_directory_uri();
  $new_first = esc_url($theme_uri . '/images/assets/kokuban-menu-1.png');
  $new_second = esc_url($theme_uri . '/images/assets/kokuban-menu-2.png');
  $content = $page->post_content;
  $content = preg_replace('/<img[^>]+src="[^"]*kokubann1\.jpeg"[^>]*>/u', '<img width="945" height="705" src="' . $new_first . '" alt="黒板メニュー" decoding="async" fetchpriority="high" />', $content);
  $content = preg_replace('/<img[^>]+src="[^"]*okuban2\.jpeg"[^>]*>/u', '<img width="934" height="698" src="' . $new_second . '" alt="黒板メニュー" decoding="async" loading="lazy" />', $content);

  if ($content !== $page->post_content) {
    wp_update_post(array(
      'ID' => $page->ID,
      'post_content' => $content,
    ));
  }

  update_option('bgv_kokuban_images_v2', 1);
}
add_action('init', 'bgv_update_kokuban_images');

function bgv_extract_static_main_content($file) {
  $path = get_template_directory() . '/' . $file;
  if (! file_exists($path)) {
    return '';
  }

  $html = file_get_contents($path);
  if (preg_match('/<div class="single-page[^"]*">\s*(.*?)\s*<\/div><!--\/\.single-page-->/s', $html, $matches)) {
    return bgv_transform_static_content($matches[1]);
  }

  if (preg_match('/<div class="span12">\s*(.*?)\s*<\/div><!--\/\.span12-->/s', $html, $matches)) {
    return bgv_transform_static_content($matches[1]);
  }

  return '';
}

function bgv_seed_editable_pages() {
  if (get_option('bgv_seeded_pages_v1')) {
    return;
  }

  $pages = array(
    array('title' => '黒板メニュー', 'slug' => 'category-kokuban', 'file' => 'category-kokuban.html'),
    array('title' => 'ランチ', 'slug' => 'category-lunch', 'file' => 'category-lunch.html'),
    array('title' => 'ディナーメニュー', 'slug' => 'food', 'file' => 'food.html'),
    array('title' => 'お子様セット', 'slug' => 'kids', 'file' => 'kids.html'),
    array('title' => 'ドリンク', 'slug' => 'drink', 'file' => 'drink.html'),
    array('title' => 'ワインリスト', 'slug' => 'wine', 'file' => 'wine.html'),
    array('title' => '内観＆外観', 'slug' => 'interior-exterior', 'file' => 'interior-exterior.html'),
  );

  foreach ($pages as $page) {
    if (get_page_by_path($page['slug'])) {
      continue;
    }

    wp_insert_post(array(
      'post_title' => $page['title'],
      'post_name' => $page['slug'],
      'post_type' => 'page',
      'post_status' => 'publish',
      'post_content' => bgv_extract_static_main_content($page['file']),
    ));
  }

  $gallery = get_page_by_path('gallery');
  if (! $gallery) {
    $gallery_id = wp_insert_post(array(
      'post_title' => 'ギャラリー',
      'post_name' => 'gallery',
      'post_type' => 'page',
      'post_status' => 'publish',
      'post_content' => '',
    ));

    if ($gallery_id && ! is_wp_error($gallery_id)) {
      update_post_meta($gallery_id, '_wp_page_template', 'template-gallery.php');
    }
  } else {
    update_post_meta($gallery->ID, '_wp_page_template', 'template-gallery.php');
  }

  update_option('bgv_seeded_pages_v1', 1);
}
add_action('after_switch_theme', 'bgv_seed_editable_pages');

function bgv_page_title() {
  if (is_front_page()) {
    return '';
  }

  if (is_page()) {
    return get_the_title();
  }

  return single_post_title('', false);
}
