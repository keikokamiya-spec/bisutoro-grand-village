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
  <?php
  $bgv_access_page = get_page_by_path('access');
  $bgv_access_post_id = $bgv_access_page ? $bgv_access_page->ID : false;
  $bgv_phone_number = bgv_get_field('phone_number', '045-305-6619', $bgv_access_post_id);
  $bgv_tel_href = preg_replace('/[^0-9+]/', '', $bgv_phone_number);
  ?>
  <div class="header_inner">
    <?php if (is_front_page()) : ?>
      <h1 class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <span class="logo_mark"><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></span>
          <span class="logo_texts">
            <span class="logo_copy">Bistrot Grand Village</span>
            <span class="logo_furigana">〜ビストロ　グランヴィラージュ〜</span>
          </span>
        </a>
      </h1>
    <?php else : ?>
      <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <span class="logo_mark"><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></span>
          <span class="logo_texts">
            <span class="logo_copy">Bistrot Grand Village</span>
            <span class="logo_furigana">〜ビストロ　グランヴィラージュ〜</span>
          </span>
        </a>
      </div>
    <?php endif; ?>

    <div class="header_actions">
      <a href="tel:<?php echo esc_attr($bgv_tel_href); ?>" id="sp_phone">
        <span class="phone_label">Tel</span>
        <span class="phone_number"><?php echo esc_html($bgv_phone_number); ?></span>
      </a>

      <a id="menu_bars" href="#" aria-controls="site_navigation" aria-expanded="false">
        <i id="menu_open" class="fa fa-bars" aria-hidden="true"></i>
        <i id="menu_close" class="fa fa-times" aria-hidden="true"></i>
        <span class="menu_label">Menu</span>
      </a>
    </div>
  </div>

  <nav id="site_navigation" aria-label="グローバルナビゲーション">
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
