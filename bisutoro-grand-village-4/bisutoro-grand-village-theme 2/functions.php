<?php

if (! defined('ABSPATH')) {
  exit;
}

define('BGV_THEME_VERSION', '1.1.0');

require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/acf-fields.php';

function bgv_asset_uri($path = '') {
  return esc_url(get_template_directory_uri() . '/' . ltrim($path, '/'));
}

function bgv_asset_path($path = '') {
  return get_template_directory() . '/' . ltrim($path, '/');
}

function bgv_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'bgv_setup');

function bgv_enqueue_assets() {
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

function bgv_nav_items() {
  return array(
    array('label' => '黒板メニュー', 'slug' => 'kokuban'),
    array('label' => 'ランチ', 'slug' => 'lunch'),
    array('label' => 'ディナーメニュー', 'slug' => 'food'),
    array('label' => 'お子様セット', 'slug' => 'kids'),
    array('label' => 'ドリンク', 'slug' => 'drink'),
    array('label' => 'ワインリスト', 'slug' => 'wine'),
    array('label' => '内観＆外観', 'slug' => 'interior-exterior'),
    array('label' => 'ギャラリー', 'slug' => 'gallery'),
    array('label' => '営業時間＆アクセス', 'slug' => 'access'),
  );
}

function bgv_page_link($slug) {
  $page = get_page_by_path($slug);
  return $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');
}

function bgv_current_slug() {
  if (is_page()) {
    $post = get_post();
    return $post ? $post->post_name : '';
  }
  return '';
}

function bgv_get_field($name, $default = null, $post_id = null) {
  if (function_exists('get_field')) {
    $value = get_field($name, $post_id ?: false);
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
  $href = $url ?: $image;
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

    return $order_a <=> $order_b;
  });

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
        <dt class="cate"><?php echo esc_html($group_labels[$group] ?? $group); ?></dt>
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
        $href = $link_url ?: $image_url;
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
        $image = bgv_image_url($item['menu_image'] ?? '', '');
        $items[] = array(
          'name' => $item['menu_name'] ?? '',
          'price' => $item['menu_price'] ?? '',
          'image' => $image,
          'url' => $item['menu_url'] ?? '',
          'note' => $item['menu_note'] ?? '',
        );
      }
    }
    $normalized[] = array(
      'title' => $section['section_title'] ?? '',
      'subtitle' => $section['section_subtitle'] ?? '',
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
      <?php foreach (($section['items'] ?? array()) as $item) : ?>
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

  $sections = get_field('menu_sections', $post_id ?: false);
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

  return $content;
}

function bgv_default_kokuban_images() {
  return array(
    array('url' => bgv_asset_uri('assets/images/assets/kokuban-menu-1.png'), 'width' => 945, 'height' => 705),
    array('url' => bgv_asset_uri('assets/images/assets/kokuban-menu-2.png'), 'width' => 934, 'height' => 698),
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
    array('title' => 'D(数量限定)', 'items' => array(
      array('name' => '・牛すじカレー<br />(サラダ・スープ付)', 'price' => '￥1300'),
    )),
    array('title' => 'ランチ限定・追加', 'items' => array(
      array('name' => '＊ディナーメニューもご用意可能です！<br />スタッフまでお気軽にお尋ねください。<br />（在庫がないメニューもある場合がございます）'),
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
    array('name' => '（全てバゲット、ソフトドリンク、バニラアイス付き）'),
    array('name' => 'ベーコンとキノコのトマトスパゲッティ', 'price' => '1,000'),
    array('name' => 'みんな大好き カルボナーラ', 'price' => '1,000'),
    array('name' => 'いろいろキノコのクリームリゾット', 'price' => '1,000'),
    array('name' => '煮込みハンバーグのデミグラスソース', 'price' => '1,200'),
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
      array('name' => 'シェフおまかせ前菜７種盛り合わせ（2名様分）', 'price' => '1,800', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/オードブル盛り合わせ.jpg')),
      array('name' => '８品目の菜園風サラダ', 'price' => '1,200', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/菜園風サラダ.jpg')),
      array('name' => '鴨胸肉のスモークとクレソンのサラダ仕立て〜バルサミコソース〜', 'price' => '1,450'),
      array('name' => 'フレンチポテトのスパイス和え', 'price' => '650'),
      array('name' => 'アンチョビキャベツソテー', 'price' => '650'),
      array('name' => 'ほうれん草とベーコンのオムレツ', 'price' => '1,100'),
      array('name' => 'あつあつ オニオングラタンスープ', 'price' => '900'),
      array('name' => '本日の野菜のポタージュ', 'price' => '900'),
      array('name' => 'お酒のお供３種盛り合わせ<br /><span class="fs80">仏産 ミモレットチーズ／仏産 熟成サラミ／伊産 生ハム</span>', 'price' => '1,500<span>ハーフ</span>750'),
    )),
    array('title' => '魚介', 'subtitle' => 'poisons', 'items' => array(
      array('name' => '殻付き生牡蠣<span class="fs80">（産地は黒板をご覧ください）</span>', 'price' => '500', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/生牡蠣.jpg')),
      array('name' => '海老とアボカドのカクテルソース', 'price' => '1,350'),
      array('name' => 'ズワイガニとアボカドのコンソメジュレがけ ～カリフラワーのムース添え～', 'price' => '1,450', 'url' => 'https://grand-village.yokohama/archives/52'),
      array('name' => '大分県豊後水道産 天然真鯛のカルパッチョ仕立て', 'price' => '1,600', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/真鯛のカルパッチョ.jpg')),
      array('name' => 'カニミソとマスカルポーネチーズのディップ<span class="fs80">（バゲット付き）</span>', 'price' => '1,100'),
      array('name' => 'ヤリイカとポワロー（西洋ねぎ）のフリット カラスミパウダーがけ', 'price' => '1,400'),
      array('name' => '本日のお魚料理（スタッフまでお尋ね下さい）', 'price' => '1,800'),
      array('name' => 'ツブ貝とキノコのソテー ～香草バターソース～', 'price' => '1,650', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/ツブ貝のソテー香草バターソース.jpg')),
    )),
    array('title' => '肉', 'subtitle' => 'viands', 'items' => array(
      array('name' => 'フォアグラのソテー ～ポルト酒のソース～', 'price' => '1,980', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/フォアグラのソテー.jpg')),
      array('name' => '牛ハラミ肉のグリルと彩り野菜 ～マデイラソース～', 'price' => '<span>150g</span>1,980<span>200g</span>2,480<span>250g</span>2,980', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/牛ハラミ肉のグリルマディラソース.jpg')),
      array('name' => '仔羊のロースト（ラムチョップ）１本', 'price' => '1,600'),
      array('name' => '鴨胸肉のロースト赤ワインとゴルゴンゾーラのソース', 'price' => '1,980', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/鴨肉のロースト赤ワイン.jpg')),
      array('name' => '地鶏“あべどり”のグリル 粒マスタードソース', 'price' => '1,450', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/あべ鶏のグリル粒マスタードソース.jpg')),
      array('name' => '岩中（いわちゅう）豚 肩ロースのグリルと彩り野菜〜バルサミコソース〜', 'price' => '1,600'),
      array('name' => 'ガーリックトースト<span class="fs80">（３枚）</span>', 'price' => '550'),
      array('name' => 'バゲット<span class="fs80">（２枚）</span>', 'price' => '350'),
    )),
    array('title' => 'パスタ＆リゾット', 'subtitle' => 'pasta & risotto', 'items' => array(
      array('name' => '広島産カキのクリームリゾット 又はスパゲッティ', 'price' => '1,600', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/牡蠣のクリームリゾット.jpg')),
      array('name' => 'ズワイガニとカブのリゾット～柚子の香り～', 'price' => '1,500', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/ズワイガニとカブのリゾット.jpg')),
      array('name' => 'アスパラガスとキノコのリゾット', 'price' => '1,350', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/アスパラとキノコのリゾット.jpg')),
      array('name' => 'ポルチーニ茸と数種キノコのリゾット 又はスパゲッティ', 'price' => '1,650', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/ポルチーニのリゾット.jpg')),
      array('name' => 'シラスのペペロンチーノ カラスミパウダーがけ', 'price' => '1,550', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/シラスのペペロンチーノ.jpg')),
      array('name' => 'スパゲッティ カルボナーラ', 'price' => '1,350', 'image' => bgv_asset_uri('assets/images/uploads/2021/08/イベリコベーコンのカルボナーラ.jpg')),
      array('name' => 'スパゲッティ アマトリチャーナ（イベリコ豚ベーコンと玉ねぎのトマトソース）', 'price' => '1,350', 'image' => bgv_asset_uri('assets/images/uploads/2021/02/スパゲッティアマトリチャーナ.jpg')),
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

function bgv_after_switch_theme() {
  $front_id = bgv_create_page_if_missing('トップページ', 'top');
  if ($front_id && ! is_wp_error($front_id)) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $front_id);
  }

  bgv_create_page_if_missing('黒板メニュー', 'kokuban', 'page-kokuban.php');
  bgv_create_page_if_missing('ランチ', 'lunch', 'page-lunch.php');
  bgv_create_page_if_missing('ディナーメニュー', 'food', 'page-dinner.php');
  bgv_create_page_if_missing('お子様セット', 'kids', 'page-kids.php');
  bgv_create_page_if_missing('ドリンク', 'drink', 'page-drink.php');
  bgv_create_page_if_missing('ワインリスト', 'wine', 'page-wine.php');
  bgv_create_page_if_missing('内観＆外観', 'interior-exterior', 'page-interior-exterior.php');
  bgv_create_page_if_missing('ギャラリー', 'gallery', 'page-gallery.php');
  bgv_create_page_if_missing('営業時間＆アクセス', 'access', 'page-access.php');

  flush_rewrite_rules();
}
add_action('after_switch_theme', 'bgv_after_switch_theme');
