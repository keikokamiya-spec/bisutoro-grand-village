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
    <h1 class="logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo bgv_asset('images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></a></h1>
  <?php else : ?>
    <div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo bgv_asset('images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></a></div>
  <?php endif; ?>

  <a id="menu_bars">
    <i id="menu_open" class="fa fa-bars" aria-hidden="true"></i>
    <i id="menu_close" class="fa fa-times" aria-hidden="true"></i>Menu
  </a>

  <nav>
    <ul class="header_menu">
      <?php foreach (bgv_nav_items() as $item) : ?>
        <li<?php echo bgv_is_active_slug($item['slug']) ? ' class="active"' : ''; ?>><a href="<?php echo bgv_page_url($item['slug']); ?>"><?php echo esc_html($item['label']); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <a href="tel:045-305-6619" id="sp_phone">
    <i class="fa fa-phone" aria-hidden="true"></i>Call
  </a>
</header>
<div id="fixed_end"></div>
