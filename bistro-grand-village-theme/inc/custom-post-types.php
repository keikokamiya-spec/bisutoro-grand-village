<?php

if (! defined('ABSPATH')) {
  exit;
}

function bgv_register_menu_post_type($post_type, $singular, $plural, $menu_icon) {
  register_post_type($post_type, array(
    'labels' => array(
      'name' => $plural,
      'singular_name' => $singular,
      'add_new_item' => $singular . 'を追加',
      'edit_item' => $singular . 'を編集',
      'new_item' => '新しい' . $singular,
      'view_item' => $singular . 'を表示',
      'search_items' => $plural . 'を検索',
      'not_found' => $plural . 'が見つかりません',
      'not_found_in_trash' => 'ゴミ箱に' . $plural . 'はありません',
    ),
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 25,
    'menu_icon' => $menu_icon,
    'supports' => array('title', 'page-attributes'),
    'has_archive' => false,
    'rewrite' => false,
    'show_in_rest' => true,
  ));
}

function bgv_register_custom_post_types() {
  bgv_register_menu_post_type('lunch_menu', 'ランチメニュー', 'ランチメニュー', 'dashicons-food');
  bgv_register_menu_post_type('dinner_menu', 'ディナーメニュー', 'ディナーメニュー', 'dashicons-carrot');
  bgv_register_menu_post_type('kids_menu', 'お子様セット', 'お子様セット', 'dashicons-smiley');
  bgv_register_menu_post_type('drink_menu', 'ドリンクメニュー', 'ドリンクメニュー', 'dashicons-coffee');
  bgv_register_menu_post_type('wine_menu', 'ワインリスト', 'ワインリスト', 'dashicons-beer');
  bgv_register_menu_post_type('linked_food_item', '料理画像リンク', '料理画像リンク', 'dashicons-format-image');
}
add_action('init', 'bgv_register_custom_post_types');

function bgv_menu_admin_columns($columns) {
  $new_columns = array();
  foreach ($columns as $key => $label) {
    $new_columns[$key] = $label;
    if ($key === 'title') {
      $new_columns['menu_price'] = '料金';
      $new_columns['menu_order_field'] = '表示順';
      $new_columns['menu_visible_field'] = '表示';
    }
  }

  return $new_columns;
}

function bgv_menu_admin_column_content($column, $post_id) {
  if ($column === 'menu_price') {
    echo esc_html(get_post_meta($post_id, 'menu_price', true));
  } elseif ($column === 'menu_order_field') {
    echo esc_html(get_post_meta($post_id, 'menu_display_order', true));
  } elseif ($column === 'menu_visible_field') {
    $visible = get_post_meta($post_id, 'menu_visible', true);
    echo $visible === '0' ? '非表示' : '表示';
  }
}

foreach (array('lunch_menu', 'dinner_menu', 'kids_menu', 'drink_menu', 'wine_menu') as $bgv_menu_post_type) {
  add_filter('manage_' . $bgv_menu_post_type . '_posts_columns', 'bgv_menu_admin_columns');
  add_action('manage_' . $bgv_menu_post_type . '_posts_custom_column', 'bgv_menu_admin_column_content', 10, 2);
}
