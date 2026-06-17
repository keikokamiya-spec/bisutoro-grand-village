<?php
$footer_access_page = get_page_by_path('access');
$footer_access_post_id = $footer_access_page ? $footer_access_page->ID : false;
$footer_store_name = bgv_get_field('store_name', 'ビストロ グランヴィラージュ', $footer_access_post_id);
$footer_postal_code = bgv_get_field('postal_code', '〒231-0846', $footer_access_post_id);
$footer_address = bgv_get_field('address', '神奈川県横浜市中区大和町2-50-7<br />ヴィラ山手1F', $footer_access_post_id);
$footer_phone_number = bgv_get_field('phone_number', '045-305-6619', $footer_access_post_id);
$footer_tel_href = preg_replace('/[^0-9+]/', '', $footer_phone_number);
?>
<footer class="site_footer">
  <div class="footer_inner">
    <div class="footer_brand">
      <img src="<?php echo bgv_asset_uri('assets/images/assets/logo_footer.png'); ?>" width="120" class="marg-bottom15" alt="ビストロ グランヴィラージュ" />
      <p class="footer_store_name"><?php echo esc_html($footer_store_name); ?></p>
    </div>

    <div class="footer_info">
      <p><?php echo esc_html($footer_postal_code); ?><br /><?php echo wp_kses_post($footer_address); ?></p>
      <p><a href="tel:<?php echo esc_attr($footer_tel_href); ?>"><?php echo esc_html($footer_phone_number); ?></a></p>
    </div>

    <div class="footer_social">
      <a href="https://www.facebook.com/grandvillage.yokohama/" target="_blank" rel="noopener"><img src="<?php echo bgv_asset_uri('assets/images/assets/icon_fb.png'); ?>" alt="Facebook" /></a>
      <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener"><img src="<?php echo bgv_asset_uri('assets/images/assets/icon_instagram.png'); ?>" alt="Instagram" /></a>
    </div>
  </div>

  <p class="footer_copy">Copyright &copy; <a href="<?php echo esc_url(home_url('/')); ?>">ビストロ グランヴィラージュ</a> All Rights Reserved. | Designed by <a href="https://www.8th-ocean.co.jp/" target="_blank" rel="noopener">8thOcean.</a></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
