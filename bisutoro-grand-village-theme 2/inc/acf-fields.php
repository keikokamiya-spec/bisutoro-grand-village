<?php

if (! defined('ABSPATH')) {
  exit;
}

function bgv_acf_text_field($key, $label, $name, $instructions = '') {
  return array(
    'key' => $key,
    'label' => $label,
    'name' => $name,
    'type' => 'text',
    'instructions' => $instructions,
  );
}

function bgv_acf_menu_fields($prefix, $with_category = false, $category_choices = array()) {
  $fields = array();

  if ($with_category) {
    $default_category = '';
    foreach ($category_choices as $category_key => $category_label) {
      $default_category = $category_key;
      break;
    }

    $fields[] = array(
      'key' => 'field_bgv_' . $prefix . '_category',
      'label' => 'カテゴリ',
      'name' => $prefix . '_category',
      'type' => 'select',
      'choices' => $category_choices,
      'default_value' => $default_category,
      'allow_null' => 0,
      'ui' => 1,
      'return_format' => 'value',
    );
  }

  $fields[] = array(
    'key' => 'field_bgv_' . $prefix . '_price',
    'label' => '料金',
    'name' => 'menu_price',
    'type' => 'text',
    'instructions' => '例：1,200 / ALL650円 / 150g 1,980 など',
  );
  $fields[] = array(
    'key' => 'field_bgv_' . $prefix . '_description',
    'label' => '説明文',
    'name' => 'menu_description',
    'type' => 'textarea',
    'rows' => 4,
    'new_lines' => 'br',
  );
  $fields[] = array(
    'key' => 'field_bgv_' . $prefix . '_display_order',
    'label' => '表示順',
    'name' => 'menu_display_order',
    'type' => 'number',
    'default_value' => 100,
    'min' => 0,
  );
  $fields[] = array(
    'key' => 'field_bgv_' . $prefix . '_visible',
    'label' => '表示する',
    'name' => 'menu_visible',
    'type' => 'true_false',
    'default_value' => 1,
    'ui' => 1,
  );

  return $fields;
}

function bgv_register_acf_fields() {
  if (! function_exists('acf_add_local_field_group')) {
    return;
  }

  acf_add_local_field_group(array(
    'key' => 'group_bgv_lunch_menu',
    'title' => 'ランチメニュー入力',
    'fields' => bgv_acf_menu_fields('lunch'),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'lunch_menu'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_kids_menu',
    'title' => 'お子様セット入力',
    'fields' => bgv_acf_menu_fields('kids'),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'kids_menu'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_drink_menu',
    'title' => 'ドリンクメニュー入力',
    'fields' => bgv_acf_menu_fields('drink', true, array(
      'beer' => 'ビール',
      'wine' => 'ワイン',
      'cocktail' => 'カクテル',
      'soft_drink' => 'ソフトドリンク',
      'other' => 'その他',
    )),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'drink_menu'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_wine_menu',
    'title' => 'ワインリスト入力',
    'fields' => bgv_acf_menu_fields('wine', true, array(
      'red_wine' => '赤ワイン',
      'white_wine' => '白ワイン',
      'sparkling' => 'スパークリング',
      'other' => 'その他',
    )),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'wine_menu'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_linked_food_item',
    'title' => '料理画像リンク入力',
    'fields' => array(
      array('key' => 'field_bgv_linked_food_image', 'label' => '画像', 'name' => 'linked_food_image', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium'),
      array('key' => 'field_bgv_linked_food_url', 'label' => 'リンク先URL', 'name' => 'linked_food_url', 'type' => 'url'),
      array('key' => 'field_bgv_linked_food_description', 'label' => '説明文', 'name' => 'linked_food_description', 'type' => 'textarea', 'rows' => 4, 'new_lines' => 'br'),
      array('key' => 'field_bgv_linked_food_display_order', 'label' => '表示順', 'name' => 'linked_food_display_order', 'type' => 'number', 'default_value' => 100, 'min' => 0),
      array('key' => 'field_bgv_linked_food_visible', 'label' => '表示する', 'name' => 'linked_food_visible', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1),
    ),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'linked_food_item'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_blackboard',
    'title' => '黒板メニュー編集',
    'fields' => array(
      bgv_acf_text_field('field_bgv_blackboard_heading', 'ページ見出し', 'blackboard_heading'),
      array('key' => 'field_bgv_blackboard_description', 'label' => '説明文', 'name' => 'blackboard_description', 'type' => 'textarea', 'rows' => 4, 'new_lines' => 'br', 'default_value' => "ご予算に応じてコース料理でお作りする事や\nアラカルトメニューもご注文可能です。\nお気軽にお問い合わせ下さい"),
      array('key' => 'field_bgv_blackboard_image_1', 'label' => '黒板メニュー画像1', 'name' => 'blackboard_image_1', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium'),
      bgv_acf_text_field('field_bgv_blackboard_image_1_alt', '黒板メニュー画像1 alt', 'blackboard_image_1_alt'),
      array('key' => 'field_bgv_blackboard_image_2', 'label' => '黒板メニュー画像2', 'name' => 'blackboard_image_2', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium'),
      bgv_acf_text_field('field_bgv_blackboard_image_2_alt', '黒板メニュー画像2 alt', 'blackboard_image_2_alt'),
    ),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-kokuban.php'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_access',
    'title' => '営業時間＆アクセス編集',
    'fields' => array(
      bgv_acf_text_field('field_bgv_store_name', '店舗名', 'store_name'),
      bgv_acf_text_field('field_bgv_postal_code', '郵便番号', 'postal_code'),
      array('key' => 'field_bgv_address', 'label' => '住所', 'name' => 'address', 'type' => 'textarea', 'rows' => 3, 'new_lines' => 'br'),
      bgv_acf_text_field('field_bgv_phone_number', '電話番号', 'phone_number'),
      array('key' => 'field_bgv_business_hours', 'label' => '営業時間', 'name' => 'business_hours', 'type' => 'textarea', 'rows' => 4, 'new_lines' => 'br'),
      array('key' => 'field_bgv_regular_holiday', 'label' => '定休日', 'name' => 'regular_holiday', 'type' => 'textarea', 'rows' => 3, 'new_lines' => 'br'),
      bgv_acf_text_field('field_bgv_lunch_hours', 'ランチ営業時間', 'lunch_hours'),
      bgv_acf_text_field('field_bgv_dinner_hours', 'ディナー営業時間', 'dinner_hours'),
      array('key' => 'field_bgv_access_text', 'label' => 'アクセス説明文', 'name' => 'access_text', 'type' => 'textarea', 'rows' => 3, 'new_lines' => 'br'),
      bgv_acf_text_field('field_bgv_google_map_embed_url', 'Googleマップ埋め込みURL', 'google_map_embed_url', 'iframeタグ全体ではなく、Google Mapsの埋め込みURLだけを入力してください。'),
      bgv_acf_text_field('field_bgv_google_map_link_url', 'GoogleマップリンクURL', 'google_map_link_url'),
      array('key' => 'field_bgv_parking_info', 'label' => '駐車場情報', 'name' => 'parking_info', 'type' => 'textarea', 'rows' => 3, 'new_lines' => 'br'),
      array('key' => 'field_bgv_remarks', 'label' => '備考', 'name' => 'remarks', 'type' => 'textarea', 'rows' => 4, 'new_lines' => 'br'),
    ),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-access.php'))),
  ));

  $gallery_fields = array();
  for ($i = 1; $i <= 70; $i++) {
    $gallery_fields[] = array(
      'key' => 'field_bgv_gallery_image_' . $i,
      'label' => 'ギャラリー画像' . $i,
      'name' => 'gallery_image_' . $i,
      'type' => 'image',
      'return_format' => 'id',
      'preview_size' => 'thumbnail',
    );
    $gallery_fields[] = bgv_acf_text_field('field_bgv_gallery_image_' . $i . '_alt', 'ギャラリー画像' . $i . ' alt', 'gallery_image_' . $i . '_alt');
  }

  acf_add_local_field_group(array(
    'key' => 'group_bgv_gallery',
    'title' => 'ギャラリー画像編集',
    'fields' => $gallery_fields,
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-gallery.php'))),
  ));
}
add_action('acf/init', 'bgv_register_acf_fields');
