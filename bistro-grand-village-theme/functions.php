<?php

if (! defined('ABSPATH')) {
  exit;
}

define('BGV_THEME_VERSION', '2.5');

require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/acf-fields.php';

function bgv_asset_uri($path = '') {
  return esc_url(get_template_directory_uri() . '/' . ltrim($path, '/'));
}

function bgv_asset_path($path = '') {
  return get_template_directory() . '/' . ltrim($path, '/');
}

function bgv_asset_exists($path = '') {
  $asset_path = bgv_asset_path($path);
  return $path !== '' && file_exists($asset_path);
}

function bgv_asset_uri_if_exists($path = '') {
  return bgv_asset_exists($path) ? bgv_asset_uri($path) : '';
}

function bgv_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'primary' => 'ヘッダーナビゲーション',
  ));
}
add_action('after_setup_theme', 'bgv_setup');

function bgv_enqueue_assets() {
  wp_enqueue_style('bgv-fonts', 'https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600;700&family=Poppins:wght@400;500;600&display=swap', array(), null);
  wp_enqueue_style('bgv-style', bgv_asset_uri('assets/css/style.css'), array(), BGV_THEME_VERSION);
  wp_enqueue_script('jquery');
  wp_enqueue_script('bgv-bootstrap', bgv_asset_uri('assets/js/bootstrap.js'), array('jquery'), BGV_THEME_VERSION, true);
  wp_enqueue_script('bgv-flexslider', bgv_asset_uri('assets/js/jquery.flexslider.js'), array('jquery'), BGV_THEME_VERSION, true);
  wp_enqueue_script('bgv-magnific-popup', bgv_asset_uri('assets/js/jquery.magnific-popup.js'), array('jquery'), BGV_THEME_VERSION, true);
  wp_enqueue_script('bgv-masonry', bgv_asset_uri('assets/js/masonry.pkgd.min.js'), array('jquery'), BGV_THEME_VERSION, true);
  wp_enqueue_script('bgv-main', bgv_asset_uri('assets/js/main.js'), array('jquery', 'bgv-bootstrap', 'bgv-flexslider', 'bgv-magnific-popup', 'bgv-masonry'), BGV_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'bgv_enqueue_assets');

function bgv_head_assets() {
  ?>
  <link rel="shortcut icon" href="<?php echo bgv_asset_uri('assets/images/favicon.ico'); ?>" />
  <link rel="icon" href="<?php echo bgv_asset_uri('assets/images/favicon.ico'); ?>" />
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-5XM011MNR4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-5XM011MNR4');
  </script>
  <?php
}
add_action('wp_head', 'bgv_head_assets', 5);

function bgv_filter_nav_menu_objects($items) {
  if (! is_array($items)) {
    return $items;
  }

  foreach ($items as $item) {
    if (! isset($item->url)) {
      continue;
    }

    $slug = '';
    if (isset($item->object) && $item->object === 'page' && ! empty($item->object_id)) {
      $post = get_post((int) $item->object_id);
      if ($post instanceof WP_Post) {
        $slug = $post->post_name;
      }
    }

    if ($slug === '' && ! empty($item->url)) {
      $path = wp_parse_url($item->url, PHP_URL_PATH);
      if (is_string($path) && $path !== '') {
        $slug = basename(untrailingslashit($path));
      }
    }

    if (bgv_is_home_section_slug($slug)) {
      $item->url = bgv_home_section_url($slug);
    }
  }

  return $items;
}
add_filter('wp_nav_menu_objects', 'bgv_filter_nav_menu_objects');

function bgv_nav_items() {
  return array(
    array('label' => '黒板メニュー', 'slug' => 'kokuban'),
    array('label' => 'ランチ', 'slug' => 'lunch'),
    array('label' => 'ディナー', 'slug' => 'dinner'),
    array('label' => 'お子様セット', 'slug' => 'kids'),
    array('label' => 'ドリンク', 'slug' => 'drink'),
    array('label' => 'ワインリスト', 'slug' => 'wine'),
    array('label' => '内観＆外観', 'slug' => 'interior-exterior'),
    array('label' => 'ギャラリー', 'slug' => 'gallery'),
    array('label' => '営業時間＆アクセス', 'slug' => 'access'),
  );
}

function bgv_home_section_anchor($slug) {
  $anchors = array(
    'interior-exterior' => 'home_interior_exterior',
    'gallery' => 'home_gallery',
  );

  return isset($anchors[$slug]) ? $anchors[$slug] : '';
}

function bgv_is_home_section_slug($slug) {
  return bgv_home_section_anchor($slug) !== '';
}

function bgv_home_section_url($slug) {
  $anchor = bgv_home_section_anchor($slug);
  return $anchor ? home_url('/#' . $anchor) : home_url('/');
}

function bgv_page_link($slug) {
  if (bgv_is_home_section_slug($slug)) {
    return bgv_home_section_url($slug);
  }

  $page = get_page_by_path($slug);
  return $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');
}

function bgv_html_page_map() {
  return array(
    'index.html' => array('slug' => 'home', 'title' => 'トップページ', 'template' => 'front-page.php'),
    'category-kokuban.html' => array('slug' => 'kokuban', 'title' => '黒板メニュー', 'template' => 'page-kokuban.php'),
    'category-lunch.html' => array('slug' => 'lunch', 'title' => 'ランチ', 'template' => 'page-lunch.php'),
    'food.html' => array('slug' => 'dinner', 'title' => 'ディナー', 'template' => 'page-dinner.php'),
    'kids.html' => array('slug' => 'kids', 'title' => 'お子様セット', 'template' => 'page-kids.php'),
    'drink.html' => array('slug' => 'drink', 'title' => 'ドリンク', 'template' => 'page-drink.php'),
    'wine.html' => array('slug' => 'wine', 'title' => 'ワインリスト', 'template' => 'page-wine.php'),
    'interior-exterior.html' => array('slug' => 'interior-exterior', 'title' => '内観＆外観', 'template' => 'page-interior-exterior.php'),
    'gallery.html' => array('slug' => 'gallery', 'title' => 'ギャラリー', 'template' => 'page-gallery.php'),
    'category-blog.html' => array('slug' => 'blog', 'title' => 'ブログ', 'template' => 'page.php'),
    'category-information.html' => array('slug' => 'information', 'title' => 'お知らせ', 'template' => 'page.php'),
    'archives-1175.html' => array('slug' => 'archives-1175', 'title' => 'アーカイブ', 'template' => 'page.php'),
  );
}

function bgv_rewrite_static_links($content) {
  $map = bgv_html_page_map();
  foreach ($map as $html_file => $page) {
    $content = str_replace(
      array('href="' . $html_file . '"', "href='" . $html_file . "'"),
      array('href="' . esc_url(bgv_page_link($page['slug'])) . '"', "href='" . esc_url(bgv_page_link($page['slug'])) . "'"),
      $content
    );
  }

  return $content;
}

function bgv_current_slug() {
  if (is_page()) {
    $post = get_post();
    return $post ? $post->post_name : '';
  }
  return '';
}

function bgv_redirect_legacy_section_pages() {
  if (! is_page()) {
    return;
  }

  $slug = bgv_current_slug();
  if (! bgv_is_home_section_slug($slug)) {
    return;
  }

  wp_safe_redirect(bgv_home_section_url($slug), 301);
  exit;
}
add_action('template_redirect', 'bgv_redirect_legacy_section_pages');

function bgv_fallback_navigation() {
  echo '<ul class="header_menu">';
  foreach (bgv_nav_items() as $item) {
    $active = bgv_current_slug() === $item['slug'] ? ' class="active"' : '';
    echo '<li' . $active . '><a href="' . esc_url(bgv_page_link($item['slug'])) . '">' . esc_html($item['label']) . '</a></li>';
  }
  echo '</ul>';
}

function bgv_get_field($name, $default = null, $post_id = null) {
  if (function_exists('get_field')) {
    $target_post_id = $post_id ? $post_id : false;
    $value = get_field($name, $target_post_id);
    if ($value !== null && $value !== false && $value !== '') {
      return $value;
    }
  }
  return $default;
}

function bgv_image_url($image, $default = '') {
  if (is_array($image) && ! empty($image['url'])) {
    return esc_url($image['url']);
  }
  if (is_numeric($image)) {
    $url = wp_get_attachment_image_url((int) $image, 'full');
    return $url ? esc_url($url) : esc_url($default);
  }
  if (is_string($image) && $image !== '') {
    return esc_url($image);
  }
  return esc_url($default);
}

function bgv_linked_name($name, $image = '', $url = '') {
  $name = wp_kses_post($name);
  $href = $url ? $url : $image;
  if ($href) {
    return '<a href="' . esc_url($href) . '" class="gallery">' . $name . '</a>';
  }
  return $name;
}

function bgv_field_is_empty($value) {
  return $value === null || $value === false || $value === '' || $value === array();
}

function bgv_cpt_field($post_id, $name, $default = '') {
  if (function_exists('get_field')) {
    $value = get_field($name, $post_id);
    if (! bgv_field_is_empty($value)) {
      return $value;
    }
  }

  $value = get_post_meta($post_id, $name, true);
  return bgv_field_is_empty($value) ? $default : $value;
}

function bgv_cpt_is_visible($post_id) {
  $visible = bgv_cpt_field($post_id, 'menu_visible', null);
  if ($visible === null) {
    $visible = bgv_cpt_field($post_id, 'linked_food_visible', null);
  }

  return $visible === null || $visible === true || $visible === 1 || $visible === '1';
}

function bgv_cpt_display_order($post_id) {
  $order = bgv_cpt_field($post_id, 'menu_display_order', null);
  if ($order === null) {
    $order = bgv_cpt_field($post_id, 'linked_food_display_order', null);
  }

  return is_numeric($order) ? (int) $order : 9999;
}

function bgv_get_visible_cpt_items($post_type) {
  $items = get_posts(array(
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => array('menu_order' => 'ASC', 'title' => 'ASC'),
    'order' => 'ASC',
    'suppress_filters' => false,
  ));

  $items = array_values(array_filter($items, function($item) {
    return bgv_cpt_is_visible($item->ID);
  }));

  usort($items, function($a, $b) {
    $order_a = bgv_cpt_display_order($a->ID);
    $order_b = bgv_cpt_display_order($b->ID);

    if ($order_a === $order_b) {
      return strnatcasecmp($a->post_title, $b->post_title);
    }

    return ($order_a < $order_b) ? -1 : 1;
  });

  if ($prefix === 'kids') {
    $items = bgv_apply_kids_pdf_prices($items);
  }

  return $items;
}

function bgv_apply_kids_pdf_prices($items) {
  foreach ($items as &$item) {
    $name = isset($item['name']) ? wp_strip_all_tags((string) $item['name']) : '';
    if ($name === '') {
      continue;
    }

    if (strpos($name, 'トマトスパゲッティ') !== false) {
      $item['price'] = '900';
    } elseif (strpos($name, 'カルボナーラ') !== false) {
      $item['price'] = '900';
    } elseif (strpos($name, 'クリームリゾット') !== false) {
      $item['price'] = '900';
    } elseif (strpos($name, 'ハンバーグ') !== false) {
      $item['price'] = '1100';
    }
  }
  unset($item);

  return $items;
}

function bgv_has_visible_cpt_items($post_type) {
  return ! empty(bgv_get_visible_cpt_items($post_type));
}

function bgv_render_cpt_menu_items($post_type, $class_name = 'menu', $group_field = '', $group_labels = array()) {
  $items = bgv_get_visible_cpt_items($post_type);
  if (empty($items)) {
    return false;
  }

  $groups = array('' => array());
  if ($group_field) {
    $groups = array();
    foreach ($group_labels as $key => $label) {
      $groups[$key] = array();
    }
  }

  foreach ($items as $item) {
    $group = $group_field ? (string) bgv_cpt_field($item->ID, $group_field, '') : '';
    if ($group_field && ! isset($groups[$group])) {
      $groups[$group] = array();
      $group_labels[$group] = $group;
    }
    $groups[$group][] = $item;
  }

  ?>
  <dl class="<?php echo esc_attr($class_name); ?>">
    <?php foreach ($groups as $group => $group_items) : ?>
      <?php if (empty($group_items)) : ?>
        <?php continue; ?>
      <?php endif; ?>
      <?php if ($group_field) : ?>
        <dt class="cate"><?php echo esc_html(isset($group_labels[$group]) ? $group_labels[$group] : $group); ?></dt>
      <?php endif; ?>
      <?php foreach ($group_items as $item) : ?>
        <?php
        $description = bgv_cpt_field($item->ID, 'menu_description', '');
        $price = bgv_cpt_field($item->ID, 'menu_price', '');
        ?>
        <dt>
          <?php echo esc_html(get_the_title($item)); ?>
          <?php if ($description) : ?>
            <p><?php echo wp_kses_post(nl2br($description)); ?></p>
          <?php endif; ?>
        </dt>
        <?php if ($price) : ?>
          <dd><?php echo wp_kses_post($price); ?></dd>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </dl>
  <?php

  return true;
}

function bgv_menu_item_image_url($image) {
  if (is_array($image) && ! empty($image['url'])) {
    return $image['url'];
  }

  if (is_numeric($image)) {
    $url = wp_get_attachment_image_url((int) $image, 'full');
    return $url ? $url : '';
  }

  return is_string($image) ? $image : '';
}

function bgv_normalize_acf_menu_item($item, $category = '') {
  if (! is_array($item)) {
    return array();
  }

  $name = isset($item['item_name']) ? $item['item_name'] : '';
  $price = isset($item['item_price']) ? $item['item_price'] : '';
  $image = isset($item['item_image']) ? $item['item_image'] : '';
  $url = isset($item['item_link_url']) ? $item['item_link_url'] : '';
  $description = isset($item['item_description']) ? $item['item_description'] : '';
  $item_category = isset($item['item_category']) ? $item['item_category'] : $category;

  if ($name === '' && $price === '' && $description === '' && empty($image) && $url === '') {
    return array();
  }

  return array(
    'name' => $name,
    'price' => $price,
    'image' => bgv_menu_item_image_url($image),
    'url' => $url,
    'description' => $description,
    'category' => $item_category,
  );
}

function bgv_get_page_menu_items($prefix, $post_id = null) {
  $post_id = $post_id ? $post_id : get_the_ID();
  $items = array();

  $repeater_items = bgv_get_field($prefix . '_items', array(), $post_id);
  if (is_array($repeater_items) && ! empty($repeater_items)) {
    foreach ($repeater_items as $item) {
      $normalized = bgv_normalize_acf_menu_item($item);
      if (! empty($normalized)) {
        $items[] = $normalized;
      }
    }
  }

  for ($i = 1; $i <= 80; $i++) {
    $fixed_item = array(
      'item_name' => bgv_get_field($prefix . '_item_' . $i . '_name', '', $post_id),
      'item_price' => bgv_get_field($prefix . '_item_' . $i . '_price', '', $post_id),
      'item_description' => bgv_get_field($prefix . '_item_' . $i . '_description', '', $post_id),
      'item_image' => bgv_get_field($prefix . '_item_' . $i . '_image', '', $post_id),
      'item_link_url' => bgv_get_field($prefix . '_item_' . $i . '_link_url', '', $post_id),
      'item_category' => bgv_get_field($prefix . '_item_' . $i . '_category', '', $post_id),
    );
    $normalized = bgv_normalize_acf_menu_item($fixed_item);
    if (! empty($normalized)) {
      $items[] = $normalized;
    }
  }

  return $items;
}

function bgv_has_page_menu_items($prefix, $post_id = null) {
  return ! empty(bgv_get_page_menu_items($prefix, $post_id));
}

function bgv_render_page_acf_menu_items($prefix, $class_name = 'menu', $category_labels = array(), $post_id = null) {
  $items = bgv_get_page_menu_items($prefix, $post_id);
  if (empty($items)) {
    return false;
  }

  if (! empty($category_labels)) {
    $groups = array();
    foreach ($category_labels as $key => $label) {
      $groups[$key] = array();
    }

    foreach ($items as $item) {
      $category = isset($item['category']) && $item['category'] !== '' ? $item['category'] : 'other';
      if (! isset($groups[$category])) {
        $groups[$category] = array();
        $category_labels[$category] = $category;
      }
      $groups[$category][] = $item;
    }
  } else {
    $groups = array('' => $items);
  }

  ?>
  <dl class="<?php echo esc_attr($class_name); ?>">
    <?php foreach ($groups as $category => $group_items) : ?>
      <?php if (empty($group_items)) : ?>
        <?php continue; ?>
      <?php endif; ?>
      <?php if (! empty($category_labels)) : ?>
        <dt class="cate"><?php echo esc_html(isset($category_labels[$category]) ? $category_labels[$category] : $category); ?></dt>
      <?php endif; ?>
      <?php foreach ($group_items as $item) : ?>
        <?php if (! empty($item['name']) || ! empty($item['description'])) : ?>
          <dt>
            <?php echo bgv_linked_name(esc_html($item['name']), $item['image'], $item['url']); ?>
            <?php if (! empty($item['description'])) : ?>
              <p><?php echo wp_kses_post(nl2br($item['description'])); ?></p>
            <?php endif; ?>
          </dt>
        <?php endif; ?>
        <?php if (! empty($item['price'])) : ?>
          <dd><?php echo wp_kses_post($item['price']); ?></dd>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </dl>
  <?php

  return true;
}

function bgv_default_lunch_rich_sections() {
  return array(
    array(
      'label' => 'A',
      'title' => '',
      'description' => '',
      'items' => array(
        array(
          'name' => '・スパゲッティ　シラスのペペロンチーノ<br />〜柚子胡椒風味〜',
          'note' => '大盛り＋２００円',
          'price' => '1450',
        ),
      ),
      'note' => '',
    ),
    array(
      'label' => 'B',
      'title' => '',
      'description' => '',
      'items' => array(
        array(
          'name' => '①あべ鶏のグリルと彩り野菜　〜粒マスタードソース〜',
          'note' => '＊バゲット又はライスをお選び下さい',
          'price' => '<span>１５０g・・・・・・</span>1500<br /><span>２００g・・・・・・</span>1800<br /><span>２５０g・・・・・・</span>2100',
        ),
        array(
          'name' => '②牛ハラミのグリルと彩り野菜　〜グレイビーソース〜',
          'note' => '＊バゲット又はライスをお選び下さい',
          'price' => '<span>１５０g・・・・・・</span>2100<br /><span>２００g・・・・・・</span>2700<br /><span>２５０g・・・・・・</span>3300',
        ),
      ),
      'note' => '',
    ),
    array(
      'label' => 'C',
      'title' => '',
      'description' => '',
      'items' => array(
        array(
          'name' => '・７品目のワンプレートランチ',
          'note' => '・白トリ貝のソテー　〜カレー風味〜<br />・イタリア産　生ハム<br />・オレンジ風味のキャロットラペ<br />・カニミソとマスカルポーネチーズのディップ 又は豚肉のリエット<br />・ジャガイモのパルミジャーノチーズ和え<br />・オムレツとトマトソース<br />・国産鶏のグリル　〜粒マスタードソース〜',
          'price' => '1750',
        ),
      ),
      'note' => '',
    ),
    array(
      'label' => '',
      'title' => '',
      'description' => '',
      'items' => array(
        array('name' => '＊ランチ限定', 'note' => '', 'price' => ''),
        array('name' => '生ビール、ハイボール<br />スパークリングワイン、白ワイン、赤ワイン', 'note' => '', 'price' => 'ALL650円'),
        array('name' => '＊お会計はテーブルチェックでお願い致します。 ＊ランチタイムは現金のみとさせていただきます。', 'note' => '', 'price' => ''),
        array('name' => '（全てサラダ、スープ、バゲット付き）', 'note' => '', 'price' => ''),
        array('name' => 'コーヒー、紅茶', 'note' => '', 'price' => '＋350'),
        array('name' => 'デザート', 'note' => '', 'price' => '＋400'),
        array('name' => 'バゲットの追加', 'note' => '', 'price' => '＋200'),
        array('name' => '（全て税込み価格）', 'note' => '', 'price' => ''),
      ),
      'note' => '',
    ),
  );
}

function bgv_lunch_field($section_index, $field, $default = '', $post_id = null) {
  return bgv_get_field('lunch_section_' . $section_index . '_' . $field, $default, $post_id);
}

function bgv_lunch_item_field($section_index, $item_index, $field, $default = '', $post_id = null) {
  return bgv_get_field('lunch_section_' . $section_index . '_item_' . $item_index . '_' . $field, $default, $post_id);
}

function bgv_has_lunch_acf_values($post_id = null) {
  if (! function_exists('get_field')) {
    return false;
  }

  $post_id = $post_id ? $post_id : get_the_ID();
  $section_fields = array('label', 'title', 'description', 'note');
  $item_fields = array('name', 'description', 'note', 'price', 'image', 'link_url');

  for ($section_index = 1; $section_index <= 5; $section_index++) {
    foreach ($section_fields as $field) {
      $value = get_field('lunch_section_' . $section_index . '_' . $field, $post_id);
      if ($value !== null && $value !== '' && $value !== false) {
        return true;
      }
    }

    for ($item_index = 1; $item_index <= 12; $item_index++) {
      foreach ($item_fields as $field) {
        $value = get_field('lunch_section_' . $section_index . '_item_' . $item_index . '_' . $field, $post_id);
        if (! empty($value)) {
          return true;
        }
      }
    }
  }

  return false;
}

function bgv_get_lunch_sections($post_id = null) {
  $post_id = $post_id ? $post_id : get_the_ID();
  $defaults = bgv_default_lunch_rich_sections();
  $sections = array();

  foreach ($defaults as $section_index => $default_section) {
    $acf_index = $section_index + 1;
    $default_items = isset($default_section['items']) ? $default_section['items'] : array();
    $items = array();

    for ($item_index = 1; $item_index <= 12; $item_index++) {
      $default_item = isset($default_items[$item_index - 1]) ? $default_items[$item_index - 1] : array();
      $name = bgv_lunch_item_field($acf_index, $item_index, 'name', isset($default_item['name']) ? $default_item['name'] : '', $post_id);
      $description = bgv_lunch_item_field($acf_index, $item_index, 'description', isset($default_item['description']) ? $default_item['description'] : '', $post_id);
      $note = bgv_lunch_item_field($acf_index, $item_index, 'note', isset($default_item['note']) ? $default_item['note'] : '', $post_id);
      $price = bgv_lunch_item_field($acf_index, $item_index, 'price', isset($default_item['price']) ? $default_item['price'] : '', $post_id);
      $image = bgv_lunch_item_field($acf_index, $item_index, 'image', '', $post_id);
      $url = bgv_lunch_item_field($acf_index, $item_index, 'link_url', '', $post_id);

      if ($name === '' && $description === '' && $note === '' && $price === '' && empty($image) && $url === '') {
        continue;
      }

      $items[] = array(
        'name' => $name,
        'description' => $description,
        'note' => $note,
        'price' => $price,
        'image' => bgv_menu_item_image_url($image),
        'url' => $url,
      );
    }

    $label = bgv_lunch_field($acf_index, 'label', isset($default_section['label']) ? $default_section['label'] : '', $post_id);
    $title = bgv_lunch_field($acf_index, 'title', isset($default_section['title']) ? $default_section['title'] : '', $post_id);
    $description = bgv_lunch_field($acf_index, 'description', isset($default_section['description']) ? $default_section['description'] : '', $post_id);
    $note = bgv_lunch_field($acf_index, 'note', isset($default_section['note']) ? $default_section['note'] : '', $post_id);

    if ($label === '' && $title === '' && $description === '' && $note === '' && empty($items)) {
      continue;
    }

    $sections[] = array(
      'label' => $label,
      'title' => $title,
      'description' => $description,
      'items' => $items,
      'note' => $note,
    );
  }

  return $sections;
}

function bgv_render_lunch_sections($sections) {
  if (empty($sections)) {
    return false;
  }

  ?>
  <dl class="menu lunch-menu-list">
    <?php foreach ($sections as $section) : ?>
      <?php if (! empty($section['label'])) : ?>
        <dt class="cate"><?php echo wp_kses_post($section['label']); ?></dt>
      <?php endif; ?>
      <?php if (! empty($section['title'])) : ?>
        <dt class="<?php echo esc_attr(bgv_lunch_text_class($section['title'])); ?>"><?php echo wp_kses_post(nl2br($section['title'])); ?></dt>
      <?php endif; ?>
      <?php if (! empty($section['description'])) : ?>
        <dt class="<?php echo esc_attr(bgv_lunch_text_class($section['description'])); ?>"><?php echo wp_kses_post(nl2br($section['description'])); ?></dt>
      <?php endif; ?>
      <?php foreach ((isset($section['items']) ? $section['items'] : array()) as $item) : ?>
        <?php if (! empty($item['name'])) : ?>
          <dt class="<?php echo esc_attr(bgv_lunch_text_class($item['name'])); ?>"><?php echo bgv_linked_name(wp_kses_post(nl2br($item['name'])), $item['image'], $item['url']); ?></dt>
        <?php endif; ?>
        <?php if (! empty($item['description'])) : ?>
          <dt class="<?php echo esc_attr(bgv_lunch_text_class($item['description'])); ?>"><?php echo wp_kses_post(nl2br($item['description'])); ?></dt>
        <?php endif; ?>
        <?php if (! empty($item['note'])) : ?>
          <dt class="<?php echo esc_attr(bgv_lunch_text_class($item['note'])); ?>"><?php echo wp_kses_post(nl2br($item['note'])); ?></dt>
        <?php endif; ?>
        <?php if (! empty($item['price'])) : ?>
          <dd class="lunch-price"><?php echo wp_kses_post(nl2br($item['price'])); ?></dd>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php if (! empty($section['note'])) : ?>
        <dt class="<?php echo esc_attr(bgv_lunch_text_class($section['note'])); ?>"><?php echo wp_kses_post(nl2br($section['note'])); ?></dt>
      <?php endif; ?>
    <?php endforeach; ?>
  </dl>
  <?php

  return true;
}

function bgv_lunch_text_class($text) {
  $plain = wp_strip_all_tags((string) $text);
  $red_keywords = array(
    '全てサラダ',
    'バゲット又はライス',
    'ランチ限定',
    'お会計',
    'ランチタイム',
    '現金',
    '全て税込',
  );

  foreach ($red_keywords as $keyword) {
    if (strpos($plain, $keyword) !== false) {
      return 'lunch-text-red';
    }
  }

  return '';
}

function bgv_lunch_pdf_pages() {
  $pages = array();

  for ($i = 1; $i <= 1; $i++) {
    $file = sprintf('assets/images/lunch-pdf/lunch-menu-page-%02d.png', $i);

    $pages[] = array(
      'src' => bgv_asset_uri($file) . '?ver=' . rawurlencode(BGV_THEME_VERSION),
      'alt' => 'ランチメニュー PDF ' . $i . 'ページ目',
    );
  }

  return $pages;
}

function bgv_render_lunch_pdf_menu() {
  $lunch_pdf_pages = bgv_lunch_pdf_pages();
  if (empty($lunch_pdf_pages)) {
    return false;
  }

  ?>
  <div class="single-page lunch-pdf-menu">
    <ol>
      <?php foreach ($lunch_pdf_pages as $index => $page) : ?>
        <li>
          <img src="<?php echo esc_url($page['src']); ?>" alt="<?php echo esc_attr($page['alt']); ?>" width="1191" height="1684"<?php echo $index > 0 ? ' loading="lazy"' : ' fetchpriority="high"'; ?> decoding="async" />
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
  <?php

  return true;
}

function bgv_render_lunch_pdf_text_menu() {
  ?>
  <div class="single-page lunch-pdf-text-menu" aria-label="ランチメニュー">
    <h2>Lunch Menu</h2>

    <div class="lunch-top-note lunch-red">（全てサラダ、スープ、バゲット付き）</div>

    <div class="lunch-addons">
      <p><span>コーヒー、紅茶</span><strong>＋350</strong></p>
      <p><span>デザート</span><strong>＋400</strong></p>
      <p><span>バゲットの追加</span><strong>＋200</strong></p>
      <p class="lunch-red">（全て税込み価格）</p>
    </div>

    <section class="lunch-block lunch-block-a">
      <h3>A</h3>
      <div class="lunch-main">
        <p>・スパゲッティ　シラスのペペロンチーノ</p>
        <p class="lunch-center">〜柚子胡椒風味〜</p>
      </div>
      <p class="lunch-extra">大盛り＋２００円</p>
      <p class="lunch-price">1450</p>
    </section>

    <section class="lunch-block lunch-block-b">
      <h3>B</h3>
      <div class="lunch-b-item">
        <p class="lunch-dish">①あべ鶏のグリルと彩り野菜　　〜粒マスタードソース〜</p>
        <p class="lunch-red">＊バゲット又はライスをお選び下さい</p>
        <div class="lunch-grams">
          <p><span>１５０g・・・・・・</span><strong>1500</strong></p>
          <p><span>２００g・・・・・・</span><strong>1800</strong></p>
          <p><span>２５０g・・・・・・</span><strong>2100</strong></p>
        </div>
      </div>
      <div class="lunch-b-item">
        <p class="lunch-dish">②牛ハラミのグリルと彩り野菜　　〜グレイビーソース〜</p>
        <p class="lunch-red">＊バゲット又はライスをお選び下さい</p>
        <div class="lunch-grams">
          <p><span>１５０g・・・・・・</span><strong>2100</strong></p>
          <p><span>２００g・・・・・・</span><strong>2700</strong></p>
          <p><span>２５０g・・・・・・</span><strong>3300</strong></p>
        </div>
      </div>
    </section>

    <section class="lunch-block lunch-block-c">
      <h3>C</h3>
      <div class="lunch-c-list">
        <p>・７品目のワンプレートランチ</p>
        <p>・白トリ貝のソテー　〜カレー風味〜</p>
        <p>・イタリア産　生ハム</p>
        <p>・オレンジ風味のキャロットラペ</p>
        <p>・カニミソとマスカルポーネチーズのディップ <span class="lunch-red-inline">又は</span>豚肉のリエット</p>
        <p>・ジャガイモのパルミジャーノチーズ和え</p>
        <p>・オムレツとトマトソース</p>
        <p>・国産鶏のグリル　〜粒マスタードソース〜</p>
      </div>
      <p class="lunch-price">1750</p>
    </section>

    <div class="lunch-bottom">
      <div class="lunch-dinner-note">
        <p>＊ディナーメニューもご用意可能です！</p>
        <p>スタッフまでお気軽にお尋ねください。</p>
        <p>（在庫がないメニューもある場合がございます）</p>
      </div>
      <div class="lunch-limited">
        <p class="lunch-red">＊ランチ限定</p>
        <p><span>生ビール、ハイボール</span><strong>ALL650円</strong></p>
        <p>スパークリングワイン、白ワイン、赤ワイン</p>
      </div>
    </div>

    <p class="lunch-check-note lunch-red">＊お会計はテーブルチェックでお願い致します。 ＊ランチタイムは現金のみとさせていただきます。</p>

    <div class="lunch-logo">
      <img src="<?php echo esc_url(bgv_asset_uri('assets/images/assets/logo_footer.png')); ?>" alt="Bistrot Grand Village" width="160" height="112" loading="lazy" decoding="async" />
    </div>
  </div>
  <?php

  return true;
}

function bgv_lunch_pdf_menu_html() {
  ob_start();
  $rendered = bgv_render_lunch_pdf_text_menu();
  $html = ob_get_clean();

  return $rendered ? $html : '';
}

function bgv_render_kids_soft_drink_note() {
  ?>
  <div class="kids-soft-drink-note">
    <p class="kids-soft-drink-title">ソフトドリンクお選びください。</p>
    <p>・リンゴジュース</p>
    <p>・オレンジジュース</p>
    <p>・マンゴージュース</p>
    <p>・ウーロン茶</p>
  </div>
  <?php
}

function bgv_default_gallery_files() {
  return array(
    '01.jpg', '02.jpg', '03.jpg', 'IMG_0164.jpg', 'IMG_0660.jpg', 'IMG_0926.jpg',
    'IMG_1013.jpg', 'IMG_1014.jpg', 'IMG_1038.jpg', 'IMG_1055.jpg', 'IMG_1059.jpg', 'IMG_1597.jpg',
    'IMG_1680.jpg', 'IMG_2240.jpg', 'IMG_2253.jpg', 'IMG_2256.jpg', 'IMG_2269.jpg', 'IMG_7034.jpg',
    'IMG_7356.jpg', 'IMG_7368.jpg', 'IMG_7369.jpg', 'IMG_7373.jpg', 'IMG_7505.jpg', 'IMG_7508.jpg',
    'IMG_7509.jpg', 'IMG_7525.jpg', 'IMG_7527.jpg', 'IMG_7578.jpg', 'IMG_7594.jpg', 'IMG_7729.jpg',
    'IMG_8627.jpg', 'IMG_8675.jpg', 'IMG_9932.jpg', 'IMG_9933.jpg', 'IMG_9934.jpg', 'IMG_9936.jpg',
    '545E568C-E844-4F8C-9A32-F4E51A350470.JPG', '5E3F733A-5269-4A42-9A1C-62AF0CD7912C.JPG',
    'IMG_0069.JPG', 'IMG_0401.JPG', 'IMG_2252.JPG', 'IMG_2254.JPG', 'IMG_2259.JPG', 'IMG_2260.JPG',
    'IMG_2339.JPG', 'IMG_2340.JPG', 'IMG_2371.JPG', 'IMG_2393.JPG', 'IMG_2394.JPG', 'IMG_2396.JPG',
    'IMG_2437.JPG', 'IMG_2445.JPG', 'IMG_7265.JPG', 'IMG_7312.JPG', 'IMG_7469.JPG', 'IMG_7559.JPG',
    'IMG_7764.JPG', 'IMG_8175.JPG', 'IMG_8302.JPG', 'IMG_8332.JPG', 'IMG_8436.JPG', 'IMG_8611.JPG',
    'IMG_8661.JPG', 'IMG_8662.JPG', 'IMG_9697.JPG', 'IMG_9935.JPG', 'IMG_9940.JPG', 'IMG_9942.JPG',
    'IMG_9943.JPG', 'IMG_9944.JPG',
  );
}

function bgv_default_interior_exterior_sections() {
  return array(
    'exterior' => array(
      'title' => '外観',
      'subtitle' => 'Exterior',
      'images' => array(
        array(
          'src' => bgv_asset_uri_if_exists('assets/images/uploads/2022/04/gai1.jpg'),
          'alt' => '外観1',
        ),
        array(
          'src' => bgv_asset_uri_if_exists('assets/images/uploads/2022/04/gai2.jpg'),
          'alt' => '外観2',
        ),
      ),
    ),
    'interior' => array(
      'title' => '内観',
      'subtitle' => 'Interior',
      'images' => array(
        array(
          'src' => bgv_asset_uri_if_exists('assets/images/uploads/2022/04/nai1.jpg'),
          'alt' => '内観1',
        ),
        array(
          'src' => bgv_asset_uri_if_exists('assets/images/uploads/2022/04/nai2.jpg'),
          'alt' => '内観2',
        ),
        array(
          'src' => bgv_asset_uri_if_exists('assets/images/uploads/2022/04/nai3.jpg'),
          'alt' => '内観3',
        ),
        array(
          'src' => bgv_asset_uri_if_exists('assets/images/uploads/2022/04/nai4.jpg'),
          'alt' => '内観4',
        ),
      ),
    ),
  );
}

function bgv_get_interior_exterior_sections($post_id = null) {
  $target_post_id = $post_id ? (int) $post_id : 0;
  if (! $target_post_id) {
    $page = get_page_by_path('interior-exterior');
    $target_post_id = $page ? (int) $page->ID : 0;
  }

  $defaults = bgv_default_interior_exterior_sections();
  $sections = array();

  foreach ($defaults as $section_key => $section_default) {
    $images = array();
    $default_images = isset($section_default['images']) && is_array($section_default['images']) ? $section_default['images'] : array();

    foreach ($default_images as $index => $image_default) {
      $field_index = $index + 1;
      $image = bgv_get_field($section_key . '_image_' . $field_index, '', $target_post_id);
      $url = bgv_image_url($image, isset($image_default['src']) ? $image_default['src'] : '');
      $alt = bgv_get_field($section_key . '_image_' . $field_index . '_alt', isset($image_default['alt']) ? $image_default['alt'] : '', $target_post_id);

      if ($url === '') {
        continue;
      }

      $images[] = array(
        'src' => $url,
        'alt' => $alt,
      );
    }

    $sections[$section_key] = array(
      'title' => bgv_get_field($section_key . '_title', isset($section_default['title']) ? $section_default['title'] : '', $target_post_id),
      'subtitle' => bgv_get_field($section_key . '_subtitle', isset($section_default['subtitle']) ? $section_default['subtitle'] : '', $target_post_id),
      'images' => $images,
    );
  }

  return $sections;
}

function bgv_access_day_labels() {
  return array(
    'mon' => '月',
    'tue' => '火',
    'wed' => '水',
    'thu' => '木',
    'fri' => '金',
    'sat' => '土',
    'sun' => '日',
  );
}

function bgv_default_access_schedule_rows() {
  return array(
    'lunch' => array(
      'mon' => '×',
      'tue' => '×',
      'wed' => '○',
      'thu' => '○',
      'fri' => '○',
      'sat' => '○',
      'sun' => '×',
    ),
    'dinner' => array(
      'mon' => '×',
      'tue' => '○',
      'wed' => '○',
      'thu' => '○',
      'fri' => '○',
      'sat' => '○',
      'sun' => '×',
    ),
  );
}

function bgv_get_access_schedule_rows($post_id = null) {
  $target_post_id = $post_id ? (int) $post_id : get_the_ID();
  $defaults = bgv_default_access_schedule_rows();
  $rows = array();

  foreach ($defaults as $service => $statuses) {
    $rows[$service] = array();
    foreach ($statuses as $day_key => $default_status) {
      $rows[$service][$day_key] = bgv_get_field('access_' . $service . '_' . $day_key . '_status', $default_status, $target_post_id);
    }
  }

  return $rows;
}

function bgv_render_interior_exterior_sections($post_id = null) {
  $sections = bgv_get_interior_exterior_sections($post_id);
  ?>
  <div class="photos interior-exterior-photos">
    <?php foreach ($sections as $section) : ?>
      <?php if (empty($section['images'])) : ?>
        <?php continue; ?>
      <?php endif; ?>
      <section class="photos-section">
        <h4 class="photos-section-title"><?php echo esc_html($section['title']); ?><span><?php echo esc_html($section['subtitle']); ?></span></h4>
        <div class="photos-slider">
          <?php foreach ($section['images'] as $image) : ?>
            <figure><img decoding="async" src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" /></figure>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </div>
  <?php
}

function bgv_get_gallery_images($post_id = null) {
  $images = array();
  $default_gallery_files = bgv_default_gallery_files();
  $target_post_id = $post_id ? (int) $post_id : 0;

  if ($target_post_id && function_exists('get_field')) {
    for ($i = 1; $i <= count($default_gallery_files); $i++) {
      $image_id = bgv_get_field('gallery_image_' . $i, 0, $target_post_id);
      $default_file = $default_gallery_files[$i - 1];
      $default_alt = 'ギャラリー' . $i;

      if ($image_id && is_numeric($image_id)) {
        $full_url = wp_get_attachment_image_url((int) $image_id, 'full');
        $thumb_html = wp_get_attachment_image((int) $image_id, 'large', false, array(
          'alt' => esc_attr(bgv_get_field('gallery_image_' . $i . '_alt', $default_alt, $target_post_id)),
          'loading' => 'lazy',
          'decoding' => 'async',
        ));

        if ($full_url && $thumb_html) {
          $images[] = array(
            'full_url' => $full_url,
            'thumb_html' => $thumb_html,
            'alt' => bgv_get_field('gallery_image_' . $i . '_alt', $default_alt, $target_post_id),
          );
          continue;
        }
      }

      $fallback_path = 'assets/images/auto_gal/' . $default_file;
      $url = bgv_asset_uri_if_exists($fallback_path);
      $alt = bgv_get_field('gallery_image_' . $i . '_alt', $default_alt, $target_post_id);
      if ($url === '') {
        continue;
      }
      $images[] = array(
        'full_url' => $url,
        'thumb_html' => '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async" />',
        'alt' => $alt,
      );
    }

    return $images;
  }

  $gallery_files = glob(bgv_asset_path('assets/images/auto_gal/*.{jpg,jpeg,JPG,JPEG,png,PNG}'), GLOB_BRACE);
  if (! is_array($gallery_files)) {
    return array();
  }

  sort($gallery_files, SORT_NATURAL | SORT_FLAG_CASE);
  foreach ($gallery_files as $index => $image_path) {
    $file = basename($image_path);
    $url = bgv_asset_uri('assets/images/auto_gal/' . rawurlencode($file));
    $alt = 'ギャラリー' . ($index + 1);
    $images[] = array(
      'full_url' => $url,
      'thumb_html' => '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async" />',
      'alt' => $alt,
    );
  }

  return $images;
}

function bgv_render_gallery_stack_list($images) {
  if (! is_array($images) || empty($images)) {
    return false;
  }

  $chunks = array_chunk($images, 3);
  $patterns = array(
    array(0, 1, 2),
    array(1, 2, 0),
    array(2, 0, 1),
  );
  $total_images = count($images);
  $fallback_index = 0;

  echo '<ul class="gallery-stack-grid">';
  foreach ($chunks as $stack_index => $chunk) {
    while (count($chunk) < 3 && $total_images > 0) {
      $chunk[] = $images[$fallback_index % $total_images];
      $fallback_index++;
    }

    $pattern = $patterns[$stack_index % count($patterns)];
    echo '<li' . ($stack_index >= 6 ? ' class="lazy"' : '') . '>';
    echo '<div class="gallery-stack gallery-stack-' . esc_attr((string) (($stack_index % 3) + 1)) . '">';

    foreach ($pattern as $layer_index => $image_index) {
      $image = $chunk[$image_index];
      echo '<a href="' . esc_url($image['full_url']) . '" class="gallery gallery-stack-layer layer-' . esc_attr((string) ($layer_index + 1)) . '" aria-label="' . esc_attr($image['alt']) . 'を拡大表示">';
      echo $image['thumb_html'];
      echo '</a>';
    }

    echo '</div>';
    echo '</li>';
  }
  echo '</ul>';

  return true;
}

function bgv_render_linked_food_items() {
  $items = bgv_get_visible_cpt_items('linked_food_item');
  if (empty($items)) {
    return false;
  }

  ?>
  <dl class="menu linked-food-items">
    <dt class="cate">料理画像リンク<span>Food Gallery</span></dt>
    <?php foreach ($items as $item) : ?>
        <?php
        $image = bgv_cpt_field($item->ID, 'linked_food_image', '');
        $image_url = bgv_image_url($image);
        $link_url = bgv_cpt_field($item->ID, 'linked_food_url', '');
        $description = bgv_cpt_field($item->ID, 'linked_food_description', '');
        $href = $link_url ? $link_url : $image_url;
        ?>
        <?php if (! $image_url && ! $href) : ?>
          <?php continue; ?>
        <?php endif; ?>
        <dt>
          <a href="<?php echo esc_url($href); ?>"<?php echo $image_url && ! $link_url ? ' class="gallery"' : ''; ?>><?php echo esc_html(get_the_title($item)); ?></a>
          <?php if ($description) : ?>
            <p><?php echo wp_kses_post(nl2br($description)); ?></p>
          <?php endif; ?>
        </dt>
    <?php endforeach; ?>
  </dl>
  <?php

  return true;
}

function bgv_render_page_title($title, $subtitle = '') {
  ?>
  <section id="pagetitle">
    <h1><?php echo esc_html($title); ?><?php if ($subtitle) : ?><span><?php echo esc_html($subtitle); ?></span><?php endif; ?></h1>
  </section>
  <section id="breadcrumb">
    <div class="container">
      <ul>
        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="home"><span>HOME</span></a></li>
        <li><span class="fa fa-caret-right"></span><span><?php echo esc_html($title); ?></span></li>
      </ul>
    </div>
  </section>
  <?php
}

function bgv_menu_from_acf($default_sections, $post_id = null) {
  $sections = bgv_get_field('menu_sections', array(), $post_id);
  if (! is_array($sections) || empty($sections)) {
    return $default_sections;
  }

  $normalized = array();
  foreach ($sections as $section) {
    $items = array();
    if (! empty($section['menu_items']) && is_array($section['menu_items'])) {
      foreach ($section['menu_items'] as $item) {
        $image = bgv_image_url(isset($item['menu_image']) ? $item['menu_image'] : '', '');
        $items[] = array(
          'name' => isset($item['menu_name']) ? $item['menu_name'] : '',
          'price' => isset($item['menu_price']) ? $item['menu_price'] : '',
          'image' => $image,
          'url' => isset($item['menu_url']) ? $item['menu_url'] : '',
          'note' => isset($item['menu_note']) ? $item['menu_note'] : '',
        );
      }
    }
    $normalized[] = array(
      'title' => isset($section['section_title']) ? $section['section_title'] : '',
      'subtitle' => isset($section['section_subtitle']) ? $section['section_subtitle'] : '',
      'items' => $items,
    );
  }

  return $normalized;
}

function bgv_render_menu_sections($sections, $class_name = 'menu') {
  ?>
  <dl class="<?php echo esc_attr($class_name); ?>">
    <?php foreach ($sections as $section) : ?>
      <?php if (! empty($section['title'])) : ?>
        <dt class="cate"><?php echo esc_html($section['title']); ?><?php if (! empty($section['subtitle'])) : ?><span><?php echo esc_html($section['subtitle']); ?></span><?php endif; ?></dt>
      <?php endif; ?>
      <?php foreach ((isset($section['items']) ? $section['items'] : array()) as $item) : ?>
        <?php get_template_part('template-parts/menu-item', null, array('item' => $item)); ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </dl>
  <?php
}

function bgv_has_acf_menu_sections($post_id = null) {
  if (! function_exists('get_field')) {
    return false;
  }

  $target_post_id = $post_id ? $post_id : false;
  $sections = get_field('menu_sections', $target_post_id);
  return is_array($sections) && ! empty($sections);
}

function bgv_static_default_content($filename) {
  $path = bgv_asset_path('assets/defaults/' . basename($filename));
  if (! file_exists($path)) {
    return '';
  }

  $html = file_get_contents($path);
  if (! is_string($html) || $html === '') {
    return '';
  }

  $content = '';
  if (preg_match('/<div class="single-page">\s*(.*?)\s*<\/div>\s*<\/article>/s', $html, $matches)) {
    $content = $matches[1];
  } elseif (preg_match('/<dl class="menu lunch-menu-list">.*?<\/dl>/s', $html, $matches)) {
    $content = $matches[0];
  } elseif (preg_match('/<section id="main">\s*<div class="container">\s*(.*?)\s*<\/div><!--\/\.container-->\s*<\/section>/s', $html, $matches)) {
    $content = $matches[1];
  }

  if ($content === '') {
    return '';
  }

  $image_base = bgv_asset_uri('assets/images/');
  $content = str_replace(
    array('href="images/', "href='images/", 'src="images/', "src='images/"),
    array('href="' . $image_base, "href='" . $image_base, 'src="' . $image_base, "src='" . $image_base),
    $content
  );

  return bgv_rewrite_static_links($content);
}

function bgv_default_kokuban_images() {
  return array(
    array('url' => bgv_asset_uri_if_exists('assets/images/assets/kokuban-menu-1.png'), 'width' => 945, 'height' => 705),
    array('url' => bgv_asset_uri_if_exists('assets/images/assets/kokuban-menu-2.png'), 'width' => 934, 'height' => 698),
  );
}

function bgv_default_lunch_sections() {
  return array(
    array('title' => 'A', 'items' => array(
      array('name' => '・スパゲッティ　シラスのペペロンチーノ<br />〜柚子胡椒風味〜<br />大盛り＋２００円', 'price' => '1450'),
    )),
    array('title' => 'B', 'items' => array(
      array('name' => '①あべ鶏のグリルと彩り野菜　〜粒マスタードソース〜<br />＊バゲット又はライスをお選び下さい', 'price' => '<span>１５０g・・・・・・</span>1500<br /><span>２００g・・・・・・</span>1800<br /><span>２５０g・・・・・・</span>2100'),
      array('name' => '②牛ハラミのグリルと彩り野菜　〜グレイビーソース〜<br />＊バゲット又はライスをお選び下さい', 'price' => '<span>１５０g・・・・・・</span>2100<br /><span>２００g・・・・・・</span>2700<br /><span>２５０g・・・・・・</span>3300'),
    )),
    array('title' => 'C', 'items' => array(
      array('name' => '・７品目のワンプレートランチ<br />・白トリ貝のソテー　〜カレー風味〜<br />・イタリア産　生ハム<br />・オレンジ風味のキャロットラペ<br />・カニミソとマスカルポーネチーズのディップ 又は豚肉のリエット<br />・ジャガイモのパルミジャーノチーズ和え<br />・オムレツとトマトソース<br />・国産鶏のグリル　〜粒マスタードソース〜', 'price' => '1750'),
    )),
    array('title' => 'ランチ限定・追加', 'items' => array(
      array('name' => '＊ランチ限定<br />生ビール、ハイボール<br />スパークリングワイン、白ワイン、赤ワイン', 'price' => 'ALL650円'),
      array('name' => '＊お会計はテーブルチェックでお願い致します。 ＊ランチタイムは現金のみとさせていただきます。'),
      array('name' => '（全てサラダ、スープ、バゲット付き）'),
      array('name' => 'コーヒー、紅茶', 'price' => '＋350'),
      array('name' => 'デザート', 'price' => '＋400'),
      array('name' => 'バゲットの追加', 'price' => '＋200'),
      array('name' => '（全て税込み価格）'),
    )),
  );
}

function bgv_default_kids_sections() {
  return array(array('title' => 'お子様セットメニュー', 'subtitle' => 'kids set', 'items' => array(
    array('name' => '（全てバゲット又はライス、ソフトドリンク、バニラアイス付き）'),
    array('name' => 'ベーコンとキノコのトマトスパゲッティ', 'price' => '900'),
    array('name' => 'みんな大好き カルボナーラ', 'price' => '900'),
    array('name' => 'いろいろキノコのクリームリゾット', 'price' => '900'),
    array('name' => '煮込みハンバーグのデミグラスソース', 'price' => '1100'),
  )));
}

function bgv_default_drink_sections() {
  return array(
    array('title' => 'スパークリングワイン（グラス）', 'subtitle' => 'Sparkling wine', 'items' => array(
      array('name' => 'アットゥアーレ　スプマンテ・パドゼ<p>＜産地＞イタリア／エミリアロマーニャ＜品種＞トレッビアーノ１００％<br />クリーミーできめ細かくしっかりとした泡立ちと味わい。フローラルな香りと心地よいコクが印象的。</p>', 'price' => '770'),
    )),
    array('title' => '白ワイン（グラス）', 'subtitle' => 'White wine', 'items' => array(
      array('name' => 'マス・ド・ジャニーニ・ブラン<p>＜産地＞フランス/ラングドック・ルーション ＜品種＞ソーヴィニヨンブラン６０％グルナッシュブラン４０％<br />南仏のワインらしく果実味が豊かで酸味のバランスも良いスッキリな白です。</p>', 'price' => '770'),
      array('name' => 'ペルラ・デル・マール<p>＜産地＞スペイン／ アリカンテ＜品種＞アレハンドリア65％ソーヴィニョンブラン20％ヴィオニエ15％<br />スペインの潮風を浴びたフレッシュさとエレガントさを兼ね備えたバランスの良い一杯です。</p>', 'price' => '880'),
      array('name' => 'シャルドネI.G.Pデュ・ヴァル・ド・ロワール<p>＜産地＞フランス／ロワール ＜品種＞シャルドネ１００％<br />熟成感を感じる麦わら色。ボリュームのある味わいと丸みのある口当たりで綺麗な余韻。</p>', 'price' => '950'),
    )),
    array('title' => '赤ワイン（グラス）', 'subtitle' => 'Red wine', 'items' => array(
      array('name' => 'コート・ド・プルイユ　メルロー<p>＜産地＞フランス／ラングドック ＜品種＞メルロー１００％<br />良く熟した果実味を感じる味わいで丸みがあり上品な飲み心地。</p>', 'price' => '770'),
      array('name' => 'ラクリムス ファイブ<p>＜産地＞スペイン／リオハ＜品種＞テンプラニーリョ１００％<br />オーク樽で５ヶ月熟成。果実とバニラの香りが溶け込むまろやかで飲みやすいフルボディ。</p>', 'price' => '880'),
      array('name' => 'ブルゴーニュ・ルージュ<p>＜産地＞フランス／ブルゴーニュ ＜品種＞ガメイ１００％<br />フルボディで繊細な風味とタンニン。赤身肉やグリルした鶏肉、チーズ等と相性◎</p>', 'price' => '950'),
    )),
    array('title' => 'アルコール', 'subtitle' => 'Alcohol', 'items' => array(
      array('name' => '樽生ビール（キリン一番搾り）', 'price' => '680'),
      array('name' => '瓶ビール（キリンラガー）', 'price' => '900'),
      array('name' => 'ギネスビール（黒ビール）', 'price' => '900'),
      array('name' => 'ジムビーム　ハイボール', 'price' => '650'),
      array('name' => 'イチローズモルト　ハイボール（秩父蒸留所）', 'price' => '800'),
      array('name' => 'ゆずみつサワー（陸前高田産〜北限の柚子〜）', 'price' => '700'),
      array('name' => '自家製サングリア（赤）Hot or Ice', 'price' => '700'),
      array('name' => 'キール（カシスリキュールと白ワイン）', 'price' => '700'),
      array('name' => 'ブラッディーミモザ（ブラッドオレンジとスパークリングワイン）', 'price' => '700'),
      array('name' => 'ジントニック', 'price' => '700'),
      array('name' => 'ライムサワー', 'price' => '650'),
      array('name' => 'レモンサワー', 'price' => '650'),
      array('name' => 'カンパリソーダorオレンジ', 'price' => '750'),
      array('name' => 'カシスオレンジ', 'price' => '650'),
    )),
    array('title' => '日本酒', 'subtitle' => 'Sake', 'items' => array(
      array('name' => 'あさ開（岩手）180ml', 'price' => '830'),
      array('name' => '福正宗（石川）180ml', 'price' => '830'),
    )),
    array('title' => 'ソフトドリンク', 'subtitle' => 'Soft drink', 'items' => array(
      array('name' => 'ノンアルコールスパークリングワイン（ヨーロッパ産ぶどう使用 ２００mlボトル）', 'price' => '990'),
      array('name' => 'ノンアルコールビール', 'price' => '600'),
      array('name' => 'コカ コーラ', 'price' => '480'),
      array('name' => 'オレンジジュース', 'price' => '450'),
      array('name' => 'アップルジュース', 'price' => '450'),
      array('name' => 'ブラッドオレンジジュース', 'price' => '650'),
      array('name' => '自家製ジンジャーエール', 'price' => '700'),
      array('name' => 'HOTジンジャーレモネード', 'price' => '700'),
      array('name' => '完熟マンゴージュース', 'price' => '650'),
      array('name' => 'ウーロン茶', 'price' => '400'),
      array('name' => 'サンペレグリノ（イタリア 炭酸水）', 'price' => '900'),
    )),
  );
}

function bgv_default_food_sections() {
  return array(
    array('title' => '前菜', 'subtitle' => 'ape’ritif', 'items' => array(
      array('name' => 'シェフおまかせ前菜７種盛り合わせ（2名様分）', 'price' => '1,800', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/オードブル盛り合わせ.jpg')),
      array('name' => '８品目の菜園風サラダ', 'price' => '1,200', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/菜園風サラダ.jpg')),
      array('name' => '鴨胸肉のスモークとクレソンのサラダ仕立て〜バルサミコソース〜', 'price' => '1,450'),
      array('name' => 'フレンチポテトのスパイス和え', 'price' => '650'),
      array('name' => 'アンチョビキャベツソテー', 'price' => '650'),
      array('name' => 'ほうれん草とベーコンのオムレツ', 'price' => '1,100'),
      array('name' => 'あつあつ オニオングラタンスープ', 'price' => '900'),
      array('name' => '本日の野菜のポタージュ', 'price' => '900'),
      array('name' => 'お酒のお供３種盛り合わせ<br /><span class="fs80">仏産 ミモレットチーズ／仏産 熟成サラミ／伊産 生ハム</span>', 'price' => '1,500<span>ハーフ</span>750'),
    )),
    array('title' => '魚介', 'subtitle' => 'poisons', 'items' => array(
      array('name' => '殻付き生牡蠣<span class="fs80">（産地は黒板をご覧ください）</span>', 'price' => '500', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/生牡蠣.jpg')),
      array('name' => '海老とアボカドのカクテルソース', 'price' => '1,350'),
      array('name' => 'ズワイガニとアボカドのコンソメジュレがけ ～カリフラワーのムース添え～', 'price' => '1,450', 'url' => 'https://grand-village.yokohama/archives/52'),
      array('name' => '大分県豊後水道産 天然真鯛のカルパッチョ仕立て', 'price' => '1,600', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/真鯛のカルパッチョ.jpg')),
      array('name' => 'カニミソとマスカルポーネチーズのディップ<span class="fs80">（バゲット付き）</span>', 'price' => '1,100'),
      array('name' => 'ヤリイカとポワロー（西洋ねぎ）のフリット カラスミパウダーがけ', 'price' => '1,400'),
      array('name' => '本日のお魚料理（スタッフまでお尋ね下さい）', 'price' => '1,800'),
      array('name' => 'ツブ貝とキノコのソテー ～香草バターソース～', 'price' => '1,650', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/ツブ貝のソテー香草バターソース.jpg')),
    )),
    array('title' => '肉', 'subtitle' => 'viands', 'items' => array(
      array('name' => 'フォアグラのソテー ～ポルト酒のソース～', 'price' => '1,980', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/フォアグラのソテー.jpg')),
      array('name' => '牛ハラミ肉のグリルと彩り野菜 ～マデイラソース～', 'price' => '<span>150g</span>1,980<span>200g</span>2,480<span>250g</span>2,980', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/牛ハラミ肉のグリルマディラソース.jpg')),
      array('name' => '仔羊のロースト（ラムチョップ）１本', 'price' => '1,600'),
      array('name' => '鴨胸肉のロースト赤ワインとゴルゴンゾーラのソース', 'price' => '1,980', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/鴨肉のロースト赤ワイン.jpg')),
      array('name' => '地鶏“あべどり”のグリル 粒マスタードソース', 'price' => '1,450', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/あべ鶏のグリル粒マスタードソース.jpg')),
      array('name' => '岩中（いわちゅう）豚 肩ロースのグリルと彩り野菜〜バルサミコソース〜', 'price' => '1,600'),
      array('name' => 'ガーリックトースト<span class="fs80">（３枚）</span>', 'price' => '550'),
      array('name' => 'バゲット<span class="fs80">（２枚）</span>', 'price' => '350'),
    )),
    array('title' => 'パスタ＆リゾット', 'subtitle' => 'pasta & risotto', 'items' => array(
      array('name' => '広島産カキのクリームリゾット 又はスパゲッティ', 'price' => '1,600', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/牡蠣のクリームリゾット.jpg')),
      array('name' => 'ズワイガニとカブのリゾット～柚子の香り～', 'price' => '1,500', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/ズワイガニとカブのリゾット.jpg')),
      array('name' => 'アスパラガスとキノコのリゾット', 'price' => '1,350', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/アスパラとキノコのリゾット.jpg')),
      array('name' => 'ポルチーニ茸と数種キノコのリゾット 又はスパゲッティ', 'price' => '1,650', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/ポルチーニのリゾット.jpg')),
      array('name' => 'シラスのペペロンチーノ カラスミパウダーがけ', 'price' => '1,550', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/シラスのペペロンチーノ.jpg')),
      array('name' => 'スパゲッティ カルボナーラ', 'price' => '1,350', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/08/イベリコベーコンのカルボナーラ.jpg')),
      array('name' => 'スパゲッティ アマトリチャーナ（イベリコ豚ベーコンと玉ねぎのトマトソース）', 'price' => '1,350', 'image' => bgv_asset_uri_if_exists('assets/images/uploads/2021/02/スパゲッティアマトリチャーナ.jpg')),
      array('name' => 'ペンネのゴルゴンゾーラソース', 'price' => '1,300'),
    )),
  );
}

function bgv_default_wine_sections() {
  return array(
    array('title' => 'シャンパーニュ', 'subtitle' => 'Champagne', 'items' => array(
      array('name' => 'モンテュイ・ペール・エ・フィス・ブリュット・レゼルヴ🇫🇷<p>＜産地＞フランス／シャンパーニュ ＜品種＞シャルドネ４０％ ピノ・ムニエ６０％<br />豊潤な味わいにリッチな余韻。コクのあるふくよかな果実味と熟成感のバランス良く長く余韻を味わえます。</p>', 'price' => '13,000'),
    )),
    array('title' => 'スパークリングワイン', 'subtitle' => 'Sparkling wine', 'items' => array(
      array('name' => 'アットゥアーレ スプマンテ・パドゼ🇮🇹<p>＜産地＞イタリア／エミリアロマーニャ ＜品種＞トレッビアーノ１００％<br />クリーミーできめ細かくしっかりとした泡立ちと味わい。フローラルな香りと心地よいコクが印象的。</p>', 'price' => '4,500'),
      array('name' => 'ヴァンムスー ペルル・フィーヌ・デュ・コワン🇫🇷<p>＜産地＞フランス／ロワール ＜品種＞ムロン・ド・ブルゴーニュ１００％<br />輝きのあるシャンパンゴールド。樹齢６５年の葡萄を使った繊細さとキメの細さを感じるエレガントな仕上がり。</p>', 'price' => '7,500'),
      array('name' => 'ピノグリージョ ロゼ スプマンテ ブリュット🇮🇹<p>ロゼ（辛口）<br />＜産地＞イタリア／ヴェネト ＜品種＞ピノグリージョ１００％<br />溢れる泡はきめ細かく、赤い果実の風味が長く楽しめる優しいロゼスパークリングワイン。</p>', 'price' => '5,800'),
      array('name' => 'クエルチオーリ・レッジアーノ・ランブルスコ🇮🇹<p>赤ワイン（弱発泡性）<br />＜産地＞イタリア／エミリアロマーニャ ＜品種＞ランブルスコ・サラミーノ／ランブルスコ・マラーニ<br />干しイチジクやいちごの豊かな香りで、やや甘口。果実の甘みのバランスの取れた弱発泡性ワインです。</p>', 'price' => '4,000'),
    )),
    array('title' => '赤ワイン（弱発泡性）', 'subtitle' => 'Red sparkling', 'items' => array(
      array('name' => 'クエルチオーリ・レッジアーノ・ランブルスコ🇮🇹<p>＜産地＞フランス／ボーヌ ＜品種＞テンプラニーリョ１００％<br />鮮やかなロゼ色で溢れる泡はきめ細かく、赤果実の風味が刺激的でバランスの取れたフレッシュな味わい。</p>', 'price' => '3,850'),
    )),
    array('title' => '白ワイン（ボトル）', 'subtitle' => 'White wine', 'items' => array(
      array('name' => '＜ジャン・マルク・ラファージュ＞ カディレッタ・シャルドネ🇫🇷<p>＜産地＞フランス／ラングドックルーション ＜品種＞シャルドネ１００％<br />南仏の太陽をたくさん浴びたキリッとドライな辛口な飲み口。合わせやすい１本です。</p>', 'price' => '5,800'),
      array('name' => '＜アルティガ・フュステル＞ ペルラ・デル・マール🇪🇸<p>＜産地＞スペイン／アリカンテ ＜品種＞モスカテル・デ・アレハンドリア１００％<br />地中海の潮風をたっぷり浴びる土壌で育ち、爽やかな味わいとエレガントさを併せ持つ仕上がりです。</p>', 'price' => '4,800'),
      array('name' => '＜シャトー勝沼＞ 甲州 IMAMURA🇯🇵<p>＜産地＞日本／山梨 ＜品種＞甲州１００％<br />発酵後のワインをそのまま春まで寝かせビン詰めしたワインで、新鮮さと味に膨らみを持つワインです。</p>', 'price' => '4,000'),
      array('name' => '＜バリエール・フレール＞ ボルドー・ブラン🇫🇷<p>＜産地＞フランス／ボルドー ＜品種＞ソーヴィニヨンブラン１００％<br />ほのかな樽香と果実味、心地よい渋みも兼ね備えたコクのある辛口。余韻の長さもあります。</p>', 'price' => '5,500'),
    )),
  );
}

function bgv_extract_menu_title_and_description($raw_name) {
  $raw_name = (string) $raw_name;
  $title_html = $raw_name;
  $description_html = '';

  if (preg_match('/^(.*?)<p>(.*?)<\/p>/s', $raw_name, $matches)) {
    $title_html = $matches[1];
    $description_html = $matches[2];
  } else {
    $parts = preg_split('/<br\s*\/?>/i', $raw_name);
    if (is_array($parts) && count($parts) > 1) {
      $title_html = array_shift($parts);
      $description_html = implode("\n", $parts);
    }
  }

  $title = trim(wp_strip_all_tags($title_html));
  $description = trim(wp_strip_all_tags(str_replace(array('<br />', '<br>', '<br/>'), "\n", $description_html)));

  if ($title === '') {
    $title = trim(wp_strip_all_tags($raw_name));
  }

  return array($title, $description);
}

function bgv_default_drink_category($section_title) {
  if (strpos($section_title, 'ビール') !== false) {
    return 'beer';
  }
  if (strpos($section_title, 'ワイン') !== false) {
    return 'wine';
  }
  if (strpos($section_title, 'カクテル') !== false) {
    return 'cocktail';
  }
  if (strpos($section_title, 'ソフト') !== false) {
    return 'soft_drink';
  }
  return 'other';
}

function bgv_default_wine_category($section_title) {
  if (strpos($section_title, '赤') !== false) {
    return 'red_wine';
  }
  if (strpos($section_title, '白') !== false) {
    return 'white_wine';
  }
  if (strpos($section_title, 'スパークリング') !== false || strpos($section_title, 'シャンパ') !== false) {
    return 'sparkling';
  }
  return 'other';
}

function bgv_seed_menu_post_type($post_type, $sections, $category_field = '', $category_callback = '') {
  $existing = get_posts(array(
    'post_type' => $post_type,
    'post_status' => 'any',
    'posts_per_page' => 1,
    'fields' => 'ids',
  ));

  if (! empty($existing)) {
    return;
  }

  $display_order = 10;
  foreach ($sections as $section) {
    $section_title = isset($section['title']) ? $section['title'] : '';
    $items = isset($section['items']) && is_array($section['items']) ? $section['items'] : array();
    foreach ($items as $item) {
      $raw_name = isset($item['name']) ? $item['name'] : '';
      list($title, $description) = bgv_extract_menu_title_and_description($raw_name);
      if ($title === '') {
        continue;
      }

      $post_id = wp_insert_post(array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'post_title' => $title,
        'menu_order' => $display_order,
      ));

      if (! $post_id || is_wp_error($post_id)) {
        continue;
      }

      if ($description === '' && $section_title !== '') {
        $description = $section_title;
      }

      update_post_meta($post_id, 'menu_price', isset($item['price']) ? $item['price'] : '');
      update_post_meta($post_id, 'menu_description', $description);
      update_post_meta($post_id, 'menu_display_order', $display_order);
      update_post_meta($post_id, 'menu_visible', '1');

      if ($category_field && is_callable($category_callback)) {
        update_post_meta($post_id, $category_field, call_user_func($category_callback, $section_title));
      }

      $display_order += 10;
    }
  }
}

function bgv_seed_default_menu_posts() {
  bgv_seed_menu_post_type('lunch_menu', bgv_default_lunch_sections());
  bgv_seed_menu_post_type('dinner_menu', bgv_default_food_sections());
  bgv_seed_menu_post_type('kids_menu', bgv_default_kids_sections());
  bgv_seed_menu_post_type('drink_menu', bgv_default_drink_sections(), 'drink_category', 'bgv_default_drink_category');
  bgv_seed_menu_post_type('wine_menu', bgv_default_wine_sections(), 'wine_category', 'bgv_default_wine_category');
}

function bgv_create_page_if_missing($title, $slug, $template = '') {
  $page = get_page_by_path($slug);
  if ($page) {
    if ($template) {
      update_post_meta($page->ID, '_wp_page_template', $template);
    }
    return $page->ID;
  }

  $page_id = wp_insert_post(array(
    'post_title' => $title,
    'post_name' => $slug,
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_content' => '',
  ));

  if ($page_id && ! is_wp_error($page_id) && $template) {
    update_post_meta($page_id, '_wp_page_template', $template);
  }

  return $page_id;
}

function bgv_ensure_required_pages() {
  $front_id = bgv_create_page_if_missing('トップページ', 'home', 'front-page.php');
  if ($front_id && ! is_wp_error($front_id)) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $front_id);
  }

  bgv_create_page_if_missing('黒板メニュー', 'kokuban', 'page-kokuban.php');
  bgv_create_page_if_missing('ランチ', 'lunch', 'page-lunch.php');
  bgv_create_page_if_missing('ディナー', 'dinner', 'page-dinner.php');
  bgv_create_page_if_missing('お子様セット', 'kids', 'page-kids.php');
  bgv_create_page_if_missing('ドリンク', 'drink', 'page-drink.php');
  bgv_create_page_if_missing('ワインリスト', 'wine', 'page-wine.php');
  bgv_create_page_if_missing('内観＆外観', 'interior-exterior', 'page-interior-exterior.php');
  bgv_create_page_if_missing('ギャラリー', 'gallery', 'page-gallery.php');
  bgv_create_page_if_missing('営業時間＆アクセス', 'access', 'page-access.php');
  bgv_create_page_if_missing('ブログ', 'blog', 'page.php');
  bgv_create_page_if_missing('お知らせ', 'information', 'page.php');
  bgv_create_page_if_missing('アーカイブ', 'archives-1175', 'page.php');
}

function bgv_after_switch_theme() {
  bgv_ensure_required_pages();
  bgv_seed_default_menu_posts();
  update_option('bgv_required_pages_version', BGV_THEME_VERSION);
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'bgv_after_switch_theme');

function bgv_ensure_pages_once_after_update() {
  if (! is_admin()) {
    return;
  }

  if (get_option('bgv_required_pages_version') === BGV_THEME_VERSION) {
    return;
  }

  bgv_ensure_required_pages();
  bgv_seed_default_menu_posts();
  update_option('bgv_required_pages_version', BGV_THEME_VERSION);
  flush_rewrite_rules();
}
add_action('admin_init', 'bgv_ensure_pages_once_after_update');
