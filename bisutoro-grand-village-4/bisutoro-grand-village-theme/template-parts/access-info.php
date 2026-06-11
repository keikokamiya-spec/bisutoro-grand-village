<?php
$access_page    = get_page_by_path('access');
$access_post_id = $access_page ? $access_page->ID : get_the_ID();

$store_name      = bgv_get_field('store_name',          'ビストロ グランヴィラージュ', $access_post_id);
$postal_code     = bgv_get_field('postal_code',         '〒231-0846', $access_post_id);
$address         = bgv_get_field('address',             '神奈川県横浜市中区大和町2-50-7<br />ヴィラ山手1F', $access_post_id);
$phone_number    = bgv_get_field('phone_number',        '045-305-6619', $access_post_id);
$access_text     = bgv_get_field('access_text',         'JR京浜東北根岸線山手駅より１分', $access_post_id);
$lunch_hours     = bgv_get_field('lunch_hours',         '11:30〜14:30（L.O. 14:00）', $access_post_id);
$dinner_hours    = bgv_get_field('dinner_hours',        '17:30〜22:00（L.O. 21:00）', $access_post_id);
$regular_holiday = bgv_get_field('regular_holiday',     '定休日：日曜日、月曜日<br />火曜日のランチ（祝日の場合は変更あり）', $access_post_id);
$business_hours  = bgv_get_field('business_hours',      '', $access_post_id);
$map_embed_url   = bgv_get_field('google_map_embed_url','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3251.075783275786!2d139.6435886757764!3d35.42815267267006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185da7193477df%3A0x107058e1a8b1e5af!2z44OT44K544OI44OtIOOCsOODqeODs-ODtOOCo-ODqeODvOOCuOODpQ!5e0!3m2!1sja!2sjp!4v1777282308434!5m2!1sja!2sjp', $access_post_id);
$legacy_map      = bgv_get_field('google_map_embed',    '', $access_post_id);
$map_link_url    = bgv_get_field('google_map_link_url', '', $access_post_id);
$parking_info    = bgv_get_field('parking_info',        '', $access_post_id);
$remarks         = bgv_get_field('remarks',             '', $access_post_id);
$tel_href        = preg_replace('/[^0-9+]/', '', $phone_number);
?>
<section id="home_access">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Access &amp; Hours</span>
      <h3 class="section-title">アクセス・営業時間</h3>
    </div>
    <div class="access-grid lazy">

      <div class="google-maps">
        <?php if ($map_embed_url) : ?>
          <iframe src="<?php echo esc_url($map_embed_url); ?>"
            width="600" height="450" style="border:0;"
            allowfullscreen loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Google Map"></iframe>
        <?php elseif ($legacy_map) : ?>
          <?php echo wp_kses($legacy_map, array(
            'iframe' => array(
              'src' => true, 'width' => true, 'height' => true,
              'style' => true, 'allowfullscreen' => true,
              'loading' => true, 'referrerpolicy' => true,
              'title' => true,
            ),
          )); ?>
        <?php endif; ?>
      </div>

      <div class="access-info-card">
        <?php if ($store_name) : ?>
          <div class="access-name"><?php echo esc_html($store_name); ?></div>
        <?php endif; ?>

        <div class="access-row">
          <span class="access-row-label">Address</span>
          <span class="access-row-val">
            <?php if ($postal_code) : ?><?php echo esc_html($postal_code); ?><br /><?php endif; ?>
            <?php echo wp_kses_post($address); ?>
            <?php if ($access_text) : ?><br /><?php echo wp_kses_post($access_text); ?><?php endif; ?>
          </span>
        </div>

        <div class="access-row">
          <span class="access-row-label">Tel</span>
          <span class="access-row-val">
            <a href="tel:<?php echo esc_attr($tel_href); ?>"><?php echo esc_html($phone_number); ?></a>
            <?php if ($map_link_url) : ?>
              <br /><a href="<?php echo esc_url($map_link_url); ?>" target="_blank" rel="noopener">Googleマップで見る →</a>
            <?php endif; ?>
          </span>
        </div>

        <div class="access-row">
          <span class="access-row-label">Hours</span>
          <span class="access-row-val">
            <?php if ($business_hours) : ?>
              <?php echo wp_kses_post($business_hours); ?>
            <?php else : ?>
              <table class="time">
                <thead>
                  <tr>
                    <th></th>
                    <th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th><th>日</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th><?php echo wp_kses_post($lunch_hours); ?></th>
                    <td>×</td><td>×</td><td>○</td><td>○</td><td>○</td><td>○</td><td>×</td>
                  </tr>
                  <tr>
                    <th><?php echo wp_kses_post($dinner_hours); ?></th>
                    <td>×</td><td>○</td><td>○</td><td>○</td><td>○</td><td>○</td><td>×</td>
                  </tr>
                </tbody>
              </table>
            <?php endif; ?>
          </span>
        </div>

        <div class="access-row">
          <span class="access-row-label">Holiday</span>
          <span class="access-row-val"><?php echo wp_kses_post($regular_holiday); ?></span>
        </div>

        <?php if ($parking_info) : ?>
        <div class="access-row">
          <span class="access-row-label">Parking</span>
          <span class="access-row-val"><?php echo wp_kses_post($parking_info); ?></span>
        </div>
        <?php endif; ?>

        <?php if ($remarks) : ?>
        <div class="access-row">
          <span class="access-row-label">Note</span>
          <span class="access-row-val"><?php echo wp_kses_post($remarks); ?></span>
        </div>
        <?php endif; ?>

      </div><!-- /.access-info-card -->

    </div><!-- /.access-grid -->
  </div><!-- /.container -->
</section>
