<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<?php wp_head(); ?>
</head>
<body id="<?php echo is_front_page() ? 'home' : 'sub'; ?>" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="fixed_header">
  <?php if (is_front_page()) : ?>
    <h1 class="logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></a></h1>
  <?php else : ?>
    <div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></a></div>
  <?php endif; ?>

  <nav>
    <?php
    wp_nav_menu(array(
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'header_menu',
      'fallback_cb'    => 'bgv_fallback_navigation',
      'depth'          => 1,
    ));
    ?>
  </nav>

  <button id="menu_bars" aria-label="メニューを開く" aria-expanded="false">
    <i id="menu_open"  class="fa fa-bars"  aria-hidden="true"></i>
    <i id="menu_close" class="fa fa-times" aria-hidden="true"></i>
    Menu
  </button>
</header>

<div id="fixed_end"></div>

<?php if (!is_front_page()) : ?>
<div class="page-hero">
  <div class="container">
    <?php if (is_singular('page')) : ?>
      <h1><?php the_title(); ?></h1>
      <span class="page-hero-en"><?php echo esc_html(get_post_meta(get_the_ID(), 'page_title_en', true)); ?></span>
    <?php else : ?>
      <h1><?php wp_title('', true, ''); ?></h1>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<!-- SP Fixed Bottom Bar -->
<div id="sp_fixed_bar">
  <div class="sp-bar-inner">
    <?php
    $access_page = get_page_by_path('access');
    $access_post_id = $access_page ? $access_page->ID : false;
    $phone_number = bgv_get_field('phone_number', '045-305-6619', $access_post_id);
    $tel_href = preg_replace('/[^0-9+]/', '', $phone_number);
    $map_link = bgv_get_field('google_map_link_url', '', $access_post_id);
    ?>
    <a href="tel:<?php echo esc_attr($tel_href); ?>" class="sp-bar-tel">
      <i class="fa fa-phone" aria-hidden="true"></i>
      <span>電話</span>
    </a>
    <?php if ($map_link) : ?>
    <a href="<?php echo esc_url($map_link); ?>" target="_blank" rel="noopener">
      <i class="fa fa-map-marker" aria-hidden="true"></i>
      <span>地図</span>
    </a>
    <?php endif; ?>
    <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener">
      <i class="fa fa-instagram" aria-hidden="true"></i>
      <span>予約</span>
    </a>
    <a href="<?php echo esc_url(home_url('/access')); ?>">
      <i class="fa fa-clock-o" aria-hidden="true"></i>
      <span>営業時間</span>
    </a>
  </div>
</div>
