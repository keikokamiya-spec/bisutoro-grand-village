<?php
$access_page = get_page_by_path('access');
$access_post_id = $access_page ? $access_page->ID : get_the_ID();
$address = bgv_get_field('address', '〒231-0846<br />神奈川県横浜市中区大和町2-50-7<br />ヴィラ山手1F', $access_post_id);
$access_text = bgv_get_field('access_text', 'JR京浜東北根岸線山手駅より１分', $access_post_id);
$lunch_hours = bgv_get_field('lunch_hours', '11:30-14:30 <br class="sp_only" />(ラストオーダー14:00)', $access_post_id);
$dinner_hours = bgv_get_field('dinner_hours', '17:30-22:00 <br class="sp_only" />(ラストオーダー21:00)', $access_post_id);
$regular_holiday = bgv_get_field('regular_holiday', '定休日：日曜日、月曜日<br />火曜日のランチ<br />（祝日の場合は変更あり）', $access_post_id);
$business_hours = bgv_get_field('business_hours', '', $access_post_id);
$map = bgv_get_field('google_map_embed', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3251.075783275786!2d139.6435886757764!3d35.42815267267006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185da7193477df%3A0x107058e1a8b1e5af!2z44OT44K544OI44OtIOOCsOODqeODs-ODtOOCo-ODqeODvOOCuOODpQ!5e0!3m2!1sja!2sjp!4v1777282308434!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', $access_post_id);
?>
<section id="home_access">
  <div class="container">
    <h3 class="common">アクセス<span>Access</span></h3>
    <div class="row">
      <div class="span5">
        <div class="google-maps">
          <?php echo wp_kses($map, array(
            'iframe' => array(
              'src' => true,
              'width' => true,
              'height' => true,
              'style' => true,
              'allowfullscreen' => true,
              'loading' => true,
              'referrerpolicy' => true,
            ),
          )); ?>
        </div>
      </div>
      <div class="span7">
        <?php echo wp_kses_post($address); ?><br />
        <?php if ($access_text) : ?><?php echo wp_kses_post($access_text); ?><br /><?php endif; ?>
        <br />
        <i class="fa fa-phone-square" aria-hidden="true"></i> 045-305-6619<br />
        <?php if ($business_hours) : ?>
          <p class="marg-top10"><?php echo wp_kses_post($business_hours); ?></p>
        <?php endif; ?>
        <table class="time">
          <tr>
            <th width="37%"></th>
            <th width="9%">月</th>
            <th width="9%">火</th>
            <th width="9%">水</th>
            <th width="9%">木</th>
            <th width="9%">金</th>
            <th width="9%">土</th>
            <th width="9%">日</th>
          </tr>
          <tr>
            <th><?php echo wp_kses_post($lunch_hours); ?></th>
            <td>×</td><td>×</td><td>○</td><td>○</td><td>○</td><td>○</td><td>×</td>
          </tr>
          <tr>
            <th><?php echo wp_kses_post($dinner_hours); ?></th>
            <td>×</td><td>○</td><td>○</td><td>○</td><td>○</td><td>○</td><td>×</td>
          </tr>
        </table>
        <p class="marg-top10" align="right"><?php echo wp_kses_post($regular_holiday); ?></p>
      </div>
    </div>
  </div>
</section>
