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

function bgv_acf_page_menu_fields($prefix, $label, $with_category = false, $category_choices = array()) {
  $fields = array(
    array(
      'key' => 'field_bgv_' . $prefix . '_items_note',
      'label' => $label . '入力について',
      'name' => $prefix . '_items_note',
      'type' => 'message',
      'message' => 'ACF無料版で編集できるよう、メニュー入力欄を80件分用意しています。入力した項目だけフロント画面に表示されます。',
    ),
  );

  for ($i = 1; $i <= 80; $i++) {
    $fields[] = array(
      'key' => 'field_bgv_' . $prefix . '_item_' . $i . '_name',
      'label' => $label . $i . '：メニュー名',
      'name' => $prefix . '_item_' . $i . '_name',
      'type' => 'text',
    );
    if ($with_category) {
      $fields[] = array(
        'key' => 'field_bgv_' . $prefix . '_item_' . $i . '_category',
        'label' => $label . $i . '：カテゴリ',
        'name' => $prefix . '_item_' . $i . '_category',
        'type' => 'select',
        'choices' => $category_choices,
        'allow_null' => 1,
        'ui' => 1,
        'return_format' => 'value',
      );
    }
    $fields[] = array(
      'key' => 'field_bgv_' . $prefix . '_item_' . $i . '_price',
      'label' => $label . $i . '：料金',
      'name' => $prefix . '_item_' . $i . '_price',
      'type' => 'text',
    );
    $fields[] = array(
      'key' => 'field_bgv_' . $prefix . '_item_' . $i . '_description',
      'label' => $label . $i . '：説明文',
      'name' => $prefix . '_item_' . $i . '_description',
      'type' => 'textarea',
      'rows' => 3,
      'new_lines' => 'br',
    );
    $fields[] = array(
      'key' => 'field_bgv_' . $prefix . '_item_' . $i . '_image',
      'label' => $label . $i . '：画像',
      'name' => $prefix . '_item_' . $i . '_image',
      'type' => 'image',
      'return_format' => 'id',
      'preview_size' => 'thumbnail',
    );
    $fields[] = array(
      'key' => 'field_bgv_' . $prefix . '_item_' . $i . '_link_url',
      'label' => $label . $i . '：リンク先URL',
      'name' => $prefix . '_item_' . $i . '_link_url',
      'type' => 'url',
    );
  }

  return $fields;
}

function bgv_acf_lunch_section_fields() {
  $fields = array(
    array(
      'key' => 'field_bgv_lunch_sections_note',
      'label' => 'ランチ入力について',
      'name' => 'lunch_sections_note',
      'type' => 'message',
      'message' => '基準サイトのA/B/C/Dランチ、注意書き、追加料金を保持したまま編集できます。未入力の項目は基準サイトの内容で表示されます。',
    ),
  );

  $defaults = function_exists('bgv_default_lunch_rich_sections') ? bgv_default_lunch_rich_sections() : array();
  for ($section_index = 1; $section_index <= 5; $section_index++) {
    $default_section = isset($defaults[$section_index - 1]) ? $defaults[$section_index - 1] : array();
    $section_label = isset($default_section['label']) ? $default_section['label'] : '';
    $section_title = isset($default_section['title']) ? $default_section['title'] : '';
    $section_description = isset($default_section['description']) ? $default_section['description'] : '';
    $section_note = isset($default_section['note']) ? $default_section['note'] : '';

    $fields[] = array(
      'key' => 'field_bgv_lunch_section_' . $section_index . '_message',
      'label' => 'ランチブロック' . $section_index,
      'name' => 'lunch_section_' . $section_index . '_message',
      'type' => 'message',
      'message' => 'ランチブロック' . $section_index . 'を編集します。',
    );
    $fields[] = array(
      'key' => 'field_bgv_lunch_section_' . $section_index . '_label',
      'label' => 'ブロックラベル',
      'name' => 'lunch_section_' . $section_index . '_label',
      'type' => 'text',
      'default_value' => $section_label,
      'instructions' => '例：A / B / C。空欄にすると見出しを表示しません。',
    );
    $fields[] = array(
      'key' => 'field_bgv_lunch_section_' . $section_index . '_title',
      'label' => 'ブロックタイトル',
      'name' => 'lunch_section_' . $section_index . '_title',
      'type' => 'textarea',
      'rows' => 2,
      'new_lines' => 'br',
      'default_value' => $section_title,
    );
    $fields[] = array(
      'key' => 'field_bgv_lunch_section_' . $section_index . '_description',
      'label' => 'ブロック説明文',
      'name' => 'lunch_section_' . $section_index . '_description',
      'type' => 'textarea',
      'rows' => 3,
      'new_lines' => 'br',
      'default_value' => $section_description,
    );

    $default_items = isset($default_section['items']) && is_array($default_section['items']) ? $default_section['items'] : array();
    for ($item_index = 1; $item_index <= 12; $item_index++) {
      $default_item = isset($default_items[$item_index - 1]) ? $default_items[$item_index - 1] : array();
      $item_name = isset($default_item['name']) ? $default_item['name'] : '';
      $item_description = isset($default_item['description']) ? $default_item['description'] : '';
      $item_note = isset($default_item['note']) ? $default_item['note'] : '';
      $item_price = isset($default_item['price']) ? $default_item['price'] : '';

      $fields[] = array(
        'key' => 'field_bgv_lunch_section_' . $section_index . '_item_' . $item_index . '_name',
        'label' => 'ブロック' . $section_index . ' メニュー' . $item_index . '：メニュー名',
        'name' => 'lunch_section_' . $section_index . '_item_' . $item_index . '_name',
        'type' => 'textarea',
        'rows' => 2,
        'new_lines' => 'br',
        'default_value' => $item_name,
      );
      $fields[] = array(
        'key' => 'field_bgv_lunch_section_' . $section_index . '_item_' . $item_index . '_description',
        'label' => 'ブロック' . $section_index . ' メニュー' . $item_index . '：説明文',
        'name' => 'lunch_section_' . $section_index . '_item_' . $item_index . '_description',
        'type' => 'textarea',
        'rows' => 3,
        'new_lines' => 'br',
        'default_value' => $item_description,
      );
      $fields[] = array(
        'key' => 'field_bgv_lunch_section_' . $section_index . '_item_' . $item_index . '_note',
        'label' => 'ブロック' . $section_index . ' メニュー' . $item_index . '：注意書き',
        'name' => 'lunch_section_' . $section_index . '_item_' . $item_index . '_note',
        'type' => 'textarea',
        'rows' => 3,
        'new_lines' => 'br',
        'default_value' => $item_note,
      );
      $fields[] = array(
        'key' => 'field_bgv_lunch_section_' . $section_index . '_item_' . $item_index . '_price',
        'label' => 'ブロック' . $section_index . ' メニュー' . $item_index . '：料金',
        'name' => 'lunch_section_' . $section_index . '_item_' . $item_index . '_price',
        'type' => 'text',
        'default_value' => $item_price,
      );
      $fields[] = array(
        'key' => 'field_bgv_lunch_section_' . $section_index . '_item_' . $item_index . '_image',
        'label' => 'ブロック' . $section_index . ' メニュー' . $item_index . '：画像',
        'name' => 'lunch_section_' . $section_index . '_item_' . $item_index . '_image',
        'type' => 'image',
        'return_format' => 'id',
        'preview_size' => 'thumbnail',
      );
      $fields[] = array(
        'key' => 'field_bgv_lunch_section_' . $section_index . '_item_' . $item_index . '_link_url',
        'label' => 'ブロック' . $section_index . ' メニュー' . $item_index . '：リンク先URL',
        'name' => 'lunch_section_' . $section_index . '_item_' . $item_index . '_link_url',
        'type' => 'url',
      );
    }

    $fields[] = array(
      'key' => 'field_bgv_lunch_section_' . $section_index . '_note',
      'label' => 'ブロック末尾の補足',
      'name' => 'lunch_section_' . $section_index . '_note',
      'type' => 'textarea',
      'rows' => 3,
      'new_lines' => 'br',
      'default_value' => $section_note,
    );
  }

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
    'key' => 'group_bgv_dinner_menu',
    'title' => 'ディナーメニュー入力',
    'fields' => bgv_acf_menu_fields('dinner'),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'dinner_menu'))),
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
    'key' => 'group_bgv_lunch_page_menu',
    'title' => 'ランチページ メニュー編集',
    'fields' => bgv_acf_lunch_section_fields(),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-lunch.php'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_dinner_page_menu',
    'title' => 'ディナーページ メニュー編集',
    'fields' => bgv_acf_page_menu_fields('dinner', 'ディナーメニュー'),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-dinner.php'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_kids_page_menu',
    'title' => 'お子様セットページ メニュー編集',
    'fields' => bgv_acf_page_menu_fields('kids', 'お子様セット'),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-kids.php'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_drink_page_menu',
    'title' => 'ドリンクページ メニュー編集',
    'fields' => bgv_acf_page_menu_fields('drink', 'ドリンクメニュー', true, array(
      'beer' => 'ビール',
      'wine' => 'ワイン',
      'cocktail' => 'カクテル',
      'soft_drink' => 'ソフトドリンク',
      'other' => 'その他',
    )),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-drink.php'))),
  ));

  acf_add_local_field_group(array(
    'key' => 'group_bgv_wine_page_menu',
    'title' => 'ワインリストページ メニュー編集',
    'fields' => bgv_acf_page_menu_fields('wine', 'ワインリスト', true, array(
      'red_wine' => '赤ワイン',
      'white_wine' => '白ワイン',
      'sparkling' => 'スパークリング',
      'other' => 'その他',
    )),
    'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-wine.php'))),
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
