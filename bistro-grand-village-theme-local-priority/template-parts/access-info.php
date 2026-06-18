<?php
$access_page = get_page_by_path('access');
$access_post_id = $access_page ? $access_page->ID : get_the_ID();
$postal_code = bgv_get_field('postal_code', '〒231-0846', $access_post_id);
$address = bgv_get_field('address', '神奈川県横浜市中区大和町2-50-7<br />ヴィラ山手1F', $access_post_id);
$phone_number = bgv_get_field('phone_number', '045-305-6619', $access_post_id);
$access_text = bgv_get_field('access_text', 'JR京浜東北根岸線 山手駅より１分', $access_post_id);
$lunch_hours = bgv_get_field('lunch_hours', '11:30〜14:30<br />(L.O. 14:00)', $access_post_id);
$dinner_hours = bgv_get_field('dinner_hours', '17:30〜22:00<br />(L.O. 21:00)', $access_post_id);
$regular_holiday = bgv_get_field('regular_holiday', '日曜日、月曜日<br />火曜日のランチ（祝日の場合は変更あり）', $access_post_id);
$business_hours = bgv_get_field('business_hours', '', $access_post_id);
$map_embed_url = bgv_get_field('google_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3251.075783275786!2d139.6435886757764!3d35.42815267267006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185da7193477df%3A0x107058e1a8b1e5af!2z44OT44K544OI44OtIOOCsOODqeODs-ODtOOCo-ODqeODvOOCuOODpQ!5e0!3m2!1sja!2sjp!4v1777282308434!5m2!1sja!2sjp', $access_post_id);
$parking_info = bgv_get_field('parking_info', '', $access_post_id);
$remarks = bgv_get_field('remarks', '', $access_post_id);
$tel_href = preg_replace('/[^0-9+]/', '', $phone_number);
$access_day_labels = bgv_access_day_labels();
$access_schedule_rows = bgv_get_access_schedule_rows($access_post_id);
?>
<section id="home_access">
  <div class="container">
    <h3 class="common section-heading" data-num="05">アクセス・営業時間<span>Access &amp; Hours</span></h3>
    <div class="row lazy">
      <div class="span5">
        <div class="google-maps">
          <?php if ($map_embed_url) : ?>
            <iframe src="<?php echo esc_url($map_embed_url); ?>" width="600" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Google Map"></iframe>
          <?php endif; ?>
        </div>
      </div>
      <div class="span7">
        <dl class="top_info">
          <dt>住所</dt>
          <dd><?php echo esc_html($postal_code); ?><br /><?php echo wp_kses_post($address); ?><?php if ($access_text) : ?><br /><?php echo wp_kses_post($access_text); ?><?php endif; ?></dd>
          <dt>電話</dt>
          <dd><a href="tel:<?php echo esc_attr($tel_href); ?>"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo esc_html($phone_number); ?></a></dd>
          <dt>定休日</dt>
          <dd><?php echo wp_kses_post($regular_holiday); ?></dd>
        </dl>
        <div class="table-scroll">
          <table class="time">
            <thead>
              <tr>
                <th></th>
                <?php foreach ($access_day_labels as $day_label) : ?>
                  <th><?php echo esc_html($day_label); ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><?php echo wp_kses_post($lunch_hours); ?></th>
                <?php foreach ($access_day_labels as $day_key => $day_label) : ?>
                  <td><?php echo esc_html(isset($access_schedule_rows['lunch'][$day_key]) ? $access_schedule_rows['lunch'][$day_key] : ''); ?></td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <th><?php echo wp_kses_post($dinner_hours); ?></th>
                <?php foreach ($access_day_labels as $day_key => $day_label) : ?>
                  <td><?php echo esc_html(isset($access_schedule_rows['dinner'][$day_key]) ? $access_schedule_rows['dinner'][$day_key] : ''); ?></td>
                <?php endforeach; ?>
              </tr>
            </tbody>
          </table>
        </div>
        <?php if ($business_hours) : ?>
          <p class="marg-top10"><?php echo wp_kses_post($business_hours); ?></p>
        <?php endif; ?>
        <?php if ($parking_info) : ?>
          <p class="marg-top10"><?php echo wp_kses_post($parking_info); ?></p>
        <?php endif; ?>
        <?php if ($remarks) : ?>
          <p class="marg-top10"><?php echo wp_kses_post($remarks); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
