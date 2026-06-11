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
  bgv_register_menu_post_type('kids_menu', 'お子様セット', 'お子様セット', 'dashicons-smiley');
  bgv_register_menu_post_type('drink_menu', 'ドリンクメニュー', 'ドリンクメニュー', 'dashicons-coffee');
  bgv_register_menu_post_type('wine_menu', 'ワインリスト', 'ワインリスト', 'dashicons-carrot');
  bgv_register_menu_post_type('linked_food_item', '料理画像リンク', '料理画像リンク', 'dashicons-format-image');
}
add_action('init', 'bgv_register_custom_post_types');

