<?php
$access_page = get_page_by_path('access');
$access_post_id = $access_page ? $access_page->ID : false;
$phone_number = bgv_get_field('phone_number', '045-305-6619', $access_post_id);
$tel_href = preg_replace('/[^0-9+]/', '', $phone_number);
$map_link_url = bgv_get_field('google_map_link_url', 'https://maps.app.goo.gl/Ym4ZGtmjGiWyQnEP8', $access_post_id);
?>
<footer>
  <p class="footer-logo">
    <img src="<?php echo bgv_asset_uri('assets/images/assets/logo_footer.png'); ?>" alt="ビストロ グランヴィラージュ" />
  </p>
  <p class="footer-furigana">〜ビストロ　グランヴィラージュ〜</p>
  <div class="footer_social">
    <a href="https://www.facebook.com/grandvillage.yokohama/" target="_blank" rel="noopener" aria-label="Facebook">
      <img src="<?php echo bgv_asset_uri('assets/images/assets/icon_fb.png'); ?>" alt="Facebook" />
    </a>
    <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener" aria-label="Instagram">
      <img src="<?php echo bgv_asset_uri('assets/images/assets/icon_instagram.png'); ?>" alt="Instagram" />
    </a>
  </div>
</footer>
<?php if (is_front_page()) : ?>
</div>
<div id="sp_fixed_bar">
  <div class="sp-bar-inner">
    <a href="tel:<?php echo esc_attr($tel_href); ?>" class="sp-bar-tel">
      <i class="fa fa-phone" aria-hidden="true"></i>
      <span>電話</span>
    </a>
    <a href="<?php echo esc_url($map_link_url); ?>" target="_blank" rel="noopener">
      <i class="fa fa-map-marker" aria-hidden="true"></i>
      <span>地図</span>
    </a>
    <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener">
      <i class="fa fa-instagram" aria-hidden="true"></i>
      <span>予約</span>
    </a>
    <a href="<?php echo esc_url(home_url('/#home_access')); ?>">
      <i class="fa fa-clock-o" aria-hidden="true"></i>
      <span>営業時間</span>
    </a>
  </div>
</div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
