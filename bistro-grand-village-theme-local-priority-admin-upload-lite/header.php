<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="viewport" content="width=device-width,minimum-scale=1" />
<?php wp_head(); ?>
</head>
<body id="<?php echo is_front_page() ? 'home' : 'sub'; ?>" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="fixed_header">
  <?php if (is_front_page()) : ?>
    <h1 class="logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" />
        <span class="logo-furigana">〜ビストロ　グランヴィラージュ〜</span>
      </a>
    </h1>
  <?php else : ?>
    <div class="logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" />
        <span class="logo-furigana">〜ビストロ　グランヴィラージュ〜</span>
      </a>
    </div>
  <?php endif; ?>

  <button id="menu_bars" aria-label="メニューを開く" aria-expanded="false">
    <i id="menu_open" class="fa fa-bars" aria-hidden="true"></i>
    <i id="menu_close" class="fa fa-times" aria-hidden="true"></i>
    Menu
  </button>

  <nav>
    <?php
    wp_nav_menu(array(
      'theme_location' => 'primary',
      'container' => false,
      'menu_class' => 'header_menu',
      'fallback_cb' => 'bgv_fallback_navigation',
      'depth' => 1,
    ));
    ?>
  </nav>
</header>
<div id="fixed_end"></div>
<?php if (is_front_page()) : ?>
<div class="l-stage p-home" id="js-stage">
<?php endif; ?>
