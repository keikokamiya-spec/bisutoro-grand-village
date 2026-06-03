<?php
$defaults = bgv_default_kokuban_images();
$image_1 = bgv_image_url(bgv_get_field('blackboard_image_1'), $defaults[0]['url']);
$image_2 = bgv_image_url(bgv_get_field('blackboard_image_2'), $defaults[1]['url']);
?>
<div class="kokuban-menu-images">
  <?php if ($image_1) : ?>
    <img width="945" height="705" src="<?php echo esc_url($image_1); ?>" alt="黒板メニュー" decoding="async" fetchpriority="high" />
  <?php endif; ?>
  <?php if ($image_2) : ?>
    <img width="934" height="698" src="<?php echo esc_url($image_2); ?>" alt="黒板メニュー" decoding="async" loading="lazy" />
  <?php endif; ?>
</div>

