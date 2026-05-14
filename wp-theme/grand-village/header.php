<?php
if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="viewport" content="width=device-width,minimum-scale=1" />
<link rel="shortcut icon" href="<?php echo gv_asset('favicon.ico'); ?>" />
<link rel="icon" href="<?php echo gv_asset('favicon.ico'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="sub">
<?php wp_body_open(); ?>
<header id="fixed_header">
  <div class="logo">
    <a href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo gv_asset('images/assets/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" />
    </a>
  </div>

  <a id="menu_bars">
    <i id="menu_open" class="fa fa-bars" aria-hidden="true"></i>
    <i id="menu_close" class="fa fa-times" aria-hidden="true"></i>Menu
  </a>

  <nav>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'global',
        'container' => false,
        'menu_class' => 'header_menu',
        'fallback_cb' => 'gv_fallback_menu',
    ));
    ?>
  </nav>

  <a href="tel:045-305-6619" id="sp_phone">
    <i class="fa fa-phone" aria-hidden="true"></i>Call
  </a>
</header>
<div id="fixed_end"></div>
