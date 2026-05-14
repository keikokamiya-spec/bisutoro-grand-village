<?php
if (!defined('ABSPATH')) {
    exit;
}

function gv_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(array(
        'global' => 'グローバルナビ',
    ));
}
add_action('after_setup_theme', 'gv_setup');

function gv_enqueue_assets()
{
    $uri = get_template_directory_uri();

    wp_enqueue_style('gv-wp-blocks', $uri . '/css/wp-block-library-style.min.css', array(), '1.0.0');
    wp_enqueue_style('gv-style-main', $uri . '/css/style.css', array('gv-wp-blocks'), '1.0.0');
    wp_enqueue_style('gv-base', $uri . '/css/base.css', array('gv-style-main'), '1.0.0');

    wp_enqueue_script('gv-bootstrap', $uri . '/js/bootstrap.js', array('jquery'), '2.3.2', true);
    wp_enqueue_script('gv-flexslider', $uri . '/js/jquery.flexslider.js', array('jquery'), '2.2.2', true);
    wp_enqueue_script('gv-magnific-popup', $uri . '/js/jquery.magnific-popup.js', array('jquery'), '0.9.2', true);
    wp_enqueue_script('gv-masonry', $uri . '/js/masonry.pkgd.min.js', array('jquery'), '4.0.0', true);
    wp_enqueue_script('gv-custom', $uri . '/js/custom.js', array('jquery', 'gv-magnific-popup'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'gv_enqueue_assets');

function gv_register_editable_content()
{
    register_post_type('gallery_photo', array(
        'labels' => array(
            'name' => 'ギャラリー写真',
            'singular_name' => 'ギャラリー写真',
            'add_new_item' => 'ギャラリー写真を追加',
            'edit_item' => 'ギャラリー写真を編集',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => array('title', 'thumbnail', 'page-attributes'),
        'show_in_rest' => true,
    ));

    register_post_type('blackboard_photo', array(
        'labels' => array(
            'name' => '黒板メニュー写真',
            'singular_name' => '黒板メニュー写真',
            'add_new_item' => '黒板メニュー写真を追加',
            'edit_item' => '黒板メニュー写真を編集',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => array('title', 'thumbnail', 'page-attributes'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'gv_register_editable_content');

function gv_price_defaults()
{
    return array(
        'kids_pasta' => array('label' => 'お子様 ベーコンとキノコのトマトスパゲッティ', 'default' => '1,000'),
        'kids_carbonara' => array('label' => 'お子様 みんな大好き カルボナーラ', 'default' => '1,000'),
        'kids_risotto' => array('label' => 'お子様 いろいろキノコのクリームリゾット', 'default' => '1,000'),
        'kids_hamburg' => array('label' => 'お子様 煮込みハンバーグのデミグラスソース', 'default' => '1,200'),
    );
}

function gv_customize_register($wp_customize)
{
    $wp_customize->add_section('gv_prices', array(
        'title' => '料金設定',
        'priority' => 35,
        'description' => 'サイト上に表示する一部料金を編集できます。',
    ));

    foreach (gv_price_defaults() as $key => $price) {
        $setting = 'gv_price_' . $key;
        $wp_customize->add_setting($setting, array(
            'default' => $price['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control($setting, array(
            'label' => $price['label'],
            'section' => 'gv_prices',
            'type' => 'text',
        ));
    }
}
add_action('customize_register', 'gv_customize_register');

function gv_price($key)
{
    $defaults = gv_price_defaults();
    $default = isset($defaults[$key]) ? $defaults[$key]['default'] : '';
    return esc_html(get_theme_mod('gv_price_' . $key, $default));
}

function gv_asset($path)
{
    return esc_url(get_template_directory_uri() . '/' . ltrim($path, '/'));
}

function gv_category_label()
{
    if (is_category('lunch')) {
        return 'ランチ';
    }

    if (is_category('kokuban')) {
        return '黒板メニュー';
    }

    if (is_category('information')) {
        return 'お知らせ';
    }

    if (is_category('blog')) {
        return 'ブログ';
    }

    if (is_category('dishes')) {
        return 'お料理';
    }

    $category = get_queried_object();
    return $category && !empty($category->name) ? $category->name : get_the_title();
}

function gv_post_title_label()
{
    if (has_category('lunch')) {
        return 'ランチ';
    }

    if (has_category('kokuban')) {
        return '黒板メニュー';
    }

    return 'お知らせ';
}

function gv_sidebar_categories()
{
    return array(
        'dishes' => 'お料理',
        'information' => 'お知らせ',
        'blog' => 'ブログ',
        'lunch' => 'ランチ',
        'kokuban' => '黒板メニュー',
    );
}

function gv_fallback_menu()
{
    $items = array(
        array('黒板メニュー', home_url('/archives/category/kokuban/')),
        array('ランチ', home_url('/archives/category/lunch/')),
        array('ディナーメニュー', home_url('/food/')),
        array('お子様セット', home_url('/kids/')),
        array('ドリンク', home_url('/drink/')),
        array('ワインリスト', home_url('/wine/')),
        array('内観＆外観', home_url('/interior-exterior/')),
        array('ギャラリー', home_url('/gallery/')),
        array('営業時間＆アクセス', home_url('/#home_access')),
    );

    echo '<ul class="header_menu">';
    foreach ($items as $item) {
        echo '<li class="menu-item"><a href="' . esc_url($item[1]) . '">' . esc_html($item[0]) . '</a></li>';
    }
    echo '</ul>';
}
